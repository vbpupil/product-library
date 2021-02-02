<?php


namespace vbpupil\ProductLibrary\Seo\Product;


class AbstractProductSeo
{
    public string $google_product_strategy;

    public string $google_product_category = '';

    public string $google_product_type = '';

    public string $google_product_custom_label_0 = '';

    public string $google_product_custom_label_1 = '';

    public string $google_product_custom_label_2 = '';

    public string $google_product_custom_label_3 = '';


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

    /**
     * @return string
     */
    public function getGoogleProductCustomLabel0(): string
    {
        return $this->google_product_custom_label_0;
    }

    /**
     * @param string $google_product_custom_label_0
     */
    public function setGoogleProductCustomLabel0(string $google_product_custom_label_0): void
    {
        $this->google_product_custom_label_0 = $google_product_custom_label_0;
    }

    /**
     * @return string
     */
    public function getGoogleProductCustomLabel1(): string
    {
        return $this->google_product_custom_label_1;
    }

    /**
     * @param string $google_product_custom_label_1
     */
    public function setGoogleProductCustomLabel1(string $google_product_custom_label_1): void
    {
        $this->google_product_custom_label_1 = $google_product_custom_label_1;
    }

    /**
     * @return string
     */
    public function getGoogleProductCustomLabel2(): string
    {
        return $this->google_product_custom_label_2;
    }

    /**
     * @param string $google_product_custom_label_2
     */
    public function setGoogleProductCustomLabel2(string $google_product_custom_label_2): void
    {
        $this->google_product_custom_label_2 = $google_product_custom_label_2;
    }

    /**
     * @return string
     */
    public function getGoogleProductCustomLabel3(): string
    {
        return $this->google_product_custom_label_3;
    }

    /**
     * @param string $google_product_custom_label_3
     */
    public function setGoogleProductCustomLabel3(string $google_product_custom_label_3): void
    {
        $this->google_product_custom_label_3 = $google_product_custom_label_3;
    }
}
