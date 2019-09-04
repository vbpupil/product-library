<?php


namespace vbpupil\Price\Validation;


/**
 * Trait PriceValidationTrait
 * @package vbpupil\Price\Validation
 *
 * This trait is responsible for validating variation attributes
 */
trait PriceValidationTrait
{
    /**
     * @param string $type
     * @param string $value
     * @param $errLog
     * @return string
     */
    protected function validateProductPriceAttribute(string $type, $value, string &$errLog)
    {
        switch ($type) {
            case 'specialPriceActiveUntil':
                if (!preg_match('~^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$~', $value)) {
                    $errLog .= "Invalid {$type} Supplied - must be in the format: 2019-01-01 11:42:00<br>";
                }
                break;
        }
    }
}