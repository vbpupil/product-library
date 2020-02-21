<?php


namespace vbpupil\Product;


use Vbpupil\Collection\Collection;
use vbpupil\Variation\SimpleVariation;

class Product
{
    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var Collection
     */
    public $descriptions;

    /**
     * @var bool
     */
    protected $live = false;

    /**
     * @var Collection
     */
    public $variations;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Collection $descriptions
     * @return Product
     */
    public function setDescriptions(Collection $descriptions): Product
    {
        $this->descriptions = $descriptions;
        return $this;
    }

    /**
     * @param Collection $variations
     * @throws \Exception
     */
    public function setVariations(Collection $variations): void
    {
        foreach ($variations->getItems() as $v) {
            if (!is_a($v, SimpleVariation::class)) {
                throw new \Exception('Incompatible type, must be/extend from SimpleVariation');
            }
        }

        $this->variations = $variations;
    }

    /**
     * @return bool
     */
    public function isLive(): bool
    {
        return $this->live;
    }

    /**
     * @param bool $live
     * @return Product
     */
    public function setLive(bool $live): Product
    {
        $this->live = $live;
        return $this;
    }
}