<?php
/**
 * AuditableStockTest.php.
 * Version: 1.0.0 (11/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace src\Stock;


use PHPUnit\Framework\TestCase;
use Vbpupil\Collection\Collection;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableStock;

class AuditableStockTest extends TestCase
{
    protected $sut;
    protected $collection;
    protected $auditable;

    public function setUp()
    {
        $this->collection = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();


        $this->auditable = $this->getMockBuilder(Auditable::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDirection', 'getDescription', 'getQty', 'getItems', 'getTypeValue', 'getAssociatedDocType', 'getAssociatedDocID'])
            ->getMock();

        $this->collection->addItem(
            $this->auditable
        );

        $this->sut = new AuditableStock(
            55, $this->collection
        );
    }

    public function testNewingUp()
    {
        $this->assertTrue($this->sut instanceof AuditableStock);
    }

    public function testAddItemThrowsException()
    {
        try {
            $this->sut->addItem('test');
        } catch (\Exception $e) {
            $this->assertEquals('Incompatible type, Must be of Type Auditable', $e->getMessage());
        }
    }

    public function testTopStringOutput()
    {
        $this->collection
            ->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(
                [$this->auditable]
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getTypeValue')
            ->will($this->returnValue(
                'SALE'
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getQty')
            ->will($this->returnValue(
                2
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getDescription')
            ->will($this->returnValue(
                'Sold'
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getDirection')
            ->will($this->returnValue(
                'OUT'
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getAssociatedDocType')
            ->will($this->returnValue(
                'SALES_ORDER'
            ));

        $this->auditable
            ->expects($this->once())
            ->method('getAssociatedDocID')
            ->will($this->returnValue(
                '115'
            ));

        $expectedOutput = <<<EOD
Type: SALE<br>
Qty: 2<br>
Description: Sold<br>
Direction: OUT<br>
Associated Document Type: SALES_ORDER<br>
Associated Document ID: 115<br><br>
********************<br><br>
EOD;

        $this->assertEquals(
            $expectedOutput,
            $this->sut->auditToString()
        );
    }

    public function testAuditIN()
    {
        $this->collection
            ->expects($this->once())
            ->method('addItem')
            ->will($this->returnValue(
                ''
            ));

        $this->collection
            ->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(
                [$this->auditable]
            ));


        $this->auditable
            ->expects($this->once())
            ->method('getDirection')
            ->will($this->returnValue('IN'))
        ;

        $this->auditable
            ->expects($this->once())
            ->method('getQty')
            ->will($this->returnValue(17))
        ;

        $this->sut->addItem($this->auditable);
        $this->sut->audit();

        $this->assertEquals(17, $this->sut->getVerifiedStockFigure());
    }

    public function testAuditOUT()
    {
        $this->collection
            ->expects($this->once())
            ->method('addItem')
            ->will($this->returnValue(
                ''
            ));

        $this->collection
            ->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(
                [$this->auditable]
            ));


        $this->auditable
            ->expects($this->once())
            ->method('getDirection')
            ->will($this->returnValue('OUT'))
        ;

        $this->auditable
            ->expects($this->once())
            ->method('getQty')
            ->will($this->returnValue(15))
        ;

        $this->sut->addItem($this->auditable);
        $this->sut->audit();

        $this->assertEquals(-15, $this->sut->getVerifiedStockFigure());
    }
}