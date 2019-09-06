<?php
/**
 * PriceInterface.php.
 * Version: 1.0.0 (05/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\Price;


interface PriceInterface
{
    public function getPrice(bool $includingVat = false, bool $convertToFloat = true, int $qty = 1);
}