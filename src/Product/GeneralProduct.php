<?php


namespace vbpupil\Product;


use Vbpupil\Collection\Collection;

class GeneralProduct extends SimpleProduct
{
    public $variations;

    /**
     * @param mixed $variations
     */
    public function setVariations(Collection $variations): void
    {
        $this->variations = $variations;
    }




}