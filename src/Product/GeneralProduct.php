<?php
/**
 * GeneralProduct.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Product;

use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Variation\AbstractVariation;

class GeneralProduct extends AbstractProduct
{
    protected $type = 'general';

    /**
     * Get product price (cheapest variation).
     * @return int|float|null
     */
    public function getPrice(bool $includingVat = false, bool $convertToFloat = false, int $qty = 1, bool $evaluateWasPrice = true)
    {
        $price = null;
        foreach ($this->variations->getItems() as $variation) {
            $new_price = $variation->prices->getPrice($includingVat, $convertToFloat, $qty, $evaluateWasPrice);
            if ($price !== null && $price <= $new_price) {
                continue;
            }
            $price = $new_price;
        }

        return $price;
    }

    /**
     * Get product price (cheapest variation).
     * @return int|null
     */
    public function getPriceExVat(): ?int
    {
        $price = null;
        foreach ($this->variations->getItems() as $variation) {
            if ($price !== null && $price <= $variation->prices->getExVat()) {
                continue;
            }
            $price = $variation->prices->getExVat();
        }

        return $price;
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
