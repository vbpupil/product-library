<?php


namespace src\Price;


use PHPUnit\Framework\TestCase;
use vbpupil\ProductLibrary\Price\PivotPrice;

class PivotPriceTest extends TestCase
{
    protected $sut;

    public function setUp()
    {
        $this->sut = new PivotPrice([
            'pivot' => '[{"qty":"1","price":380},{"qty":"10","price":1510}]',
            'vatRate' => 2000,
            'vatRateId' => 1,
            'currency' => 'GBP'
        ]);
    }
}