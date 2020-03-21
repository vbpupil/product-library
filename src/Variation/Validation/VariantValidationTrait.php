<?php


namespace vbpupil\Variation\Validation;


/**
 * Trait VariantValidationTrait
 * @package vbpupil\Price\Validation
 *
 * This trait is responsible for validating variation attributes
 */
trait VariantValidationTrait
{
    /**
     * @param string $type
     * @param string $value
     * @param $errLog
     * @return string
     */
    protected function validateVariantAttribute(string $type, $value, string &$errLog)
    {
        switch ($type) {
            case 'sku':
                if (!preg_match('~^[a-z0-9A-Z]{8,12}$~', $value)) {
                    $errLog .= "Invalid {$type} Supplied - must be in the format<br>";
                }
                break;
        }
    }
}