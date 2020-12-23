<?php


namespace vbpupil\ProductLibrary\Price;


use vbpupil\ProductLibrary\Exception\InvalidProductSetupException;
use vbpupil\ProductLibrary\Price\Traits\PriceTrait;
use vbpupil\ProductLibrary\Traits\ClassTrait;
use vbpupil\ProductLibrary\Traits\JsonValidateTrait;

/**
 * Class PivotPrice
 * @package vbpupil\Price
 */
class PivotPrice implements PriceInterface
{
    use PriceTrait, JsonValidateTrait, ClassTrait;

    /**
     * @var array
     */
    protected $required = ['currency', 'vatRate', 'vatRateId', 'pivot'];

    /**
     * @var int
     */
    protected $exVat, $vatRate, $specialPrice, $wasPrice = null, $unitPrice, $cheapest;

    /**
     * @var bool
     */
    protected $specialPriceActive = false, $showSpecialOfferCountdown = false;

    /**
     * @var string
     */
    protected $specialPriceActiveUntil, $symbol, $currency;

    /**
     * @var int
     */
    protected $vatRateId;

    /**
     * @var string
     */
    protected $timestampNow;

    /**
     * @var array
     */
    protected $pivot;

    /**
     * PivotPrice constructor.
     *
     * the constructor expects to be given an assoc array of the required values to get the ball rolling
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new InvalidProductSetupException('Required Pivot Price Values must be provided');
        }

        foreach ($values as $k => $v) {
            $k = ucfirst($k);
            $methodName = "set{$k}";
            $this->{$methodName}($v);
        }

        $this->verifyRequired();
        $this->timestampNow = strtotime('now');

    }

    /**
     * lets test that we have what we need to proceed
     *
     * @throws \Exception
     */
    public function verifyRequired()
    {
        //1. create the tmp array
        $tmpRequired = [];
        foreach ($this->required as $r) {
            $tmpRequired[$r] = 0;
        }

        $err = '';

        //2. verify if value is present
        foreach ($this->required as $r) {
            if (isset($this->{$r})) {
                $this->validateProductPriceAttribute($r, $this->{$r}, $err);

                unset($tmpRequired[$r]);
            }
        }

        //3. moan about it if we have to
        if ($err !== '') {
            throw new InvalidProductSetupException($err);
        }

        if (!empty($tmpRequired)) {
            $err = implode(', ', array_keys($tmpRequired));
            throw new InvalidProductSetupException("Missing Required Fields: {$err}");
        }
    }

    /**
     * @param string $pivot
     * @throws \Exception
     */
    public function setPivot(string $pivot)
    {
        //1 check that we have something text to work with
        if ($pivot == '{}' || empty($pivot)) {
            throw new \Exception('Empty Pivot data provided');
        }

        //2 check that its valid json
        if (!$this->isJson($pivot)) {
            throw new \Exception('Invalid JSON string for pivot prices');
        } else {
            $pivot = json_decode($pivot, true);
        }

        //4 basic check to ensure we have a price set and upper i greater that lower bounds
        $this->pivot = array_filter($pivot, function ($a) {
            return ($a['price'] > 0 && $a['qty'] > 0);
        });

        //3 now lets order data in order of qty
        usort($this->pivot, function ($a, $b) {
            return $a['qty'] > $b['qty'];
        });


        if (count($this->pivot) == 0) {
            throw new \Exception('No valid pivot prices found');
        }
    }

    /**
     * filters down what we know about the prices and throws out the final prices
     * price is based on qty requested
     *
     * @param bool $includingVat
     * @param bool $convertToFloat
     * @param int $qty
     * @return float|int|null
     * @throws \Exception
     */
    public function getPrice(
        bool $includingVat = false,
        bool $convertToFloat = false,
        int $qty = 1
    )
    {
        $price = null;

        if (is_null($price)) {
            $price = $this->getExVat($qty);
        }

        //add vat if required
        if ($includingVat) {
            $price = $this->addVatByRate($price, $this->getVatRate());
        }

        //leave as int or return human readable float?
        if ($convertToFloat) {
            return ($price / 100);
        }

        $this->setUnitPrice($price / $qty);
        return $price;
    }


    public function getCheapest()
    {
        $pivots = $this->getPivot();

        usort($pivots, function ($a, $b) {
            return $a['price'] > $b['price'];
        });

        return $pivots[0];
    }

    /**
     * @param bool $dynamicValue
     * @return int
     * @throws \Exception
     */
    public function getExVat(int $qty = 1): int
    {
        if ($qty < 1) {
            throw new \Exception('min qty required for price lookup is 1');
        }

        $price = null;

        $reversed = array_reverse($this->getPivot());
        $highstQty = null;

        foreach ($reversed as $pivot) {
            if (!is_null($highstQty) && $highstQty > $pivot['qty']) {
                break;
            }

            if ($qty >= $pivot['qty']) {
                $highstQty = $pivot['qty'];
                $price = $pivot['price'];
            }
        }

        if (is_null($price)) {
            throw new \Exception('No price found');
        }

        return $price * $qty;
    }

    /**
     * @param int $exVat
     * @return PivotPrice
     * @throws InvalidProductSetupException
     */
    public function setExVat($exVat): PivotPrice
    {
        if (is_string($exVat) || is_float($exVat)) {
            throw new InvalidProductSetupException('ExVat prices must be an INT');
        }

        $this->exVat = $exVat;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * set the currency type ie GBP
     * this will also set the symbol - ie &pound;
     * @param string $currency
     * @return PivotPrice
     */
    public function setCurrency(string $currency): PivotPrice
    {
        $this->currency = $currency;

        $this->setSymbol($currency);

        return $this;
    }

    /**
     * @return int
     */
    public function getVatRate(): int
    {
        return $this->vatRate;
    }

    /**
     * @param int $vatRate
     * @return PivotPrice
     */
    public function setVatRate(int $vatRate): PivotPrice
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getVatRateId(): int
    {
        return $this->vatRateId;
    }

    /**
     * @param int $vatRateId
     */
    public function setVatRateId(int $vatRateId): void
    {
        $this->vatRateId = $vatRateId;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return PivotPrice
     */
    public function setSymbol(string $symbol): PivotPrice
    {
        switch ($symbol) {
            case 'GBP':
                $symbol = '&pound;';
                break;
        }

        $this->symbol = $symbol;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString(int $qty = 1)
    {
        $exVatPrice = $this->getPrice(false, true, $qty);
        $exVatPriceString = number_format($exVatPrice, 2, '.', '.');
        $vatRate = $this->getVatRate();
        $vatElement = $this->getVatElement($exVatPrice, $vatRate);
        $vatElementSting = number_format($vatElement, 2, '.', '.');
        $incVatPriceString = number_format(($exVatPrice + $vatElement), 2, '.', '.');


        return <<<EOD
*******************************<br>
Currency: {$this->getCurrency()}<br>
Symbol: {$this->getSymbol()}<br>
Vat Rate: {$vatRate}<br><br>
Price (Ex VAT): {$exVatPriceString}<br>
Vat Element: {$vatElementSting}<br>
Price (Inc VAT): {$incVatPriceString}<br><br>
Special Price Active: {$isSpecialPriceActive}<br>
*******************************
EOD;
    }

    /**
     * @return array
     */
    public function getPivot(): array
    {
        return $this->pivot;
    }

    /**
     * @return bool
     */
    public function isOnSpecial(): bool
    {
        return false;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice(int $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }


}