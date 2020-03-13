<?php
/**
 * SimpleVariationTest.phpst.php Class
 *
 * @author    Dean Haines
 * @copyright 2019, UK
 * @license   Proprietary See LICENSE.md
 */

namespace test\vbpupil\Variation;

use PHPUnit\Framework\TestCase;
use vbpupil\Exception\InvalidVariationSetupException;
use vbpupil\Variation\SimpleVariation;

class SimpleVariationTest extends TestCase
{
    protected $sut;


    public function testNewingUpAVariation()
    {
        $this->sut = new SimpleVariation(
            [
                'ProductCode' => '532095',
                'title' => 'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB'
            ]
        );

        $this->assertTrue($this->sut instanceof SimpleVariation);

        try {
            $sv = new SimpleVariation([]);
        } catch (InvalidVariationSetupException $e) {
            $this->assertEquals('Required Values must be provided', $e->getMessage());
        }
    }


    public function testGetAttributes()
    {
        $this->sut = new SimpleVariation(
            [
                'ProductCode' => '532095',
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

    public function testProductCodeSettingThrowsAnException()
    {
        try {
            $sv = new SimpleVariation([
                'ProductCode' => '',
                'title' => 'SONY PlayStation 4'
            ]);
        } catch (\Exception $e) {
            $this->assertEquals('Product code cannot be empty.', $e->getMessage());
        }

        try {
            $sv = new SimpleVariation([
                'title' => 'SONY PlayStation 4'
            ]);
        } catch (\Exception $e) {
            $this->assertEquals('Missing Required Fields: ProductCode', $e->getMessage());
        }

    }
}
