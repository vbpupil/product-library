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
    protected $product_code, $barcode, $title;

    /**
     * @var PriceInterface
     */
    public $prices;

    /**
     * @var Collection
     */
    public $options;

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
        if (is_null($product_code) || $product_code == '') {
            throw new \Exception('AbstractProduct code cannot be empty.');
        }

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
     * @throws \Exception
     */
    public function setBarcode(string $barcode): void
    {
        if (!$this->isSku($barcode)) {
            if (!$this->isEan($barcode)) {
                throw new \Exception('INVALID barcode identified.');
            }
        }
        $this->barcode = $barcode;
    }
}
