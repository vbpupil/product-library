<?php


namespace vbpupil\Product;


use Vbpupil\Collection\Collection;

class SimpleProduct
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $descriptions;

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
     * @return Collection
     */
    public function getDescriptions(): Collection
    {
        return $this->descriptions;
    }

    /**
     * @param Collection $descriptions
     * @return SimpleProduct
     */
    public function setDescriptions(Collection $descriptions): SimpleProduct
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