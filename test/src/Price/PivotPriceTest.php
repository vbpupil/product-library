<?php


namespace src\Price;


use PHPUnit\Framework\TestCase;
use vbpupil\ProductLibrary\Price\PivotPrice;

class PivotPriceTest extends TestCase
{
    protected $sut;

    public function setUp()
    {
        $this->sut = new PivotPrice([
            'pivot' => '[{"qty":"1","price":1000},{"qty":"10","price":500},{"qty":"20","price":100}]',
            'vatRate' => 2000,
            'vatRateId' => 1,
            'currency' => 'GBP'
        ]);
    }

    /**
     * @test
     */
    public function get_unit_price()
    {
        $this->sut->getPrice(false, false, 1);
        $this->assertEquals(1000, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 5);
        $this->assertEquals(1000, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 9);
        $this->assertEquals(1000, $this->sut->getUnitPrice(false, false, 9));

        $this->sut->getPrice(false, false, 10);
        $this->assertEquals(500, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 15);
        $this->assertEquals(500, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 19);
        $this->assertEquals(500, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 20);
        $this->assertEquals(100, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 25);
        $this->assertEquals(100, $this->sut->getUnitPrice());

        $this->sut->getPrice(false, false, 99);
        $this->assertEquals(100, $this->sut->getUnitPrice());
    }

    /** @test */
    public function newing_up_pivot_price()
    {
        $this->assertTrue($this->sut instanceof PivotPrice);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Required Pivot Price Values must be provided
     */
    public function newing_up_a_price_pivot_with_items_missing()
    {
        $price = new PivotPrice([]);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Missing Required Fields: currency
     */
    public function newing_up_a_price_pivot_with_currency_missing()
    {
        $price = new PivotPrice([
            'pivot' => '[{"qty":"1","price":1000},{"qty":"10","price":500},{"qty":"20","price":100}]',
            'vatRate' => 2000,
            'vatRateId' => 1
        ]);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Missing Required Fields: vatRateId
     */
    public function newing_up_a_price_pivot_with_vat_rate_missing()
    {
        $price = new PivotPrice([
            'pivot' => '[{"qty":"1","price":1000},{"qty":"10","price":500},{"qty":"20","price":100}]',
            'vatRate' => 2000,
            'currency' => 'GBP'
        ]);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Missing Required Fields: pivot
     */
    public function newing_up_a_price_pivot_with_pivot_missing()
    {
        $price = new PivotPrice([
            'vatRate' => 2000,
            'currency' => 'GBP',
            'vatRateId' => 1
        ]);
    }


    public function test_figures_are_correct()
    {
        $p = new PivotPrice([
            'pivot' => '[{"qty":"1","price":1000},{"qty":"10","price":500},{"qty":"20","price":100}]',
            'vatRate' => 2000,
            'vatRateId' => 1,
            'currency' => 'GBP'
        ]);

        //pivot 1
        $this->assertEquals(12.00, number_format($p->getPrice(true, true, 1), 2, '.', '.'));
        $this->assertEquals(60.00, number_format($p->getPrice(true, true, 10), 2, '.', '.'));
        $this->assertEquals(10.00, number_format($p->getPrice(false, true, 1), 2, '.', '.'));
        $this->assertEquals(50.00, number_format($p->getPrice(false, true, 10), 2, '.', '.'));

        //pivot 2
        $this->assertEquals(66.00, number_format($p->getPrice(true, true, 11), 2, '.', '.'));
        $this->assertEquals(24.00, number_format($p->getPrice(true, true, 20), 2, '.', '.'));
        $this->assertEquals(55.00, number_format($p->getPrice(false, true, 11), 2, '.', '.'));
        $this->assertEquals(20.00, number_format($p->getPrice(false, true, 20), 2, '.', '.'));

        //pivot 3
        $this->assertEquals(25.20, number_format($p->getPrice(true, true, 21), 2, '.', '.'));
        $this->assertEquals(42.00, number_format($p->getPrice(true, true, 35), 2, '.', '.'));
        $this->assertEquals(21.00, number_format($p->getPrice(false, true, 21), 2, '.', '.'));
        $this->assertEquals(35.00, number_format($p->getPrice(false, true, 35), 2, '.', '.'));
    }

    /**
     * @test
     */
    public function to_string()
    {
        $this->assertEquals(
            '*******************************<br>
Currency: GBP<br>
Symbol: &pound;<br>
Vat Rate: 2000<br><br>
Price (Ex VAT): 10.00<br>
Vat Element: 2.00<br>
Price (Inc VAT): 12.00<br><br>
*******************************',

            $this->sut->toString());
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage ExVat prices must be an INT
     */
    public function setting_exvat_with_incorrect_format()
    {
            $p = new PivotPrice([
                'pivot' => '[{"qty":"1","price":10.00},{"qty":"10","price":5.00},{"qty":"20","price":1.00}]',
                'vatRate' => 2000,
                'vatRateId' => 1,
                'currency' => 'GBP'
            ]);

            $p->getPrice();
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage ExVat prices must be an INT
     */
    public function setting_exvat_with_incorrect_format_seconds()
    {
            $p = new PivotPrice([
                'pivot' => '[{"qty":"1","price":""},{"qty":"10","price":5.00},{"qty":"20","price":1.00}]',
                'vatRate' => 2000,
                'vatRateId' => 1,
                'currency' => 'GBP'
            ]);

            $p->getExVat();
    }
}
