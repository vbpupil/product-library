<?php


namespace vbpupil\Product;


use Vbpupil\Collection\Collection;
use Vbpupil\Collection\CollectionException;
use Vbpupil\Collection\KeyInUseException;

class SimpleProduct
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    public $descriptions;

    /**
     * @var bool
     */
    protected $live;

    /**
     * SimpleProduct constructor.
     * @param null $name
     * @param Collection $descriptions
     * @param bool $live
     * @throws \Exception
     */
    public function __construct($name = null, Collection $descriptions, $live = false)
    {
        if (is_null($name) || !is_string($name)) {
            throw new \Exception("Product name required.");
        }

        $this->setName($name);
        $this->setDescriptions($descriptions);
        $this->setLive($live);
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
     * @return SimpleProduct
     */
    public function setName(string $name): SimpleProduct
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Collection $descriptions
     * @return SimpleProduct
     */
    protected function setDescriptions(Collection $descriptions): SimpleProduct
    {
        $this->descriptions = $descriptions;
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
     * @return SimpleProduct
     */
    public function setLive(bool $live): SimpleProduct
    {
        $this->live = $live;
        return $this;
    }

}