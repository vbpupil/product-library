<?php
/**
 * GeneralSimpleProduct.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Product;

use Vbpupil\Collection\Collection;
use vbpupil\Variation\AbstractVariation;

class GeneralSimpleProduct extends AbstractProduct
{

    /**
     * GeneralSimpleProduct constructor.
     */
    public function __construct()
    {
        $this->style = 'general_simple';
    }

    /**
     * @param Collection $variations
     * @throws \Exception
     */
    public function setVariations(Collection $variations): void
    {
        foreach ($variations->getItems() as $v) {
            if (!is_a($v, AbstractVariation::class)) {
                throw new \Exception('Incompatible type, must be/extend from AbstractVariation');
            }
        }

        $this->variations = $variations;
    }

}
