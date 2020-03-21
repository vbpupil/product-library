<?php
/**
 * PriceFactoryTest.php.
 * Version: 1.0.0 (11/09/19)

 * Author:   Dean Haines
 */


namespace src\Price;


use PHPUnit\Framework\TestCase;
use vbpupil\Price\PriceFactory;
use vbpupil\Price\SinglePrice;

class PriceFactoryTest extends TestCase
{

    public function testingSingleFactory()
    {
        $single = PriceFactory::build('single', ['exVat'=>0, 'currency'=>'GBP', 'vatRate'=>0, 'specialPriceActive'=>false]);
        $this->assertTrue($single instanceof SinglePrice);
    }
}