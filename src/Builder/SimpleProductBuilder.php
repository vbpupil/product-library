<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\Product\Product;

/**
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
     * @param null $name
     * @param Collection $descriptions
     * @param bool $live
     * @throws \Exception
     */
    public function __construct($name = null, Collection $descriptions, $live = false)
    {
        $this->reset($name, $descriptions, $live);
    }

    /**
     * @param $name
     * @param $descriptions
     * @param $live
     * @throws \Exception
     */
    public function reset($name, $descriptions, $live)
    {
        $this->product = new Product($name, $descriptions, $live);
    }

    /**
     * @return Product
     * @throws \Exception
     */
    public function getProduct(): Product
    {
        try {
            $result = $this->product;
//            $this->reset();

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