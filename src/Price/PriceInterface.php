<?php
/**
 * PriceInterface.php.
 * Version: 1.0.0 (05/09/19)
 * Author:   Dean Haines
 */


namespace vbpupil\Price;


interface PriceInterface
{
    public function getPricing(bool $includingVat = false, bool $convertToFloat = true, int $qty = 1);
}