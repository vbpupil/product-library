<?php
/**
 * \vbpupil\ProductLibrary\Variation\PhysicalVariant.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Variation;


class PhysicalVariant extends AbstractVariation
{
    /**
     * @var int
     */
    protected $packQty, $reorderLevel, $boxQty, $minOrderQty, $weight = 0;

    /**
     * @param int $packQty
     * @return PhysicalVariant
     */
    public function setPackQty(int $packQty): PhysicalVariant
    {
        $this->packQty = $packQty;
        return $this;
    }

    /**
     * @param int $reorderLevel
     * @return PhysicalVariant
     */
    public function setReorderLevel(int $reorderLevel): PhysicalVariant
    {
        $this->reorderLevel = $reorderLevel;
        return $this;
    }

    /**
     * @param int $boxQty
     * @return PhysicalVariant
     */
    public function setBoxQty(int $boxQty): PhysicalVariant
    {
        $this->boxQty = $boxQty;
        return $this;
    }

    /**
     * @param int $minOrderQty
     * @return PhysicalVariant
     */
    public function setMinOrderQty(int $minOrderQty): PhysicalVariant
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
    public function getReorderLevel(): int
    {
        return $this->reorderLevel;
    }

    /**
     * @return int
     */
    public function getBoxQty(): int
    {
        return $this->boxQty;
    }

    /**
     * @return int
     */
    public function getMinOrderQty(): int
    {
        return $this->minOrderQty;
    }
    /**
     * this weight is for one item - if someone is buying 5 then we times this by 5
     *
     * @return int
     */
    public function getWeight(int $qty = 1): int
    {
        return $this->weight * $qty;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }
}
