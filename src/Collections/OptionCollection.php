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