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
use vbpupil\Product\SimpleProduct;

class ProductTest extends TestCase
{
    protected $sut;


    public function testNewingUpAProduct()
    {
        try {
            $this->sut = new SimpleProduct(
                'ball',
                new Collection()
            );
            $this->assertTrue($this->sut instanceof SimpleProduct);


            $this->sut = new SimpleProduct(null, new Collection());
        } catch (\Exception $e) {
            $this->assertEquals('Product name required.', $e->getMessage());
        }
    }


}
