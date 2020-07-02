<?php
/**
 * CodeTypes.php.
 * Version: 1.0.0 (18/09/19)
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Traits;


/**
 * Trait CodeTypes
 * @package vbpupil\Traits
 */
trait CodeTypes
{
    /**
     * @param null|string $string
     * @return bool
     */
    public function isEan(?string $string)
    {
        return (bool)preg_match('~^\d{12}$|^\d{13}$~', $string);
    }

    /**
     * @param null|string $string
     * @return bool
     */
    public function isSku(?string $string)
    {
        return (bool)preg_match('~^[a-z0-9A-Z]{8,12}$~', $string);
    }
}