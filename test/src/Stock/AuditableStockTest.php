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
            ->disableOriginalConstructor()
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->collection
            ->expects($this->once())
            ->method('addItem')
            ->will($this->returnValue(
                ''
            ));

        $this->auditable = $this->getMockBuilder(Auditable::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDirection', 'getQty'])
            ->getMock();

        $this->auditable
            ->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(
                ''
                ));


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
        //ANDREA - THIS IS THE TEST


        var_dump($this->sut->auditToString());
        $this->assertEquals('', $this->sut->auditToString());
    }

//    public function testAudit()
//    {
    //complicated - need to put a mock audit inside a mock collection
//        $this->auditable
//            ->expects($this->once())
//            ->method('getDirection')
//            ->will($this->returnValue('IN'))
//        ;
//
//        $this->auditable
//            ->expects($this->once())
//            ->method('getQty')
//            ->will($this->returnValue(17))
//        ;
//
//        $this->sut->addItem($this->auditable);
//        $this->sut->audit();

//        $this->assertEquals(17, $this->sut->getVerifiedStockFigure());
//    }
}