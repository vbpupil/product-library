<?php


namespace vbpupil\Price;


use vbpupil\Exception\InvalidProductSetupException;
use vbpupil\Price\Traits\PriceTrait;
use vbpupil\Variation\Validation\VariantValidationTrait;

/**
 * Class SinglePrice
 * @package vbpupil\Price
 */
class SinglePrice implements PriceInterface
{

    use VariantValidationTrait, PriceTrait;

    /**
     * @var array
     */
    protected $required = ['exVat', 'currency', 'vatRate', 'specialPriceActive'];

    /**
     * @var int
     */
    protected $exVat, $vatRate, $specialPrice, $wasPrice = null;


    /**
     * @var bool
     */
    protected $specialPriceActive = false, $showSpecialOfferCountdown = false;

    /**
     * @var string
     */
    protected $specialPriceActiveUntil, $symbol, $currency;

    /**
     * @var string
     *
     * used in timestamp calculations such as when comparing dates to see if special prices is still valid
     */
    protected $timestampNow;


    /**
     * SinglePrice constructor.
     *
     * the constructor expects to be given an assoc array of the required values to get the ball rolling
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new InvalidProductSetupException('Required Price Values must be provided');
        }

        foreach ($values as $k => $v) {
            $k = ucfirst($k);
            $methodName = "set{$k}";
            $this->{$methodName}($v);
        }

        if (isset($this->specialPriceActive) && $this->specialPriceActive) {
            $this->required[] = 'specialPriceActiveUntil';
            $this->required[] = 'specialPrice';
        }

        $this->verifyRequired();
        $this->timestampNow = strtotime('now');

        $this->setWasPrice($this->exVat);
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
     * @return bool
     */
    public function isOnSpecial(): bool
    {
        if (isset($this->specialPriceActive) && $this->specialPriceActive) {
            $specialPriceExpiry = strtotime($this->specialPriceActiveUntil);

            if (
                (isset($specialPriceExpiry) && ($specialPriceExpiry >= $this->timestampNow)) &&
                (isset($this->specialPrice) && $this->specialPrice > 0)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * filters down what we know about he prices and throws out the final prices
     * @param bool $includingVat
     * @param bool $convertToFloat
     * @return float|int|null
     * @throws \Exception
     */
    public function getPrice(bool $includingVat = false, bool $convertToFloat = false, int $qty = 1, bool $evaluateWasPrice = true)
    {
        $price = null;

        //check to see if qualifies for the special prices
        if ($this->isOnSpecial()) {
            $price = $this->getSpecialPrice($qty);
//            if ($evaluateWasPrice) {
//                $this->calculateWasPrice($includingVat, $qty);
//            }
        }

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
     * dynamic value will check if there is a special offer set and if so get ex vat of that instead
     *
     * @param bool $dynamicValue
     * @return int
     * @throws \Exception
     */
    public function getExVat(bool $dynamicValue = false, int $qty = 1): int
    {
        if ($dynamicValue) {
            if ($this->isOnSpecial()) {
                return $this->getPrice(false, false, $qty, false);
            }
        }

        return $this->exVat * $qty;
    }

    /**
     * @param int $exVat
     * @return SinglePrice
     * @throws InvalidProductSetupException
     */
    public function setExVat($exVat): SinglePrice
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
     * @return SinglePrice
     */
    public function setCurrency(string $currency): SinglePrice
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
     * @return SinglePrice
     */
    public function setVatRate(int $vatRate): SinglePrice
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getSpecialPrice(int $qty = 1): int
    {
        return ($this->specialPrice * $qty);
    }

    /**
     * @param int $specialPrice
     * @return SinglePrice
     */
    public function setSpecialPrice(int $specialPrice): SinglePrice
    {
        $this->specialPrice = $specialPrice;
        return $this;
    }

    /**
     * @param bool $specialPriceActive
     * @return SinglePrice
     */
    public function setSpecialPriceActive(bool $specialPriceActive): SinglePrice
    {
        $this->specialPriceActive = $specialPriceActive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpecialPriceActiveUntil()
    {
        return $this->specialPriceActiveUntil;
    }

    /**
     * @param mixed $specialPriceActiveUntil
     * @return SinglePrice
     */
    public function setSpecialPriceActiveUntil($specialPriceActiveUntil)
    {
        $this->specialPriceActiveUntil = $specialPriceActiveUntil;
        return $this;
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
     * @return SinglePrice
     */
    public function setSymbol(string $symbol): SinglePrice
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
        $isSpecialPriceActive = var_export($this->isOnSpecial(), 1);
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
     * @param int $qty
     * @return int
     */
    public function getWasPrice(int $qty = 1)
    {
//        if (is_null($this->wasPrice)) {
//            $this->calculateWasPrice($includingVat, $qty);
//        }

        return $this->wasPrice * $qty;
    }

    /**
     * @param int $wasPrice
     */
    public function setWasPrice(int $wasPrice): void
    {
        $this->wasPrice = $wasPrice;
    }

    /**
     * @return bool
     */
    public function showSpecialOfferCountdown(): bool
    {
        return $this->showSpecialOfferCountdown;
    }

    /**
     * @param bool $showSpecialOfferCountdown
     */
    public function setShowSpecialOfferCountdown(bool $showSpecialOfferCountdown): void
    {
        $this->showSpecialOfferCountdown = $showSpecialOfferCountdown;
    }



//    public function calculateWasPrice(bool $includingVat = false, int $qty = 1)
//    {
//        $this->wasPrice = ($includingVat ?
//            intval(
//                ceil(
//                    $this->addVatByRate(
//                        $this->getExVat(),
//                        $this->getVatRate(),
//                        $qty
//                    )
//                )
//            ) : $this->getExVat(true, $qty));
//    }


}