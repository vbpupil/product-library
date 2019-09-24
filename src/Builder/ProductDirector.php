<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\Product\Product;

class ProductDirector
{
    public function buildSimpleProduct(SimpleProductBuilder $product)
    {
        return $product->getProduct();
    }

    public function buildGeneralProduct(Product $product)
    {
        return $product->getProduct();
    }
}