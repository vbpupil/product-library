<?php


namespace vbpupil\ProductLibrary\Variation;


use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Exception\InvalidVariationSetupException;
use vbpupil\ProductLibrary\Option\OptionCategory;
use vbpupil\ProductLibrary\Price\PriceInterface;
use vbpupil\ProductLibrary\Traits\CodeTypes;

/**
 * Class AbstractVariation
 * @package vbpupil\AbstractProduct
 */
abstract class AbstractVariation
{
    use \vbpupil\ProductLibrary\Variation\Validation\VariantValidationTrait, CodeTypes;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var array
     */
    protected $required = ['title'];

    /**
     * @var string
     */
    protected $product_code, $barcode, $ean, $mpn, $title, $price_type, $unit_of_sale, $brand_name, $brand_id, $gtin;

    /**
     * @var PriceInterface
     */
    public $prices;

    /**
     * @var Collection
     */
    public $options;

    /**
     * @var array
     */
    protected $style_options = [];

    /**
     * @var int
     */
    protected $min_del_qty, $max_del_qty;
    
    protected $seo;

    /**
     * AbstractVariation constructor.
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new InvalidVariationSetupException('Required Values must be provided');
        }

        foreach ($values as $k => $v) {
            $k = ucwords(str_replace('_', ' ', $k));
            $k = str_replace(' ', '', $k);

            $methodName = "set{$k}";
            $this->{$methodName}($v);
        }

        $this->verifyRequired();
    }

    /**
     *lets loop through the attributes we have and test that they match the $required array;
     */
    public function verifyRequired()
    {
        //1. create the tmp array
        $tmpRequired = [];
        foreach ($this->required as $r) {
            $tmpRequired[$r] = 0;
        }

        $err = '';

        //2. verify if value is present
        foreach ($this->required as $r) {
            if (isset($this->{$r})) {
                $this->validateVariantAttribute($r, $this->{$r}, $err);

                unset($tmpRequired[$r]);
            }
        }

        //3. moan about it if we have to
        if ($err !== '') {
            throw new InvalidVariationSetupException($err);
        }

        if (!empty($tmpRequired)) {
            $err = implode(', ', array_keys($tmpRequired));
            throw new InvalidVariationSetupException("Missing Required Fields: {$err}");
        }
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
    public function getProductCode(): string
    {
        return $this->product_code ? $this->product_code : '';
    }

    /**
     * @param string $product_code
     * @return AbstractVariation
     * @throws \Exception
     */
    public function setProductCode(string $product_code): AbstractVariation
    {
        $this->product_code = $product_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return AbstractVariation
     */
    public function setTitle(string $title): AbstractVariation
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @param PriceInterface $prices
     */
    public function setPrice(PriceInterface $prices)
    {
        $this->prices = $prices;
    }

    /**
     * @param bool $includingVat
     * @param bool $convertToFloat
     * @param int $qty
     * @return mixed
     */
    public function getPrice(bool $includingVat, bool $convertToFloat = false, int $qty = 1)
    {
        return $this->prices->getPrice($includingVat, $convertToFloat, $qty);
    }

    /**
     * @return Collection
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /**
     * @param Collection $options
     */
    public function setOptions(Collection $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    public function getStyleOptions(): array
    {
        return $this->style_options;
    }

    public function setStyleOptions(array $options): void
    {
        $this->style_options = $options;
    }

    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * @return string
     */
    public function getMpn()
    {
        return $this->mpn;
    }

    /**
     * @param string $mpn
     */
    public function setMpn($mpn)
    {
        $this->mpn = $mpn;
    }

    /**
     * @return string
     */
    public function getPriceType(): string
    {
        return $this->price_type;
    }

    /**
     * @param string $price_type
     */
    public function setPriceType(string $price_type): void
    {
        $this->price_type = $price_type;
    }

    /**
     * @return string
     */
    public function getUnitOfSale(): string
    {
        return $this->unit_of_sale;
    }

    /**
     * @param string $unit_of_sale
     */
    public function setUnitOfSale(string $unit_of_sale): void
    {
        $this->unit_of_sale = $unit_of_sale;
    }

    /**
     * @return int
     */
    public function getMinDelQty(): int
    {
        return $this->min_del_qty;
    }

    /**
     * @param int $min_del_qty
     */
    public function setMinDelQty(int $min_del_qty): void
    {
        $this->min_del_qty = $min_del_qty;
    }

    /**
     * @return int
     */
    public function getMaxDelQty(): int
    {
        return $this->max_del_qty;
    }

    /**
     * @param int $max_del_qty
     */
    public function setMaxDelQty(int $max_del_qty): void
    {
        $this->max_del_qty = $max_del_qty;
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
    public function setBrandName(string $brand_name): void
    {
        $this->brand_name = $brand_name;
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
    public function setBrandId(string $brand_id): void
    {
        $this->brand_id = $brand_id;
    }

    /**
     * @return mixed
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param mixed $seo
     */
    public function setSeo($seo): void
    {
        $this->seo = $seo;
    }

    /**
     * @return string
     */
    public function getGtin(): string
    {
        return $this->gtin;
    }

    /**
     * @param string $gtin
     */
    public function setGtin(string $gtin): void
    {
        $this->gtin = $gtin;
    }
    
    
}
