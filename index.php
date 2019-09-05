<?php

require_once 'vendor/autoload.php';

try {
    $p = new \vbpupil\Price\SinglePrice([
        'vatRate' => 20,
        'exVat' => '1200',
        'currency' => 'GBP',
        'specialPriceActive' => true,
        'specialPriceActiveUntil' => '2070-09-09 11:41:00',
        'specialPrice' => 500
    ]);


    dump($p);
    $price = number_format($p->getPrice(true), 2, '.', '.');



    echo $p->toString();

} catch (\vbpupil\Exception\InvalidProductSetupException $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}