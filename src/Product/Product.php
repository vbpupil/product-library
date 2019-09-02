<?php
/**
 * Product.php Class
 *
 * @author    Dean Haines
 * @copyright 2019, UK
 * @license   Proprietary See LICENSE.md
 */

namespace vbpupil\Product;


use Vbpupil\Collection\Collection;

/**
 * Class Product
 * @package vbpupil\Product
 */
class Product
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $short_name;

    /**
     * @var array
     */
    protected $descriptions = [];

    /**
     * @var Collection
     */
    protected $variations;

    /**
     * switches are a set of boolean values such as live, featured etc
     * @var array
     */
    protected $features = [];


    public function __construct($name = null, Collection $variations)
    {
        if (is_null($name)) {
            throw new \Exception('A product name is required.');
        }

        $this->name = $name;
        $this->variations = $variations;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->short_name;
    }

    /**
     * @param string $short_name
     * @return Product
     */
    public function setShortName($short_name)
    {
        $this->short_name = $short_name;

        return $this;
    }

    /**
     * if called without a key you get the lot, otherwise will return specific description.
     * @param null $key
     * @return array
     * @throws \Exception
     */
    public function getDescription($key = null)
    {
        if (!is_null($key)) {
            return $this->getADescription($key);

        }

        return $this->descriptions;
    }

    /**
     * Pluck out particular description from descriptions
     *
     * @param $key
     * @return array
     * @throws \Exception
     */
    protected function getADescription($key)
    {
        if (!array_key_exists($key, $this->descriptions)) {
            throw new \Exception("Description {$key} does not exist.");
        }

        return $this->descriptions[$key];
    }

    /**
     * container for descriptions such as intro, long, short, ingredients etc.
     *
     * @param $key
     * @param null $description
     * @return Product
     * @throws \Exception
     */
    public function setDescription($key, $description = null)
    {
        if (is_null($key)) {
            throw new \Exception('Description key is required.');
        }

        $this->descriptions[$key] = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param array $features
     * @return Product
     */
    public function setFeatures($features)
    {
        $this->features = $features;
        return $this;
    }


    public function addVariation(SimpleVariation $variation)
    {

    }
}