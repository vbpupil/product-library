<?php

use Vbpupil\Collection\Collection;
use vbpupil\Product\GeneralProduct;
use vbpupil\Product\SimpleProduct;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableStock;
use vbpupil\Stock\AuditableType;

require_once 'vendor/autoload.php';

//AUDITABLE START

try {
    $as = new AuditableStock(55, new Collection());

    $as->addItem(
        new Auditable(
            5,
            AuditableType::BOOK_IN(),
            'booked in from Stock X',
            '2019-08-22 14:42:20'
        )
    )->addItem(
        new Auditable(
            1,
            AuditableType::BOOK_OUT(),
            'For Internal use',
            '2019-08-22 14:42:20'
        )
    )->addItem(
        new Auditable(
            2,
            AuditableType::REJECTED(),
            'Damaged stock',
            '2019-08-22 14:42:20'
        )
    );

    $as->audit();

} catch (Exception $e) {
    echo $e->getMessage();
}

dump($as);
//AUDITABLE END


//GENERAL PRODUCT START
try {
    $gp = new GeneralProduct(
        'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB',
        new Collection()
    );

    $gp->setLive(true);

    $gp->descriptions->addItem(
        'Sony PlayStation 4 - 500 GB Discover a revamped PlayStation console.',
        'short_description'
    );

    $gp->descriptions->addItem(
        'Sony PlayStation 4 - 500 GB Discover a revamped PlayStation console 30% smaller and lighter than the previous model and more energy efficient.',
        'long_description'
    );

    foreach ($gp->descriptions->getItems() as $desc) {
        echo $desc . '<br><br>';
    }

    $gp->setVariations(
        new Collection()
    );

    dump($gp);

} catch (Exception $e) {

}
//GENERAL PRODUCT END


//SIMPLE PRODUCT START
//$sp = new SimpleProduct(
//    'Iphone X',
//    new Collection()
//);
//
//$sp->setLive(true);
//
//$sp->descriptions->addItem(
//    '<p>The iPhone X, pronounced "iPhone 10," was introduced at Apple\'s September 2017 event as a classic "One more thing..."</p>',
//    'long_description');
//
//$sp->descriptions->addItem(
//    '<p>The iPhone X was Apple\'s flagship 10th anniversary iPhone.</p>',
//    'short_description');
//
//foreach ($sp->descriptions->getItems() as $desc) {
//    echo $desc;
//}
//
//dump($sp);
//SIMPLE PRODUCT END


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