<?php
/**
 * SinglePriceTest.php.
 * Version: 1.0.0 (04/09/19)

 * Author:   Dean Haines
 */


namespace src\Price;

use PHPUnit\Framework\TestCase;
use vbpupil\Exception\InvalidProductSetupException;
use vbpupil\Price\SinglePrice;

class SinglePriceTest extends TestCase
{
    protected $sut;


    public function testNewingUpASinglePrice()
    {
        $this->sut = new SinglePrice([
            'vatRate' => 20,
            'exVat' => 1200,
            'currency' => 'GBP',
        ]);

        $this->assertTrue($this->sut instanceof SinglePrice);
    }

    public function testNewingUpASinglePriceWithoutItemsMissing()
    {
        try {
            $this->sut = new SinglePrice([]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('Required Price Values must be provided', $e->getMessage());
        }

        try {
            $this->sut = new SinglePrice([
                'vatRate' => 20,
                'currency' => 'GBP',
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('Missing Required Fields: exVat', $e->getMessage());
        }

        try {
            $this->sut = new SinglePrice([
                'exVat' => 1200,
                'currency' => 'GBP',
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('Missing Required Fields: vatRate', $e->getMessage());
        }

        try {
            $this->sut = new SinglePrice([
                'exVat' => 1200,
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('Missing Required Fields: currency, vatRate', $e->getMessage());
        }
    }

    public function testGetPriceReturnsCorrectFigures()
    {

        $p = new SinglePrice([
            'vatRate' => 20,
            'exVat' => 1200,
            'currency' => 'GBP',
            'specialPriceActive' => true,
            'specialPriceActiveUntil' => '2070-09-09 11:41:00',
            'specialPrice' => 500
        ]);

        //sp with vat
        $this->assertEquals(6.00, number_format($p->getPrice(true), 2, '.', '.'));

        //sp without vat
        $this->assertEquals(5.00, number_format($p->getPrice(), 2, '.', '.'));


        $p = new SinglePrice([
            'vatRate' => 20,
            'exVat' => 1200,
            'currency' => 'GBP',
            'specialPriceActive' => false,
            'specialPriceActiveUntil' => '2070-09-09 11:41:00',
            'specialPrice' => 500
        ]);

        //with vat
        $this->assertEquals(14.40, number_format($p->getPrice(true), 2, '.', '.'));

        //without vat
        $this->assertEquals(12.00, number_format($p->getPrice(), 2, '.', '.'));
    }


    public function testInvalidFigureTypesPassedIn()
    {
        try {
            $p = new SinglePrice([
                'vatRate' => 20,
                'exVat' => 1200,
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2070-09-0 11:41:00',
                'specialPrice' => 500
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('Invalid specialPriceActiveUntil Supplied - must be in the format: 2019-01-01 11:42:00<br>', $e->getMessage());

        }
    }

    public function testToString()
    {
            $p = new \vbpupil\Price\SinglePrice([
                'vatRate' => 20,
                'exVat' => 1200,
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2070-09-09 11:41:00',
                'specialPrice' => 500
            ]);

            $this->assertEquals(
                '*******************************<br>
Currency: GBP<br>
Symbol: &pound;<br>
Vat Rate: 20<br><br>
Price (Ex VAT): 5.00<br>
Vat Element: 1.00<br>
Price (Inc VAT): 6.00<br><br>
Special Price Active: true<br>
*******************************',

                $p->toString());

            $p = new \vbpupil\Price\SinglePrice([
                'vatRate' => 20,
                'exVat' => 1200,
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2000-09-09 11:41:00',
                'specialPrice' => 500
            ]);

            $this->assertEquals(
                '*******************************<br>
Currency: GBP<br>
Symbol: &pound;<br>
Vat Rate: 20<br><br>
Price (Ex VAT): 12.00<br>
Vat Element: 2.40<br>
Price (Inc VAT): 14.40<br><br>
Special Price Active: false<br>
*******************************',
                $p->toString());
    }

    public function testSettingExVatWithIncorrectFormat()
    {
        try {
            $p = new SinglePrice([
                'vatRate' => 20,
                'exVat' => '1200',
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2070-09-09 11:41:00',
                'specialPrice' => 500
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('ExVat price must be an INT', $e->getMessage());
        }

        try {
            $p = new SinglePrice([
                'vatRate' => 20,
                'exVat' => 12.00,
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2070-09-09 11:41:00',
                'specialPrice' => 500
            ]);
        } catch (InvalidProductSetupException $e) {
            $this->assertEquals('ExVat price must be an INT', $e->getMessage());
        }
    }

    public function testGettingVariousVars()
    {
            $p = new SinglePrice([
                'vatRate' => 20,
                'exVat' => 1200,
                'currency' => 'GBP',
                'specialPriceActive' => true,
                'specialPriceActiveUntil' => '2070-09-09 11:41:00',
                'specialPrice' => 500
            ]);

            $this->assertEquals('2070-09-09 11:41:00', $p->getSpecialPriceActiveUntil());
            $this->assertEquals('&pound;', $p->getSymbol());
            $this->assertEquals(500, $p->getSpecialPrice());
            $this->assertEquals(20, $p->getVatRate());
            $this->assertEquals(1200, $p->getExVat(false));
            $this->assertEquals(100, $p->getExVat(true));
            $this->assertEquals('GBP', $p->getCurrency());
    }

    public function testIsOnSepcial()
    {
        $p = new SinglePrice([
            'vatRate' => 20,
            'exVat' => 1200,
            'currency' => 'GBP',
            'specialPriceActive' => true,
            'specialPriceActiveUntil' => '2070-09-09 11:41:00',
            'specialPrice' => 500
        ]);

        $this->assertTrue($p->isOnSpecial());

        $p = new SinglePrice([
            'vatRate' => 20,
            'exVat' => 1200,
            'currency' => 'GBP',
            'specialPriceActive' => true,
            'specialPriceActiveUntil' => '1990-09-09 11:41:00',
            'specialPrice' => 500
        ]);

        $this->assertFalse($p->isOnSpecial());

    }
}