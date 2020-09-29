<?php
/**
 * SimpleStockTest.php.
 * Version: 1.0.0 (11/09/19)

 * Author:   Dean Haines
 */


namespace src\Stock;


use PHPUnit\Framework\TestCase;
use vbpupil\ProductLibrary\Stock\SimpleStock;

class SimpleStockTest extends TestCase
{

    protected $sut;

    public function setUp()
    {
        $this->sut = new SimpleStock(12);
    }

    public function testGetStock()
    {
        $this->assertEquals(12, $this->sut->getStock());
    }

    public function testSetStock()
    {
        $this->assertTrue($this->sut->setStock(5) instanceof SimpleStock);
        $this->assertEquals(5, $this->sut->getStock());
    }
}