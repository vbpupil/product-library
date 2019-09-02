<?php


namespace vbpupil\Price;


class PriceFactory
{

    public function build($type = 'single', $values)
    {
        switch ($type) {
            case 'single':
                return new SinglePrice($values);
                break;
            case 'matrix':
                return new MatrixPrice($values);
                break;
        }
    }
}