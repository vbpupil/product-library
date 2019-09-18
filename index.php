<?php

use Vbpupil\Collection\Collection;
use vbpupil\Product\GeneralProduct;
use vbpupil\Product\SimpleProduct;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableAssociatedDocumentType;
use vbpupil\Stock\AuditableStock;
use vbpupil\Stock\AuditableType;

require_once 'vendor/autoload.php';


//OPTION START
try {
    $opCat = new \vbpupil\Option\OptionCategory(
        12,
        'HDD Size',
        (new Collection())
            ->addItem(
                new \vbpupil\Option\Option(
                    1,
                    '500GB SATA HDD',
                    4000,
                    1,
                    1000,
                    4900,
                    100,
                    'myprod123',
                    '012345678910'
                )
            )
            ->addItem(
                new \vbpupil\Option\Option(
                    1,
                    '1TB SATA HDD',
                    5500,
                    1,
                    1000,
                    4900,
                    100,
                    'myprod123',
                    '012345678910'
                )
            )
            ->addItem(
                new \vbpupil\Option\Option(
                    1,
                    '2TB SATA HDD',
                    7900,
                    1,
                    1000,
                    4900,
                    100,
                    'myprod123',
                    '012345678910'
                )
            )
            ->addItem(
                new \vbpupil\Option\Option(
                    1,
                    '4TB SATA HDD',
                    8900,
                    1,
                    1000,
                    4900,
                    100,
                    'myprod123',
                    '012345678910'
                )
            )
    );


    dump($opCat);
} catch (Exception $e) {

}


//OPTION END


//AUDITABLE START
//
//try {
//    $as = new AuditableStock(55, new Collection());
//
//    $as->addItem(
//        new Auditable(
//            2,
//            AuditableType::SALE(),
//            'Sold',
//            '2019-08-22 14:42:20',
//            AuditableAssociatedDocumentType::SALES_ORDER(),
//            115
//        )
//    )->addItem(
//        new Auditable(
//            2,
//            AuditableType::RETURN_DAMAGED(),
//            'Surplus to requirements',
//            '2019-08-22 14:42:20',
//            null,
//            null
//        )
//    );
//
//    $as->audit();
//    echo $as->auditToString();
//
//} catch (Exception $e) {
//    echo $e->getMessage();
//}
//
//dump($as);
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