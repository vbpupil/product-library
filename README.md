## Quality Assurance

![PHP 7.2](https://img.shields.io/badge/PHP-7.2-blue.svg)
[![Build Status](https://travis-ci.org/vbpupil/product.svg?branch=master)](https://travis-ci.org/vbpupil/product)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

# Base Product

## What?
Product Library which will help manage a Product, its Variations and their Prices (Single price aswell as a Price Matrix). It will also **if given sufficient data**
will review special price info and hand back the appropriate price.



## Why?
This library is the basis for what is required to manage your products. It should be used as the basis for more complex products.

## How?
```php
use vbpupil\Product\Product;

$ball = new Product('ball');
$ball
    ->setId(176)
    ->setDescription('intro','This ball is amazing!')
    ->setDescription('short','I am a short description.')
    
echo $ball->getName();
echo $ball->getId();
echo $ball->getDescription('intro');
echo $ball->getDescription('short');

$descriptions = $ball->getDescription(); //array of all descriptions returned
```