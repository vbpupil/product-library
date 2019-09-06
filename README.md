## Quality Assurance

![PHP 7.2](https://img.shields.io/badge/PHP-7.2-blue.svg)
[![Build Status](https://travis-ci.org/vbpupil/product.svg?branch=master)](https://travis-ci.org/vbpupil/product)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

# A Simple Collection Library
Here we have a simple Collection library which helps to store your objects in a way that is convenient as well as offering an easy way to interrogate.

A Product Object can have many components based on how complicated your requirements are. Below outlines the general configurations:

### Simple Simple Product - Without Prices
A SimpleProduct does NOT have any prices. Below shows how a SimpleProduct can be initiated:

```php
$sp = new SimpleProduct(
    'Iphone X',
    new Collection()
);

$sp->setLive(true);

$sp->setDescription(
    '<p>The iPhone X, pronounced "iPhone 10," was introduced at Apple\'s September 2017 event as a classic "One more thing..." addition to the iPhone 8 and 8 Plus product lineup. The iPhone X has since been replaced by the iPhone XR, iPhone XS, and iPhone XS Max, and Apple has discontinued the device to focus on the newer iPhones.</p>
<p>Apple\'s aim with the iPhone X was to create an iPhone that\'s all display, blurring the line between physical object and experience. The 5.8-inch front screen melts into a highly polished curved-edge stainless steel band encircling a durable all-glass body available in two pearlescent finishes: Space Gray and Silver. Both feature a black front panel.</p>',
    'long_description');
``` 

#### Get Description

```php
echo $sp->getDescription('long_description');
```

#### Get Descriptions

```php
foreach ($sp->getDescriptions() as $desc) {
    echo $desc;
}
```

