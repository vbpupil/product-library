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
     * @param int $value
     * @param float $rate
     * @return float|int
     */
    public function addVatByRate(int $value, float $rate)
    {
        return ($value * (($rate / 100) + 1));
    }

    /**
     * @param int $value
     * @param float $rate
     * @return float|int
     */
    public function getVatElement(int $value, float $rate)
    {
        return (($value * (($rate / 100) + 1)) - $value);
    }
}