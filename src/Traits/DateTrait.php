<?php
/**
 * DateTrait.php.
 * Version: 1.0.0 (09/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */

namespace vbpupil\Traits;

/**
 * Trait DateTrait
 * @package vbpupil\Traits
 */
trait DateTrait
{
    /**
     * checks for a valid date time string ie 2019-08-22 14:42:24
     * @param string $str
     * @return bool
     */
    public function isDateTimeString(string $str)
    {
        return (bool)preg_match('~[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}~', $str);
    }
}