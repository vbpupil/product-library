<?php
/**
 * PriceTrait.php.
 * Version: 1.0.0 (04/09/19)
 * Author:   Dean Haines
 */

namespace vbpupil\ProductLibrary\Price\Traits;

trait PriceTrait
{
    /**
     * adds vat rate to a prices
     * @param int $value
     * @param int $rate
     * @return float|int
     */
    public function addVatByRate(int $value, int $rate, int $qty = 1)
    {
        $rate = ((round(($rate / 100), 2) / 100) + 1);
        return (($value * $rate) * $qty);
    }

    /**
     * returns just the VAT element
     * @param int $value
     * @param int $rate
     * @return float|int
     */
    public function getVatElement(int $value, int $rate, int $qty = 1)
    {
        $rate = ((round(($rate / 100), 2) / 100) + 1);

        return ((($value * $rate) - $value) * $qty);
    }

    /**
     * @param string $getterName
     * @param bool $includeSymbol
     * @param int $decPlaces
     * @param string $decPoint
     * @param string $thousandsSeperator
     * @return string
     * @throws \Exception
     */
    public function formatPrice(string $getterName, bool $includeSymbol = true, int $decPlaces = 2, string $decPoint = '.', string $thousandsSeperator = ',')
    {
        if (!method_exists($this, $getterName)) {
            throw new \Exception("{$getterName} does not exist.");
        }

        $formatted = number_format(
            ((float)$this->{$getterName}() / 100),
            $decPlaces,
            $decPoint,
            $thousandsSeperator
        );

        if ($includeSymbol) {
            return "{$this->getSymbol()}{$formatted}";
        }

        return $formatted;
    }

    /**
     * @param string $type
     * @param string $value
     * @param $errLog
     * @return string
     */
    protected function validateProductPriceAttribute(string $type, $value, string &$errLog)
    {
        switch ($type) {
            case 'specialPriceActiveUntil':
                if (!preg_match('~^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$~', $value)) {
                    $errLog .= "Invalid {$type} Supplied - must be in the format: 2019-01-01 11:42:00<br>";
                }
                break;
        }
    }
}