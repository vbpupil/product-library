<?php

use Vbpupil\Collection\Collection;
use vbpupil\Collections\OptionCollection;
use vbpupil\Product\GeneralProduct;
use vbpupil\Product\Product;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableAssociatedDocumentType;
use vbpupil\Stock\AuditableStock;
use vbpupil\Stock\AuditableType;

require_once 'vendor/autoload.php';


//BUILDER START

$director = new \vbpupil\Builder\ProductDirector();
$simpleData = [];
$generalData = [];

$simpleData =
    [
        'type' => 'simpleProduct',
        'product_name' => 'PS4 1st edition',
        'descriptions' => [
            'long' => 'i am the long desc',
            'short' => 'i am the short desc'
        ],
        'live' => true,
        'featured' => true,
        'best_seller' => true,
        'new_product' => true,
        'product_images' => [
            ['path' => 'kitty.jpg'],
            ['path' => 'dog.jpg']
        ]
    ];

$simple = $director->buildSimpleProduct(
    new \vbpupil\Builder\SimpleProductBuilder(),
    $simpleData
);


$generalData =
    [
        'type' => 'generalProduct',
        'product_name' => 'PS4 v5',
        'descriptions' => [
            'long' => 'i am the long desc',
            'short' => 'i am the short desc'
        ],
        'variations' => [
            [
                'id' => 123,
                'title' => 'VARIATION 1',
                'price' => 150,
                'special_price' => 100,
                'special_price_expiry' => '2020-03-14 11:53:22',
                'special_price_active' => false,
                'vat' => 2000,
            ], [
                'id' => 456,
                'title' => 'VARIATION 2',
                'price' => 150,
                'special_price' => 100,
                'special_price_expiry' => '2020-03-14 11:53:22',
                'special_price_active' => false,
                'vat' => 2000,
            ], [
                'id' => 789,
                'title' => 'VARIATION 3',
                'price' => 150,
                'special_price' => 100,
                'special_price_expiry' => '2020-03-14 11:53:22',
                'special_price_active' => false,
                'vat' => 2000,
            ]
        ]
    ];

//$general = $director->buildGeneralProduct(
//    new \vbpupil\Builder\GeneralProductBuilder(),
//    $generalData
//);


$generalSimpleData =
    [
        'type' => 'generalSimpleProduct',
        'product_name' => 'PS4 v5',
        'descriptions' => [
            'long' => 'i am the long desc',
            'short' => 'i am the short desc'
        ],
        'variations' => [
            [
                'id' => 123,
                'weight' => 3600,
                'title' => 'VARIATION 1',
                'price' => 150,
                'special_price' => 100,
                'special_price_expiry' => '2020-09-14 11:53:22',
                'special_price_active' => false,
                'vat' => 2000,
                'option_categories' => [
                    [
                        'id' => 12,
                        'title' => 'Colour',
                        'options' => [
                            [
                                'id' => 74,
                                'title' => 'red',
                                'price_ex_vat' => 3290,
                                'qty' => 1,
                                'cost_ex_vat' => 100,
                                'rrp_ex_vat' => 700,
                                'weight' => 75,
                                'product_code' => 'test_prod_code_123X',
                                'ean' => '1111122222333'
                            ],
                            [
                                'id' => 77,
                                'title' => 'blue',
                                'price_ex_vat' => 1000,
                                'qty' => 1,
                                'cost_ex_vat' => 200,
                                'rrp_ex_vat' => 1400,
                                'weight' => 150,
                                'product_code' => 'second_test_prod_code_123X',
                                'ean' => '5558889997777'
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ];

$generalSimple = $director->buildGeneralProduct(
    new \vbpupil\Builder\GeneralSimpleProductBuilder(),
    $generalSimpleData
);

//$v = new \vbpupil\Variation\SimpleVariation(
//    [
//        'title' => 'FFF',
//    ]
//);
//$general->variations->addItem($v);

//dump($general->variations->getItem(1));


//
//    $gp->variations->addItem($v);


dump($simple);
dump($general);
dump($generalSimple);
//BUILDER END


//OPTION START
//try {
//    $opCat = new \vbpupil\Option\OptionCategory(
//        12,
//        'HDD Size',
//        (new OptionCollection())
//            ->addItem(
//                new \vbpupil\Option\Option(
//                    1,
//                    '500GB SATA HDD',
//                    4000,
//                    1,
//                    1000,
//                    4900,
//                    100,
//                    'myprod123',
//                    '1111122222333'
//                )
//            )
//            ->addItem(
//                new \vbpupil\Option\Option(
//                    1,
//                    '1TB SATA HDD',
//                    5500,
//                    1,
//                    1000,
//                    6900,
//                    100,
//                    'myprod123',
//                    '1111122222333'
//                )
//            )
//            ->addItem(
//                new \vbpupil\Option\Option(
//                    1,
//                    '2TB SATA HDD',
//                    7900,
//                    1,
//                    1000,
//                    8900,
//                    100,
//                    'myprod123',
//                    '1111122222333'
//                )
//            )
//            ->addItem(
//                new \vbpupil\Option\Option(
//                    1,
//                    '4TB SATA HDD',
//                    8900,
//                    1,
//                    1000,
//                    9900,
//                    100,
//                    'myprod123',
//                    '1111122222333'
//                )
//            )
//    );
//
//
//    dump($opCat);
//
//    $opCat->options->sort('price_ex_vat');
//    dump($opCat->options->getItems());
//
//} catch (\Exception $e) {
//    echo $e->getMessage();
//} catch (\vbpupil\Exception\InvalidSortMember $e) {
//    echo $e->getMessage();
//}
//OPTION END


//AUDITABLE START
//
//try {
//    $as = new AuditableStock(55, new Collections());
//
//    $as->addItem(
//        new Auditables(
//            2,
//            AuditableType::SALE(),
//            'Sold',
//            '2019-08-22 14:42:20',
//            AuditableAssociatedDocumentType::SALES_ORDER(),
//            115
//        )
//    )->addItem(
//        new Auditables(
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
//try {
//    $gp = new GeneralProduct(
//        'SONY PlayStation 4 with Fortnite Neo Versa & Two Wireless Controllers - 500 GB',
//        new Collection()
//    );
//
//    $gp->setLive(true);
//
//    $gp->descriptions->addItem(
//        'Sony PlayStation 4 - 500 GB Discover a revamped PlayStation console.',
//        'short_description'
//    );
//
//    $gp->descriptions->addItem(
//        'Sony PlayStation 4 - 500 GB Discover a revamped PlayStation console 30% smaller and lighter than the previous model and more energy efficient.',
//        'long_description'
//    );
//
//    foreach ($gp->descriptions->getItems() as $desc) {
//        echo $desc . '<br><br>';
//    }
//
//    $gp->setVariations(
//        new Collection()
//    );
//
//    $v = new \vbpupil\Variation\SimpleVariation(
//        [
//            'title' => 'FFF',
//            'product_code' => 'MYPRODCODE-01'
//        ]
//    );
//
//    $gp->variations->addItem($v);
//
//
//
//    dump($gp);
//
//} catch (Exception $e) {
//
//}
//GENERAL PRODUCT END


//SIMPLE PRODUCT START
//$sp = new Product(
//    'Iphone X',
//    new Collections()
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

//single prices start
//try {
//    $p = new \vbpupil\Price\SinglePrice([
//        'vatRate' => 20,
//        'exVat' => 1200,
//        'currency' => 'GBP',
//        'specialPriceActive' => true,
//        'specialPriceActiveUntil' => '2000-09-09 11:41:00',
//        'specialPrice' => 500
//    ]);
//
//
//    dump($p);
//    $prices = number_format($p->getPrice(true), 2, '.', '.');
//    $exvat = number_format(($p->getExVat() / 100), 2, '.', '.');
//
//    echo <<<EOD
//EX VAT: {$p->formatPrice('getExVat')}<br>
//Price: {$p->getSymbol()}{$prices}<br>
//Ex Vat (non dynamic): {$p->getSymbol()}{$exvat}<br>
//EOD;
//
//
//    echo $p->toString();
//
//} catch (\vbpupil\Exception\InvalidProductSetupException $e) {
//    echo $e->getMessage();
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}
//single prices end