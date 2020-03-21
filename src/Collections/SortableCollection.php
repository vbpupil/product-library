<?php
/**
 * SortableCollection.php.
 * Version: 1.0.0 (19/09/19)
 * Author:   Dean Haines
 */


namespace vbpupil\Collections;

use Vbpupil\Collection\Collection;
use vbpupil\Exception\InvalidSortMember;

class SortableCollection extends Collection
{

    /**
     * @param string $member
     * @param string $direction
     */
    public function sort(string $member, string $direction = 'ASC')
    {
        switch ($member) {
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
}