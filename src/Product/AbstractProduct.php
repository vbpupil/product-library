<?php


namespace vbpupil\ProductLibrary\Product;


use Vbpupil\Collection\Collection;
use vbpupil\Variation\AbstractVariation;

/**
 * Class AbstractProduct
 * @package vbpupil\AbstractProduct
 */
abstract class AbstractProduct
{
    /**
     * @var string
     */
    protected $type, $brand_id, $brand_name, $brand_slug;

    /**
     * @var string
     */
    protected $style;

    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var Collection
     */
    public $product_images, $descriptions, $variations;

    /**
     * @var bool
     */
    protected $live = false;

    /**
     * @var string
     */
    protected $slug = '';

    /**
     * @var bool
     */
    protected $featured = false;

    /**
     * @var bool
     */
    protected $best_seller = false;

    /**
     * @var bool
     */
    protected $new_product = false;

    /**
     * @var int
     */
    protected $cheapest_variant_id, $cheapest_variant_price;

    /**
     * preview of what types of price types are contained within a variant
     * @var array
     */
    protected $variantPriceTypes = [];


    /**
     * @var int
     */
    protected $id;

    public $seo;

    /**
     * SimpleProduct constructor.
     */
    public function __construct(string $style)
    {
        $this->style = $style;
        $this->type = 'simple';
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
     * @return AbstractProduct
     */
    public function setName(string $name): AbstractProduct
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Collection $descriptions
     * @return AbstractProduct
     */
    public function setDescriptions(Collection $descriptions): AbstractProduct
    {
        $this->descriptions = $descriptions;
        return $this;
    }

    /**
     * @param Collection $product_images
     * @return AbstractProduct
     */
    public function setProductImages(Collection $product_images): AbstractProduct
    {
        $this->product_images = $product_images;
        return $this;
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
     * @return AbstractProduct
     */
    public function setLive(bool $live): AbstractProduct
    {
        $this->live = $live;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isFeatured(): bool
    {
        return $this->featured;
    }

    /**
     * @param bool $featured
     */
    public function setFeatured(bool $featured): void
    {
        $this->featured = $featured;
    }

    /**
     * @return bool
     */
    public function isBestSeller(): bool
    {
        return $this->best_seller;
    }

    /**
     * @param bool $best_seller
     */
    public function setBestSeller(bool $best_seller): void
    {
        $this->best_seller = $best_seller;
    }

    /**
     * @return bool
     */
    public function isNewProduct(): bool
    {
        return $this->new_product;
    }

    /**
     * @param bool $new_product
     */
    public function setNewProduct(bool $new_product): void
    {
        $this->new_product = $new_product;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @return int
     */
    public function getCheapestVariantId(): int
    {
        return $this->cheapest_variant_id;
    }

    /**
     * @param int $cheapest_variant_id
     */
    public function setCheapestVariantId(int $cheapest_variant_id): void
    {
        $this->cheapest_variant_id = $cheapest_variant_id;
    }

    /**
     * @return int
     */
    public function getCheapestVariantPrice(): int
    {
        return $this->cheapest_variant_price;
    }

    /**
     * @param int $cheapest_variant_price
     */
    public function setCheapestVariantPrice(int $cheapest_variant_price): void
    {
        $this->cheapest_variant_price = $cheapest_variant_price;
    }

    /**
     * @return array
     */
    public function getVariantPriceTypes(): array
    {
        return $this->variantPriceTypes;
    }

    /**
     * @param array $variantPriceTypes
     */
    public function setVariantPriceTypes(array $variantPriceTypes): void
    {
        $this->variantPriceTypes = $variantPriceTypes;
    }

    /**
     * @return string
     */
    public function getBrandId(): string
    {
        return $this->brand_id;
    }

    /**
     * @param string $brand_id
     */
    public function setBrandId(string $brand_id = ''): void
    {
        $this->brand_id = $brand_id;
    }

    /**
     * @return string
     */
    public function getBrandName(): string
    {
        return $this->brand_name;
    }

    /**
     * @param string $brand_name
     */
    public function setBrandName(string $brand_name = ''): void
    {
        $this->brand_name = $brand_name;
    }

    /**
     * @return string
     */
    public function getBrandSlug(): string
    {
        return $this->brand_slug;
    }

    /**
     * @param string $brand_slug
     */
    public function setBrandSlug(string $brand_slug = ''): void
    {
        $this->brand_slug = $brand_slug;
    }

    /**
     * @return AbstractSeo
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param AbstractSeo $seo
     */
    public function setSeo( $seo): void
    {
        $this->seo = $seo;
    }

}
