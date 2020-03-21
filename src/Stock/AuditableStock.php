<?php
/**
 * AuditableStock.php.
 * Version: 1.0.0 (09/09/19)

 * Author:   Dean Haines
 */

namespace vbpupil\Stock;

use Vbpupil\Collection\Collection;


/**
 * Class AuditableStock
 * @package vbpupil\Stock
 */
class AuditableStock extends SimpleStock
{
    /**
     * @var Collection
     */
    protected $audits;


    /**
     * @var int
     */
    protected $verifiedStockFigure;


    /**
     * AuditableStock constructor.
     * @param int $stock
     * @param Collection $audits
     */
    public function __construct(int $stock, Collection $audits)
    {
        parent::__construct($stock);
        $this->audits = $audits;
    }


    /**
     * @param $obj
     * @param null $key
     * @return AuditableStock
     * @throws \Vbpupil\Collection\KeyInUseException
     */
    public function addItem($obj, $key = null): AuditableStock
    {
        if (!is_a($obj, Auditable::class)) {
            throw new \Exception('Incompatible type, Must be of Type Auditable');
        }

        $this->audits->addItem($obj, $key);

        return $this;
    }


    /**
     * this will loop through the entire history of the products audit logs and return a true breakdown of stock availability
     * could be heavy so really only be used to sure up stored stock figures and probably best not to run all of the time.
     */
    public function audit()
    {
        /*
        1. get the opening stock figure
        2. loop though all audits which includes book in, book out, stock takes figures accounted for etc and returns
        a story of: how many on order, how many in stock how many being sold how many are taken already etc
        */
        foreach ($this->audits->getItems() as $a) {
            switch ($a->getDirection()) {
                case 'IN':
                    $tmpSTock = ($a->getQty());
                    $this->verifiedStockFigure += $tmpSTock;
                    break;
                case 'OUT':
                    $tmpSTock = ($a->getQty());
                    $this->verifiedStockFigure -= $tmpSTock;
                    break;
            }
        }
    }

    /**
     *loops through an audit list and compiles a text representation of the results
     */
    public function auditToString()
    {
        $str = '';

        foreach ($this->audits->getItems() as $a) {
            $str .= <<<EOD
Type: {$a->getTypeValue()}<br>
Qty: {$a->getQty()}<br>
Description: {$a->getDescription()}<br>
Direction: {$a->getDirection()}<br>
Associated Document Type: {$a->getAssociatedDocType()}<br>
Associated Document ID: {$a->getAssociatedDocID()}<br><br>
********************<br><br>
EOD;
        }

        return $str;
    }

    /**
     * @return int
     */
    public function getVerifiedStockFigure(): ?int
    {
        return $this->verifiedStockFigure;
    }



}