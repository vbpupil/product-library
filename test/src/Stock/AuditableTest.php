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
    public function testNewingUpAuditable()
    {
        $aType = $this->createMock(AuditableType::class);
        $autid = new Auditable(5, $aType, 'test desc', '2019-08-22 14:42:24');

        $this->assertTrue($autid instanceof Auditable);
    }

    public function testGettingMembers()
    {
        $aType = $this->getMockBuilder(AuditableType::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDirection'])
            ->getMock();

//        $aType->expects($this->once())
//            ->method('getDirection')
//        ->will($this->returnValue('IN'));

        $autid = new Auditable(5, $aType, 'test desc', '2019-08-22 14:42:24');

        $this->assertEquals(5, $autid->getQty());
        $this->assertEquals('test desc', $autid->getDescription());
        $this->assertEquals('2019-08-22 14:42:24', $autid->getDate());
//        $this->assertEquals('IN', $autid->getDirection());
//        var_dump($autid->getDirection());
    }
}