## Quality Assurance

![PHP 7.2](https://img.shields.io/badge/PHP-7.2-blue.svg)

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

### GeneralProduct
On the face of it a General Product is the same as a Simple Product except it has a concept of Variations which itself offers some interesting additions.

To add an empty Collection:

```php
$prod->setVariations(
        new Collection()
    );
```

Once you have created the Collection simply use it as you would any other Collection object (the above descriptions functionality in Simple Product uses the same functionality).


## Pricing

### SinglePrice
This handles most use cases when a product variation may have a few prices attributed to it such as price, special price, cost price etc but will only be sold for a single price. When asking the object for its **getPrice()**
method you will be returned a single price. Note the object will run a check to see if the Special price is set/valid and return that if true, if not the sell price will be returned.

### MatrixPrice
This object will handle the matrix price style structure, ie:

| Qty     | Price |
| ------- |:-----:|
| 1 - 9   | 5.00  |
| 10 - 19 | 4.00  |
| 20 - 30 | 3.00  |


## Stock
Stock can be measured depending upon needs, the following are available.

### SimpleStock
Simple stock offers a simple holding of a stock figure and passes back whenever called upon.


### AuditableStock
Auditable stock has the ability to verify what the current stock figure has on hand by performing a full check if its inventry history and spitting out its findings.


### Auditable
The auditable class is on hand to offer an explanation of why an items stock figure has changed - ie BOOK_IN/BOOK_OUT etc etc.


### AuditableType
This class simply defines what can be accepted as a valid reason.


### AuditableAssociatesDocumentType
This class simply defines what can be accepted as a valid document type to support the above.





