<?php
/**
 * Option.php.
 * Version: 1.0.0 (17/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


class Option
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $price_ex_vat;

    /**
     * @var int
     */
    protected $cost_ex_vat;

    /**
     * @var int
     */
    protected $rrp_ex_vat;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @var int
     */
    protected $product_code;

    /**
     * @var int
     */
    protected $ean;

    /**
     * @var int
     */
    protected $qty;


    /**
     * Option constructor.
     * @param string $title
     * @param int $price
     * @param int $qty
     */
    public function __construct(string $title, int $price, int $qty)
    {
        $this->setTitle($title);
        $this->setPriceExVat($price);
        $this->setQty($qty);
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
     * @return Option
     */
    protected function setId(int $id): Option
    {
        $this->id = $id;
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
     * @return Option
     */
    public function setTitle(string $title): Option
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriceExVat(): int
    {
        return $this->price_ex_vat;
    }

    /**
     * @param int $price_ex_vat
     * @return Option
     */
    public function setPriceExVat(int $price_ex_vat): Option
    {
        $this->price_ex_vat = $price_ex_vat;
        return $this;
    }

    /**
     * @return int
     */
    public function getCostExVat(): int
    {
        return $this->cost_ex_vat;
    }

    /**
     * @param int $cost_ex_vat
     * @return Option
     */
    public function setCostExVat(int $cost_ex_vat): Option
    {
        $this->cost_ex_vat = $cost_ex_vat;
        return $this;
    }

    /**
     * @return int
     */
    public function getRrpExVat(): int
    {
        return $this->rrp_ex_vat;
    }

    /**
     * @param int $rrp_ex_vat
     * @return Option
     */
    public function setRrpExVat(int $rrp_ex_vat): Option
    {
        $this->rrp_ex_vat = $rrp_ex_vat;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return Option
     */
    public function setWeight(int $weight): Option
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductCode(): int
    {
        return $this->product_code;
    }

    /**
     * @param int $product_code
     * @return Option
     */
    public function setProductCode(int $product_code): Option
    {
        $this->product_code = $product_code;
        return $this;
    }

    /**
     * @return int
     */
    public function getEan(): int
    {
        return $this->ean;
    }

    /**
     * @param int $ean
     * @return Option
     */
    public function setEan(int $ean): Option
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     * @return Option
     */
    public function setQty(int $qty): Option
    {
        $this->qty = $qty;
        return $this;
    }
}