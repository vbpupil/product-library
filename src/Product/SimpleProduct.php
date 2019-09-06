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
     * @return array
     */
    public function getDescriptions()
    {
        return $this->descriptions->getItems();
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
     * @param $obj
     * @param null $key
     */
    public function setDescription($obj, $key = null)
    {
        try {
            $this->descriptions->addItem($obj, $key);
        } catch (KeyInUseException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getDescription($key = null)
    {
        try {
            return $this->descriptions->getItem($key);
        } catch (CollectionException $e) {
            echo $e->getMessage();
        }
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