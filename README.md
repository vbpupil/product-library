## Quality Assurance

![PHP 7.2](https://img.shields.io/badge/PHP-7.2-blue.svg)

# Product Library
A Product Object can have many components based on how complicated your requirements are. Below outlines the general configurations:

### Simple Product - Without Prices
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

### General Product
On the face of it a General Product is the same as a Simple Product except it has a concept of Variations which itself offers some interesting additions.

To add an empty Collection:

```php
$prod->setVariations(
        new Collection()
    );
    ```

Once you have created the Collection simply use it as you would any other Collection object (the above descriptions functionality in Simple Product uses the same functionality).
