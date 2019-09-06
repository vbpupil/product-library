<?php


namespace vbpupil\Price;


use vbpupil\Exception\InvalidProductSetupException;
use vbpupil\Price\Traits\PriceTrait;
use vbpupil\Price\Validation\PriceValidationTrait;

/**
 * Class SinglePrice
 * @package vbpupil\Price
 */
class SinglePrice implements PriceInterface
{

    use PriceValidationTrait, PriceTrait;

    /**
     * @var array
     */
    protected $required = ['exVat', 'currency', 'vatRate', 'specialPriceActive'];

    /**
     * @var int
     */
    protected $exVat;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var int
     */
    protected $vatRate;

    /**
     * @var int
     */
    protected $specialPrice;


    /**
     * @var bool
     */
    protected $specialPriceActive = false;

    /**
     * @var string
     */
    protected $specialPriceActiveUntil;

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @var string
     *
     * used in timestamp calculations such as when comparing dates to see if special price is still valid
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
     * filters down what we know about he price and throws out the final price
     * @param bool $includingVat
     * @param bool $convertToFloat
     * @param int $qty
     * @return float|int|null
     * @throws \Exception
     */
    public function getPrice(bool $includingVat = false, bool $convertToFloat = true, int $qty = 1)
    {
        $price = null;

        //check to see if qualifies for the special price
        if (isset($this->specialPriceActive) && $this->specialPriceActive) {
            $specialPriceExpiry = strtotime($this->specialPriceActiveUntil);

            if (
                (isset($specialPriceExpiry) && ($specialPriceExpiry >= $this->timestampNow)) &&
                (isset($this->specialPrice) && $this->specialPrice > 0)
            ) {
                $price = $this->getSpecialPrice();
            }
        }

        if (is_null($price)) {
            $price = $this->getExVat();
        }

        //add vat if required
        if ($includingVat) {
            $price = $this->addVatByRate($price, $this->getVatRate());
        }

        if (is_null($price)) {
            throw new \Exception('Invalid Price Error');
        }

        //leave as int or return human readable float?
        if ($convertToFloat) {
            return ($price / 100);
        }

        return $price;
    }

    /**
     * @return int
     */
    public function getExVat(): int
    {
        return $this->exVat;
    }

    /**
     * @param int $exVat
     * @return SinglePrice
     * @throws InvalidProductSetupException
     */
    public function setExVat($exVat): SinglePrice
    {
        if (is_string($exVat) || is_float($exVat)) {
            throw new InvalidProductSetupException('ExVat price must be an INT');
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
     * @param float $vatRate
     * @return SinglePrice
     */
    public function setVatRate(float $vatRate): SinglePrice
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getSpecialPrice(): int
    {
        return $this->specialPrice;
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
     * @return bool
     */
    public function isSpecialPriceActive(): bool
    {
        return $this->specialPriceActive;
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

    public function toString()
    {
        $exVatPrice = $this->getPrice();
        $exVatPriceString = number_format($exVatPrice, 2, '.', '.');
        $vatRate = $this->getVatRate();
        $vatElement = $this->getVatElement($exVatPrice, $vatRate);
        $vatElementSting = number_format($vatElement, 2, '.', '.');
        $isSpecialPriceActive = var_export($this->isSpecialPriceActive(), 1);
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