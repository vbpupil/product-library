<?php


namespace vbpupil\Product;


use Vbpupil\Collection\Collection;
use vbpupil\Variation\SimpleVariation;

class GeneralProduct extends SimpleProduct
{
    /**
     * @var Collection
     */
    public $variations;

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




}