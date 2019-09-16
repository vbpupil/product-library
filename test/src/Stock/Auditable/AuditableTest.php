<?php
/**
 * AuditableTest.phpVersion: 1.0.0 (10/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace src\Stock;


use PHPUnit\Framework\TestCase;
use vbpupil\Stock\Auditable;
use vbpupil\Stock\AuditableAssociatedDocumentType;
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

        $this->assocDocType = $this->getMockBuilder(AuditableAssociatedDocumentType::class)
            ->disableOriginalConstructor()
            ->setMethods(['getKey', 'getAssociatedDocType'])
            ->getMock();
    }

    public function testNewingUpAuditable()
    {
        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);

        $this->assertTrue($autid instanceof Auditable);
    }


    public function testNewingUpAuditableWithWrongDateType()
    {
        try {
            $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:2', null, null);
        } catch (\Exception $e) {
            $this->assertEquals('Invalid Date Format - requires 2019-01-01 14:22:00', $e->getMessage());
        }
    }


    public function testNewingUpAuditableWithAsocDoctypes()
    {
        $this->assocDocType
            ->expects($this->once())
            ->method('getAssociatedDocType')
            ->will($this->returnValue('SALES_ORDER'))
        ;

        $autid = new Auditable(
            5,
            $this->aType,
            'test desc',
            '2019-08-22 14:42:24',
            $this->assocDocType,
            155
        );

        echo 'TYPE: '.$autid->getAssociatedDocType();


        $this->assertEquals(155, $autid->getAssociatedDocID());
//        $this->assertEquals('SALES_ORDER', $autid->getAssociatedDocType());
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
            ->will($this->returnValue('BOOK_IN'));

        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);
        $this->assertEquals('IN', $autid->getDirection());

        $this->setUp();

        $this->aType
            ->expects($this->once())
            ->method('getKey')
            ->will($this->returnValue('SALE'));

        $autid = new Auditable(5, $this->aType, 'test desc', '2019-08-22 14:42:24', null, null);
        $this->assertEquals('OUT', $autid->getDirection());
    }
}