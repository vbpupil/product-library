<?php


namespace vbpupil\ProductLibrary\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Product\AbstractProduct;
use vbpupil\ProductLibrary\Product\GeneralProduct;

/**
 * A GENERAL PRODUCT IS A PRODUCT WITH MULTIPLE VARIATIONS
 *
 * Class GeneralProductBuilder
 * @package vbpupil\Builder
 */
class GeneralProductBuilder implements ProductBuilderInterface
{

    /**
     * @var
     */
    public $product;

    /**
     *
     */
    public function initProduct(string $style)
    {
        $this->product = new GeneralProduct($style);
    }

    /**
     * @return AbstractProduct
     * @throws \Exception
     */
    public function getProduct(): GeneralProduct
    {
        try {
            return $this->product;
        } catch (\Exception $e) {
            throw new \Exception("Unable to build GeneralProduct: {$e->getMessage()}");
        }
    }

    /**
     * @return mixed
     */
    public function setName(string $name)
    {
        $this->product->setName($name);
    }

    /**
     * @return mixed
     */
    public function setDescriptions(Collection $descriptions)
    {
        $this->product->setDescriptions($descriptions);
    }

    /**
     * @return mixed
     */
    public function setVariations(Collection $variations)
    {
        $this->product->setVariations($variations);
    }

    /**
     * @return mixed
     */
    public function setLive(bool $live)
    {
        $this->product->setLive($live);
    }
}
