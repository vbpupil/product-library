## Quality Assurance

![PHP 7.2](https://img.shields.io/badge/PHP-7.2-blue.svg)
[![Build Status](https://travis-ci.org/vbpupil/product-library.svg?branch=master)](https://travis-ci.org/vbpupil/product-library)

# ProductLibrary
A Product Object can have many components based on how complicated your requirements are. Below outlines the general configurations:

### SimpleProduct - Without Prices
A SimpleProduct does NOT have any prices. Below shows how a SimpleProduct can be initiated:

```php
$prod = new SimpleProduct(
    'Iphone X',
    new Collection()
);

$prod->setLive(true);

$prod->setSlug('iphone-x'); //defines urls safe string

$prod->setDescription(
    '<p>The iPhone X, pronounced "iPhone 10," was introduced at Apple\'s September 2017 event as a classic "One more thing...".</p>',
    'long_description');
``` 

#### Get Description

```php
echo $prod->getItem('long_description');
```

#### Get Descriptions

```php
foreach ($prod->getItems() as $desc) {
    echo $desc;
}
```

#### Get Product Attributes
* getBrandName() - brand name associated with product
* getBrandId() - brand id associated with product

### GeneralProduct
On the face of it a General Product is the same as a Simple Product except it has a concept of Variations which itself offers some interesting additions.

To add Variations simplly start by passing in an empty Collection:

```php
$prod->setVariations(
        new Collection()
    );
```

Once you have created the Collection simply use it as you would any other Collection object (the above descriptions functionality in Simple Product uses the same functionality).


To add a Variation:

```php
    $myVariation = new \vbpupil\Variation\AbstractVariation(
            [
                'title' => 'FFF',
                'product_code' => 'MYPRODCODE-01'
            ]
        );
    
    $prod->variations->addItem($v);
```

#### Get Variant Attributes
* getBarcode() - barcode of a variant
* getEan() - ean of a variant
* getMpn() - mpn of a variant
* getPriceType() - price type of a variant ie single or pivot
* getUnitOfSale() - unit of sale of a varient ie bag, pallet, jumbo bag etc
* getMinDelQty() - how much qty to purchase before del is available
* getMaxDelQty() - how much qty is too much before only colection is available

## Pricing

### SinglePrice
This handles most use cases when a product variation may have a few prices attributed to it such as prices, special prices, cost prices etc but will only be sold for a single prices. When asking the object for its **getPrice()**
method you will be returned a single prices. Note the object will run a check to see if the Special prices is set/valid and return that if true, if not the sell prices will be returned.

### PivotPrice
This object will handle the pivot prices style structure, ie:

| Qty     | Price |
| ------- |:-----:|
| 1 - 9   | 5.00  |
| 10 - 19 | 4.00  |
| 20 - 30 | 3.00  |

to identify which price type a variant is (ie single or pivot) you can use **getVariantPriceTypes()**  
to identify which is the cheapest variant id you can use **getCheapestVariantiD()**
to identify which is the cheapest variant price you can use **getCheapestVariantPrice()**

## Stock
Stock can be measured depending upon needs, the following are available.

### SimpleStock
Simple stock offers a simple holding of a stock figure and passes back whenever called upon.

### AuditableStock
Auditable stock has the ability to verify what the current stock figure has on hand by performing a retrospective check of its inventory history and spitting out its findings.


### Auditable
The auditable class is on hand to offer an explanation of why an items stock figure has changed - ie BOOK_IN/BOOK_OUT etc etc.


### AuditableType
This class simply defines what can be accepted as a valid reason. For instance when newing up an Auditable:
```php
$a = new Auditable(
            2,
            AuditableType::SALE(),
            'Sold',
            '2019-08-22 14:42:20',
            AuditableAssociatedDocumentType::SALES_ORDER(),
            115
        )
```

A **AuditableType::SALE()** is passed into to represent a SALE item. This class is governed by Enums which outlines what type is available.


### AuditableAssociatesDocumentType
This class allows you to specify what supporting document accompanies the stock change, for instance a SALES_ORDER (with 
accompanying SALES ORDER ID) would support a sale which resulted in the stock being reduced by 1. Below shows this code in action.

```php
$a = new Auditable(
            2,
            AuditableType::SALE(),
            'Sold',
            '2019-08-22 14:42:20',
            AuditableAssociatedDocumentType::SALES_ORDER(),
            115
        )
```

An **AuditableAssociatedDocumentType::SALES_ORDER()** is passed in to represent a SALES_ORDER. This class is governed by Enums which outlines what 
supporting document types are available.

