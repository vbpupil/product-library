<?php


namespace vbpupil\ProductLibrary\Price;


use vbpupil\ProductLibrary\Exception\InvalidProductSetupException;
use vbpupil\ProductLibrary\Price\Traits\PriceTrait;

/**
 * Class MatrixPrice
 * @package vbpupil\Price
 */
class MatrixPrice implements PriceInterface
{
    use PriceTrait;

    /**
     * @var array
     */
    protected $required = ['currency', 'vatRate'];

    /**
     * @var int
     */
    protected $vatRate;


    /**
     * @var string
     */
    protected $symbol, $currency;

    /**
     * @var int
     */
    protected $vatRateId;

    /**
     * @var string
     */
    protected $timestampNow;


    /**
     * MatrixPrice constructor.
     *
     * the constructor expects to be given an assoc array of the required values to get the ball rolling
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        //values come in - qty(from - to)|sell (ex vat int)|vat rate|vat rate id|
        // sort out values

        if (empty($values)) {
            throw new InvalidProductSetupException('Required Matrix Price Values must be provided');
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

    public function setMatrix()
    {

    }

    /**
     *
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
            $price = $this->getExVat(false, $qty);
        }

        //add vat if required
        if ($includingVat) {
            $price = $this->addVatByRate($price, $this->getVatRate(), $qty);
        }

        //leave as int or return human readable float?
        if ($convertToFloat) {
            return ($price / 100);
        }

        return $price;
    }


    /**
     * @param bool $dynamicValue
     * @return int
     * @throws \Exception
     */
    public function getExVat(int $qty = 1): int
    {
        return $this->exVat * $qty;
    }

    /**
     * @param int $exVat
     * @return MatrixPrice
     * @throws InvalidProductSetupException
     */
    public function setExVat($exVat): MatrixPrice
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
     * @return MatrixPrice
     */
    public function setCurrency(string $currency): MatrixPrice
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
     * @return MatrixPrice
     */
    public function setVatRate(int $vatRate): MatrixPrice
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
     * @return MatrixPrice
     */
    public function setSymbol(string $symbol): MatrixPrice
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
}