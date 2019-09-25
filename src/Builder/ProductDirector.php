<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;

class ProductDirector
{
    public function buildSimpleProduct(SimpleProductBuilder $product)
    {
        $p = $product->getProduct();
        $p->setName('Simple Product');
        $p->setDescriptions(new Collection());

        unset($p->variations);

        return $p;
    }

    public function buildGeneralProduct(GeneralProductBuilder $product)
    {
        $p = $product->getProduct();
        $p->setName('General Product');
        $p->setDescriptions(new Collection());
        $p->setVariations(new Collection());

        return $p;
    }
}