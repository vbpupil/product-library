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
     * Product constructor.
     * @param null $name
     * @param Collection $descriptions
     * @param bool $live
     * @throws \Exception
     */
    public function __construct($name = null, Collection $descriptions, $live = false)
    {
        if (is_null($name) || !is_string($name)) {
            throw new \Exception("Product name required.");
        }

        $this->setName($name);
        $this->setDescriptions($descriptions);
        $this->setLive($live);
    }

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
    protected function setDescriptions(Collection $descriptions): Product
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