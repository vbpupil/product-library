<?php
/**
 * SingleProduct.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Product;


class SimpleProduct extends AbstractProduct
{
    /**
     * SimpleProduct constructor.
     */
    public function __construct()
    {
        $this->type = 'simple';
    }
}
