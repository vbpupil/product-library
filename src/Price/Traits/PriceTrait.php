<?php
/**
 * PriceTrait.php.
 * Version: 1.0.0 (04/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */

namespace vbpupil\Price\Traits;

trait PriceTrait
{
    /**
     * adds vat rate to a price
     * @param int $value
     * @param float $rate
     * @return float|int
     */
    public function addVatByRate(int $value, float $rate)
    {
        return ($value * (($rate / 100) + 1));
    }

    /**
     * returns just the VAT element
     * @param int $value
     * @param float $rate
     * @return float|int
     */
    public function getVatElement(int $value, float $rate)
    {
        return (($value * (($rate / 100) + 1)) - $value);
    }

    /**
     * @param string $valueName
     * @param bool $includeSymbol
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
}