<?php


namespace vbpupil\Price;


class PriceFactory
{

    public static function build($type = 'single', $values)
    {
        switch ($type) {
            case 'single':
                return new SinglePrice($values);
                break;
                //NOT YET REQUIRED
//            case 'matrix':
//                return new MatrixPrice($values);
//                break;
        }
    }
}