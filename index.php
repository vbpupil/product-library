<?php

use Vbpupil\Collection\Collection;
use vbpupil\Product\GeneralProduct;
use vbpupil\Product\SimpleProduct;

require_once 'vendor/autoload.php';




//GENERAL PRODUCT START
try {
    $gp = new GeneralProduct(
        'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB',
        new Collection()
    );

    $gp->setLive(true);

    $gp->descriptions->addItem(
'<p><strong>Sony PlayStation 4 - 500 GB</strong></p><p>Discover a revamped PlayStation console 30% smaller and lighter than the previous model and more energy efficient.</p>',
        'short_description'
    );

    $gp->descriptions->addItem(
        'Sony PlayStation 4 - 500 GB

<p><strong>Sony PlayStation 4 - 500 GB
</strong></p>
<p>
Discover a revamped PlayStation console 30% smaller and lighter than the previous model and more energy efficient.
<br>
<br>
With High Dynamic Range (HDR) technology, graphics are better looking than ever. Experience better brightness and darkness reproduction across a wider range of colours bringing games to life. HDR-compatible TV owners will experience more realistic and striking visuals with HDR-supported games.
<br>
<br>
Make the most of 500 GB of storage space giving you room to store the latest PS4 games and demos available from the PlayStation Network online.
<br>
<br>
With a PS Plus subscription players can play the latest games online, and do battle with millions of players across the world. PS Plus members can enjoy the latest offers on the newest digital games and exclusive access to the latest game demos.
</p>',
        'long_description'
    );

    foreach ($gp->descriptions->getItems() as $desc) {
        echo $desc;
    }

    dump($gp);

} catch (Exception $e) {

}


//GENERAL PRODUCT END



//$sp = new SimpleProduct(
//    'Iphone X',
//    new Collection()
//);
//
//$sp->setLive(true);
//
//$sp->descriptions->addItem(
//    '<p>The iPhone X, pronounced "iPhone 10," was introduced at Apple\'s September 2017 event as a classic "One more thing..." addition to the iPhone 8 and 8 Plus product lineup. The iPhone X has since been replaced by the iPhone XR, iPhone XS, and iPhone XS Max, and Apple has discontinued the device to focus on the newer iPhones.</p>
//<p>Apple\'s aim with the iPhone X was to create an iPhone that\'s all display, blurring the line between physical object and experience. The 5.8-inch front screen melts into a highly polished curved-edge stainless steel band encircling a durable all-glass body available in two pearlescent finishes: Space Gray and Silver. Both feature a black front panel.</p>',
//    'long_description');
//
//$sp->descriptions->addItem(
//    '<p>The iPhone X was Apple\'s flagship 10th anniversary iPhone featuring a 5.8-inch OLED display, facial recognition and 3D camera functionality, a glass body, and an A11 Bionic processor. Launched November 3, 2017, discontinued with the launch of the iPhone XR, XS, and XS Max.</p>',
//    'short_description');
//
//foreach ($sp->descriptions->getItems() as $desc) {
//    echo $desc;
//}
//
//dump($sp);

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