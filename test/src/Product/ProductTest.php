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
use Vbpupil\Collection\Collection;
use vbpupil\Product\Product;

class ProductTest extends TestCase
{
    protected $sut;

    public function setUp()
    {
        $this->description = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->variations = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();


        $this->simpleVariation = $this->getMockBuilder(SimpleVariation::class)
            ->disableOriginalConstructor()
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->sut = new Product();
    }

    public function testNewingUpAProduct()
    {
        try {
            $this->sut = new Product(
                'ball',
                new Collection()
            );
            $this->assertTrue($this->sut instanceof Product);


            $this->sut = new Product(null, new Collection());
        } catch (\Exception $e) {
            $this->assertEquals('Product name required.', $e->getMessage());
        }
    }

    public function testGetAndSetName()
    {
        $this->sut->setName('Bike');
        $this->assertEquals('Bike', $this->sut->getName());
    }

    public function testLive()
    {
        $this->sut = new Product(
            'ball',
            new Collection()
        );

        $this->assertEquals(false, $this->sut->isLive());

        $this->sut->setLive(true);
        $this->assertEquals(true, $this->sut->isLive());
    }


//    public function testAddingVariations()
//    {
//        $this->variations
//            ->expects($this->once())
//            ->method('getItems')
//            ->will($this->returnValue(
//                [$this->simpleVariation]
//            ));
//
//        $this->sut->setVariations(
//            $this->variations
//        );
//    }

    public function testWrongTypeAdded()
    {
        try {
            $this->variations
                ->expects($this->once())
                ->method('getItems')
                ->will($this->returnValue(
                    ['test', 'test2']
                ));

            $this->sut->setVariations(
                $this->variations
            );
        }catch(\Exception $e){
//            echo $e->getMessage();
            $this->assertEquals('Incompatible type, must be/extend from SimpleVariation', $e->getMessage());
        }
    }

    public function setDescription()
    {
        
    }


}
