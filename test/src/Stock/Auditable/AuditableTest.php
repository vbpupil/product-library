<?php
/**
 * AuditableTest.phpVersion: 1.0.0 (10/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace src\Stock;


use PHPUnit\Framework\TestCase;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableType;

class AuditableTest extends TestCase
{
    protected $aType;

    public function setUp()
    {
        $this->aType = $this->getMockBuilder(AuditableType::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDirection', 'getKey', 'getValue'])
            ->getMock();

        //        $this->>aType->expects($this->once())
//            ->method('getDirection')
//        ->will($this->returnValue('IN'));

        //        $aType->expects($this->once())
//            ->method('getDirection')
//        ->will($this->returnValue('IN'));
    }

    public function testNewingUpAuditable()
    {
        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);

        $this->assertTrue($autid instanceof Auditable);
    }

    public function testGettingMembers()
    {
        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);

        $this->assertEquals(5, $autid->getQty());
        $this->assertEquals('test desc', $autid->getDescription());
        $this->assertEquals('2019-08-22 14:42:24', $autid->getDate());
//        $this->assertEquals('IN', $autid->getDirection());
//        var_dump($autid->getDirection());
    }

    public function testDirectionDecider()
    {
        $this->aType
            ->expects($this->once())
            ->method('getKey')
            ->will($this->returnValue('BOOK_IN'))
        ;

        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);
        $this->assertEquals('IN', $autid->getDirection());

        $this->setUp();

        $this->aType
            ->expects($this->once())
            ->method('getKey')
            ->will($this->returnValue('SALE'))
        ;

        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);
        $this->assertEquals('OUT', $autid->getDirection());
    }
}