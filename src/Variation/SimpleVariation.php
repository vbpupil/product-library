<?php


namespace vbpupil\Variation;



use Vbpupil\Collection\Collection;
use vbpupil\Exception\InvalidVariationSetupException;
use vbpupil\Option\OptionCategory;
use vbpupil\Price\PriceInterface;
use vbpupil\Variation\Validation\VariantValidationTrait;

/**
 * Class SimpleVariation
 * @package vbpupil\Product
 */
class SimpleVariation
{
    use VariantValidationTrait;

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
    protected $product_code;
    /**
     * @var string
     */
    protected $title;

    /**
     * @var PriceInterface
     */
    public $prices;

    /**
     * @var Collection
     */
    public $options;

    /**
     * @var int
     */
    protected $packQty, $setReorderLevel, $setBoxQty, $minOrderQty;


    /**
     * SimpleVariation constructor.
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new InvalidVariationSetupException('Required Values must be provided');
        }

        foreach ($values as $k => $v) {
            $k = ucfirst($k);
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
    public function getproduct_code(): string
    {
        return $this->product_code;
    }

    /**
     * @param string $product_code
     * @return SimpleVariation
     * @throws \Exception
     */
    public function setproduct_code(string $product_code): SimpleVariation
    {
        if(is_null($product_code) || $product_code == ''){
            throw new \Exception('Product code cannot be empty.');
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
     * @return SimpleVariation
     */
    public function setTitle(string $title): SimpleVariation
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param int $packQty
     * @return SimpleVariation
     */
    public function setPackQty(int $packQty): SimpleVariation
    {
        $this->packQty = $packQty;
        return $this;
    }

    /**
     * @param int $reorderLevel
     * @return SimpleVariation
     */
    public function setReorderLevel(int $reorderLevel): SimpleVariation
    {
        $this->reorderLevel = $reorderLevel;
        return $this;
    }

    /**
     * @param int $boxQty
     * @return SimpleVariation
     */
    public function setBoxQty(int $boxQty): SimpleVariation
    {
        $this->boxQty = $boxQty;
        return $this;
    }

    /**
     * @param int $minOrderQty
     * @return SimpleVariation
     */
    public function setMinOrderQty(int $minOrderQty): SimpleVariation
    {
        $this->minOrderQty = $minOrderQty;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackQty(): int
    {
        return $this->packQty;
    }

    /**
     * @return int
     */
    public function getSetReorderLevel(): int
    {
        return $this->setReorderLevel;
    }

    /**
     * @return int
     */
    public function getSetBoxQty(): int
    {
        return $this->setBoxQty;
    }

    /**
     * @return int
     */
    public function getMinOrderQty(): int
    {
        return $this->minOrderQty;
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
    public function getPrice(bool $includingVat, bool $convertToFloat = true, int $qty = 1)
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




}