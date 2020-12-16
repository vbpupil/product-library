<?php


namespace vbpupil\ProductLibrary\Traits;


trait ClassTrait
{

    /**
     * @return false|string
     */
    public function getClassName()
    {
        return __CLASS__;
    }

    public function getShortClassName()
    {
        return (substr(__CLASS__, strrpos(__CLASS__, '\\') + 1));
    }
}