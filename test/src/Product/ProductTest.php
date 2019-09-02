<?php
/**
 * ProductTest.php Class
 *
 * @author    Dean Haines
 * @copyright 2019, UK
 * @license   Proprietary See LICENSE.md
 */

namespace test\vbpupil\Product;

use PHPUnit\Framework\TestCase;
use vbpupil\Product\Product;

class ProductTest extends TestCase
{
    protected $sut;


    public function testNewingUpAProduct()
    {
        try {
            $this->sut = new Product('ball');
            $this->assertTrue($this->sut instanceof Product);


            $this->sut = new Product();
        } catch (\Exception $e) {
            $this->assertEquals('A product name is required.', $e->getMessage());
        }
    }

    public function testSetAndGetName()
    {
            $this->sut = new Product('ball');
            $this->assertEquals('ball', $this->sut->getName());

            $this->sut->setName('ball2');
            $this->assertEquals('ball2', $this->sut->getName());
    }

    public function testSetAndGetId()
    {
            $this->sut = new Product('ball');

            $this->sut->setId(123);

            $this->assertEquals(123, $this->sut->getId());
    }

    public function testSetAndGetDescripion()
    {
            $this->sut = new Product('ball');

            $this->sut->setDescription('intro', 'i am an intro.');
            $this->sut->setDescription('short', 'i am the short desc.');


            $this->assertEquals('i am an intro.', $this->sut->getDescription('intro'));
            $this->assertEquals('i am the short desc.', $this->sut->getDescription('short'));
    }

    public function testSetAndGetDescripionNotExistException()
    {
        try {
            $this->sut = new Product('ball');
            $this->sut->getDescription('intro');
        } catch (\Exception $e) {
            $this->assertEquals('Description intro does not exist.', $e->getMessage());
        }
    }

    public function testGetDescripionsArray()
    {
            $this->sut = (new Product('ball'))
                ->setDescription('intro', 'intro text')
                ->setDescription('short', 'short text');


            $this->assertTrue(is_array($this->sut->getDescription()));
            $this->assertArrayHasKey('intro', $this->sut->getDescription());
            $this->assertArrayHasKey('short', $this->sut->getDescription());

    }


}
