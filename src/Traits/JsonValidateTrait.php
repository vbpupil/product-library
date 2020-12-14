<?php


namespace vbpupil\ProductLibrary\Traits;


trait JsonValidateTrait
{
    /**
     * @param $string
     * @return bool
     */
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}