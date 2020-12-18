<?php
/**
 * PhysicalVariationTest.phpst.php Class
 *
 * @author    Dean Haines
 * @copyright 2019, UK
 * @license   Proprietary See LICENSE.md
 */

namespace test\vbpupil\Variation;

use PHPUnit\Framework\TestCase;
use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Exception\InvalidVariationSetupException;
use vbpupil\ProductLibrary\Price\SinglePrice;
use vbpupil\ProductLibrary\Variation\PhysicalVariation;

class PhysicalVariationTest extends TestCase
{
    protected $sut;


    public function testNewingUpAVariation()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->assertTrue($this->sut instanceof PhysicalVariation);

        try {
            $sv = new PhysicalVariation([]);
        } catch (InvalidVariationSetupException $e) {
            $this->assertEquals('Required Values must be provided', $e->getMessage());
        }
    }


    public function testGetAttributes()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->assertEquals('532095', $this->sut->getProductCode());
        $this->assertEquals('SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB', $this->sut->getTitle());

        $this->sut->setTitle('XBOX 1');
        $this->assertEquals('XBOX 1', $this->sut->getTitle());

        $this->sut->setProductCode('XBX001');
        $this->assertEquals('XBX001', $this->sut->getProductCode());
    }


    public function testGettingandSettingQuantities()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->sut->setMinOrderQty(5);
        $this->assertEquals(5, $this->sut->getMinOrderQty());

        $this->sut->setBoxQty(10);
        $this->assertEquals(10, $this->sut->getBoxQty());

        $this->sut->setPackQty(3);
        $this->assertEquals(3, $this->sut->getPackQty());

        $this->sut->setReorderLevel(1);
        $this->assertEquals(1, $this->sut->getReorderLevel());
    }

    public function testGettingandSettingOfVariantId()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->sut->setId(5001);
        $this->assertEquals(5001, $this->sut->getId());
    }

    public function testSetandGetPrice()
    {
        $this->price = $this->getMockBuilder(SinglePrice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPrice'])
            ->getMock();

        $this->price->method('getPrice')->willReturn(1000);

        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->sut->setPrice($this->price);
        $this->assertEquals(1000, $this->sut->getPrice(false));
    }

    public function testSetandGetOptionsCollection()
    {
        $this->options = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->sut->setOptions($this->options);
        $this->assertTrue($this->sut->getOptions() instanceof Collection);
    }

    public function testRequiredFieldsInconstrucor()
    {
        try {
            $this->sut = new PhysicalVariation(
                [
                    'product_code' => '532095',
                ]
            );
        }catch(InvalidVariationSetupException $e){
            $this->assertEquals('Missing Required Fields: title', $e->getMessage());
        }
    }

    public function testSettingAValidBarcode()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        //upc barcode
        $this->sut->setBarcode(950110153000);
        $this->assertEquals(950110153000, $this->sut->getBarcode());

        //ean barcode
        $this->sut->setBarcode(9501101530003);
        $this->assertEquals(9501101530003, $this->sut->getBarcode());

        try {
            //failed 7 digit barcode
            $this->sut->setBarcode(9501101);
            $this->assertEquals(9501101, $this->sut->getBarcode());
        }catch(\Exception $e){
            $this->assertEquals('INVALID barcode identified.', $e->getMessage());
        }
    }


    public function testGettingWeight()
    {
        $this->sut = new PhysicalVariation(
            [
                'product_code' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->sut->setWeight(80);
        $this->assertEquals(80, $this->sut->getWeight());
        $this->assertEquals(160, $this->sut->getWeight(2));
        $this->assertEquals(800, $this->sut->getWeight(10));

    }
}
