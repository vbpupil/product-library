<?php


namespace vbpupil\ProductLibrary\Seo\Product;


class AbstractProductSeo
{
    public string $google_product_strategy;
 
    public string $google_product_category = '';

    public string $google_product_type = '';


    /**
     * @return string
     */
    public function getGoogleProductStrategy(): string
    {
        return $this->google_product_strategy;
    }

    /**
     * @param string $google_product_strategy
     */
    public function setGoogleProductStrategy(string $google_product_strategy): void
    {
        $this->google_product_strategy = $google_product_strategy;
    }
    
    /**
     * @return string
     */
    public function getGoogleProductCategory(): string
    {
        return $this->google_product_category;
    }

    /**
     * @param string $google_product_category
     */
    public function setGoogleProductCategory(string $google_product_category): void
    {
        $this->google_product_category = $google_product_category;
    }

    /**
     * @return string
     */
    public function getGoogleProductType(): string
    {
        return $this->google_product_type;
    }

    /**
     * @param string $google_product_type
     */
    public function setGoogleProductType(string $google_product_type): void
    {
        $this->google_product_type = $google_product_type;
    }


}