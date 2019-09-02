<?php


namespace vbpupil\Price;


/**
 * Class SinglePrice
 * @package vbpupil\Price
 */
class SinglePrice
{

    /**
     * @var array
     */
    protected $required = ['exVat', 'currency', 'vatRate', 'specialPrice', 'specialPriceActive', 'specialPriceActiveUntil'];

    /**
     * @var int
     */
    protected $exVat = 0;

    /**
     * @var string
     */
    protected $currency = 'GBP';

    /**
     * @var int
     */
    protected $vatRate = 0;

    /**
     * @var int
     */
    protected $specialPrice = 0;


    /**
     * @var bool
     */
    protected $specialPriceActive = false;

    /**
     * @var
     */
    protected $specialPriceActiveUntil;

    /**
     * @var string
     */
    protected $symbol;


    /**
     * SinglePrice constructor.
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new \Exception('Required Price Values must be provided');
        }

        foreach ($values as $k => $v) {
            $k = ucfirst($k);
            $methodName = "set{$k}";
            $this->{$methodName}($v);
        }

        $this->verifyRequired();
    }

    /**
     * @throws \Exception
     */
    public function verifyRequired()
    {
        //1. create the tmp array
        $tmpRequired = [];
        foreach ($this->required as $r) {
            $tmpRequired[$r] = 0;
        }

        //2. verify if value is present
        foreach ($this->required as $r) {
            if (isset($this->{$r})) {
                unset($tmpRequired[$r]);
            }
        }

        //3. moan about it if we have to
        if (!empty($tmpRequired)) {
            $err = implode(', ', array_keys($tmpRequired));
            throw new \Exception("Missing Required Fields: {$err}");
        }
    }

    /**
     * filters down what we know about he price and throws out the final price
     * @param bool $includingVat
     * @param bool $convertToFloat
     * @return float|int
     */
    public function getPrice(bool $includingVat = false, bool $convertToFloat = true)
    {
        if (
            (isset($this->specialPrice) && $this->specialPrice > 0) &&
            (isset($this->specialPriceActive) && 1 == 1) &&
            (isset($this->specialPriceActiveUntil) && 1 == 1)
        ) {
            $price = $this->getSpecialPrice();
        } else {
            $price = $this->getExVat();
        }

        //add vat if required
        if ($includingVat) {
            $price = ($price * (($this->getVatRate() / 100) + 1));
        }

        //leave as int or return human readable float?
        if ($convertToFloat) {
            return ($price / 100);
        }
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
     */
    public function setExVat(int $exVat): SinglePrice
    {
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
}