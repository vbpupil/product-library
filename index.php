<?php

use Vbpupil\Collection\Collection;
use vbpupil\Product\SimpleProduct;

require_once 'vendor/autoload.php';


$sp = new SimpleProduct(
    'Iphone X',
    new Collection()
);

$sp->setLive(true);

$sp->descriptions->addItem(
    '<p>The iPhone X, pronounced "iPhone 10," was introduced at Apple\'s September 2017 event as a classic "One more thing..." addition to the iPhone 8 and 8 Plus product lineup. The iPhone X has since been replaced by the iPhone XR, iPhone XS, and iPhone XS Max, and Apple has discontinued the device to focus on the newer iPhones.</p>
<p>Apple\'s aim with the iPhone X was to create an iPhone that\'s all display, blurring the line between physical object and experience. The 5.8-inch front screen melts into a highly polished curved-edge stainless steel band encircling a durable all-glass body available in two pearlescent finishes: Space Gray and Silver. Both feature a black front panel.</p>',
    'long_description');

$sp->descriptions->addItem(
    '<p>The iPhone X was Apple\'s flagship 10th anniversary iPhone featuring a 5.8-inch OLED display, facial recognition and 3D camera functionality, a glass body, and an A11 Bionic processor. Launched November 3, 2017, discontinued with the launch of the iPhone XR, XS, and XS Max.</p>',
    'short_description');

foreach ($sp->descriptions->getItems() as $desc) {
    echo $desc;
}

dump($sp);

//$v = new Vbpupil\Variation\SimpleVariation();

//single price start
//try {
//    $p = new \vbpupil\Price\SinglePrice([
//        'vatRate' => 20,
//        'exVat' => 1200,
//        'currency' => 'GBP',
//        'specialPriceActive' => true,
//        'specialPriceActiveUntil' => '2070-09-09 11:41:00',
//        'specialPrice' => 500
//    ]);
//
//
//    dump($p);
//    $price = number_format($p->getPrice(true), 2, '.', '.');
//
//
//    echo $p->toString();
//
//} catch (\vbpupil\Exception\InvalidProductSetupException $e) {
//    echo $e->getMessage();
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}
//single price end