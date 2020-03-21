<?php
/**
 * Option.php.
 * Version: 1.0.0 (17/09/19)
 * Author:   Dean Haines
 */

namespace vbpupil\Option;


use vbpupil\Traits\CodeTypes;

class Option
{

    use CodeTypes;

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
    protected $ProductCode;

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
     * @param int|null $id
     * @param string $title
     * @param int $price
     * @param int $qty
     * @param int|null $cost_ex_vat
     * @param int|null $rrp_ex_vat
     * @param int|null $weight
     * @param null|string $prod_code
     * @param int|null $ean
     * @throws \Exception
     */
    public function __construct(?int $id, string $title, int $price, int $qty, ?int $cost_ex_vat,
                                ?int $rrp_ex_vat, ?int $weight, ?string $prod_code, ?int $ean
    )
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setPriceExVat($price);
        $this->setQty($qty);
        $this->setCostExVat($cost_ex_vat);
        $this->setRrpExVat($rrp_ex_vat);
        $this->setWeight($weight);
        $this->setProductCode($prod_code);
        $this->setEan($ean);
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
    protected function setId(?int $id): Option
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
    public function getCostExVat(): ?int
    {
        return $this->cost_ex_vat;
    }

    /**
     * @param int $cost_ex_vat
     * @return Option
     */
    public function setCostExVat(?int $cost_ex_vat): Option
    {
        $this->cost_ex_vat = $cost_ex_vat;
        return $this;
    }

    /**
     * @return int
     */
    public function getRrpExVat(): ?int
    {
        return $this->rrp_ex_vat;
    }

    /**
     * @param int $rrp_ex_vat
     * @return Option
     */
    public function setRrpExVat(?int $rrp_ex_vat): Option
    {
        $this->rrp_ex_vat = $rrp_ex_vat;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return Option
     */
    public function setWeight(?int $weight): Option
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->ProductCode;
    }

    /**
     * @param null|string $ProductCode
     * @return Option
     */
    public function setProductCode(?string $ProductCode): Option
    {
        $this->ProductCode = $ProductCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getEan(): ?int
    {
        return $this->ean;
    }

    /**
     * @param null|string $ean
     * @return Option
     * @throws \Exception
     */
    public function setEan(?string $ean): Option
    {
        if(!$this->isEan($ean)){
            throw new \Exception('Invalid EAN.');
        }

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