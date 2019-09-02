<?php
/**
 * VariationTest.php Class
 *
 * @author    Dean Haines
 * @copyright 2019, UK
 * @license   Proprietary See LICENSE.md
 */

namespace test\vbpupil\Product;

use PHPUnit\Framework\TestCase;
use vbpupil\Product\Product;
use vbpupil\Product\SimpleVariation;

class VariationTest extends TestCase
{
    protected $sut;


    public function testNewingUpAVariation()
    {
        $this->sut = new SimpleVariation('ball');
        $this->assertTrue($this->sut instanceof SimpleVariation);
    }


}
