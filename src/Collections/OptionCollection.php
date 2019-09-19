<?php

namespace vbpupil\Collections;

use vbpupil\Option\Option;

/**
 * OptionCollection.php
 * Version: 1.0.0 (19/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */
class OptionCollection extends SortableCollection
{
    /**
     * @param string $member
     * @param string $direction
     */
    public function sort(string $member, string $direction = 'ASC')
    {
        switch ($member) {
            case 'rrp_ex_vat':
                usort($this->items, function ($a, $b) {
                    return $a->getRrpExVat() <=> $b->getRrpExVat();
                });
                break;
            case 'price_ex_vat':
                usort($this->items, function ($a, $b) {
                    return $a->getPriceExVat() <=> $b->getPriceExVat();
                });
                break;
            case 'title':
                usort($this->items, function ($a, $b) {
                    return $a->getTitle() <=> $b->getTitle();
                });
                break;
        }

        if ($direction == 'DESC') {
            $this->items = array_reverse($this->items);
        }
    }

    /**
     * @param $obj
     * @param null $key
     * @return OptionCollection
     * @throws \Exception
     */
    public function addItem($obj, $key = null):OptionCollection
    {
        if (!is_a($obj, Option::class)) {
            throw new \Exception("Incorrect Collections Type, requires a Option to continue.");
        }

        parent::addItem($obj, $key);

        return $this;
    }
}