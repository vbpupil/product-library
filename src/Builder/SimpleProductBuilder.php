<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\Product\Product;

/**
 * A SIMPLE PRODUCT IS JUST THE PRODUCT - IE NO VARIANTS
 *
 * Class SimpleProductBuilder
 * @package vbpupil\Builder
 */
class SimpleProductBuilder implements ProductBuilderInterface
{

    /**
     * @var
     */
    public $product;


    /**
     * SimpleProductBuilder constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     *
     */
    public function reset()
    {
        $this->product = new Product();
    }

    /**
     * @return Product
     * @throws \Exception
     */
    public function getProduct(): Product
    {
        try {
            $result = $this->product;
            $this->reset();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception("Unable to build SimpleProduct: {$e->getMessage()}");
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
        //no variations exist for a simple product
//        $this->product->setVariations($variations);
    }

    /**
     * @return mixed
     */
    public function setLive(bool $live)
    {
        $this->product->setLive($live);
    }
}