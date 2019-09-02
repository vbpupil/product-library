<?php


namespace vbpupil\Variation;



/**
 * Class SimpleVariation
 * @package vbpupil\Product
 */
class SimpleVariation
{

    /**
     * @var array
     */
    protected $required = ['productCode', 'title'];

    /**
     * @var string
     */
    protected $productCode;
    /**
     * @var string
     */
    protected $title;

    /**
     * SimpleVariation constructor.
     * @param array $required
     */
    public function __construct($required = [])
    {
        if (!empty($required)) {
            $this->required = $required;
        }
    }

    /**
     * @throws \Exception
     */
    public function verifyRequired()
    {
        foreach ($this->required as $r){
            if(!isset($this->{$r})){
                throw new \Exception("Property {$r} is required");
            }
        }
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     * @return SimpleVariation
     * @throws \Exception
     */
    public function setProductCode(string $productCode): SimpleVariation
    {
        if(is_null($productCode) || $productCode == ''){
            throw new \Exception('Product code cannot be empty.');
        }

        $this->productCode = $productCode;
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




}