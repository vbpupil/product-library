<?php
/**
 * SimpleStock.phprsion: 1.0.0 (09/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */

namespace vbpupil\Stock;

/**
 * Class SimpleStock
 * @package vbpupil\Stock
 */
class SimpleStock
{
    /**
     * @var
     */
    protected $stock;


    /**
     * SimpleStock constructor.
     * @param int $stock
     */
    public function __construct(int $stock)
    {
        $this->setStock($stock);
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     * @return $this
     */
    public function setStock(int $stock): SimpleStock
    {
        $this->stock = $stock;
        return $this;
    }


}