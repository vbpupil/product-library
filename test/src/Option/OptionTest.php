<?php
/**
 * OptionTest.php.
 * Version: 1.0.0 (18/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace src\Option;


use PHPUnit\Framework\TestCase;
use vbpupil\Option\Option;

class OptionTest extends TestCase
{

    protected $sut;

    public function setUp()
    {
        $this->sut = new Option(
            1,
            '500GB SATA HDD',
            4000,
            1,
            1200,
            4900,
            150,
            'myprod123',
            '111111111111'
        );
    }

    public function testNewingUp()
    {
        $this->assertTrue($this->sut instanceof Option);
    }

    public function testGettingName()
    {
        $this->assertEquals('500GB SATA HDD', $this->sut->getTitle());
        $this->sut->setTitle('500 GB Hard Disk Drive');
        $this->assertEquals('500 GB Hard Disk Drive', $this->sut->getTitle());
    }

    public function testGettingId()
    {
        $this->assertEquals(1, $this->sut->getId());
    }

    public function testGetPriceExVat()
    {
        $this->assertEquals(4000, $this->sut->getPriceExVat());
    }

    public function testGetCostExVat()
    {
        $this->assertEquals(1200, $this->sut->getCostExVat());

        $this->sut->setCostExVat(null);

        $this->assertEquals(null, $this->sut->getCostExVat());
    }

    public function testGetRrpExVat()
    {
        $this->assertEquals(4900, $this->sut->getRrpExVat());

        $this->sut->setRrpExVat(null);

        $this->assertEquals(null, $this->sut->getRrpExVat());
    }

    public function testGetWeight()
    {
        $this->assertEquals(150, $this->sut->getWeight());

        $this->sut->setWeight(null);

        $this->assertEquals(null, $this->sut->getWeight());
    }

    public function testGetQty()
    {
        $this->assertEquals(1, $this->sut->getQty());

        $this->sut->setQty(5);

        $this->assertEquals(5, $this->sut->getQty());
    }

    public function testGetproduct_code()
    {
        $this->assertEquals('myprod123', $this->sut->getproduct_code());

        $this->sut->setproduct_code('myprod246');

        $this->assertEquals('myprod246', $this->sut->getproduct_code());
    }

    public function testGetEan()
    {
        $this->assertEquals('111111111111', $this->sut->getEan());

        $this->sut->setEan('5555555555555');

        $this->assertEquals('5555555555555', $this->sut->getEan());
    }

    public function testInvalidEan()
    {
        try {
            //12 digit
            $this->sut->setEan('555559999988');
            $this->assertEquals('555559999988', $this->sut->getEan());

            //13 digit
            $this->sut->setEan('7777755555444');
            $this->assertEquals('7777755555444', $this->sut->getEan());

            //invalid ean
            $this->sut->setEan('myean');

        }catch(\Exception $e){
            $this->assertEquals('Invalid EAN.', $e->getMessage());
        }
    }
}