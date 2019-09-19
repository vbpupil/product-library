<?php
/**
 * OptionCategoryTest.php.
 * Version: 1.0.0 (18/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace src\Option;


use PHPUnit\Framework\TestCase;
use vbpupil\Collections\OptionCollection;
use vbpupil\Option\OptionCategory;

class OptionCategoryTest extends TestCase
{
    protected $sut;
    protected $collection;

    public function setUp()
    {
        $this->collection = $this->getMockBuilder(OptionCollection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->sut = new OptionCategory(
            12,
            'HDD Size',
            $this->collection
        );
    }

    public function testNewingUp()
    {
        $this->assertTrue($this->sut instanceof OptionCategory);
    }

    public function testGettingName()
    {
        $this->assertEquals('HDD Size', $this->sut->getTitle());
        $this->sut->setTitle('Hard Disk Drive Sizes');
        $this->assertEquals('Hard Disk Drive Sizes', $this->sut->getTitle());
    }

    public function testGettingId()
    {
        $this->assertEquals(12, $this->sut->getId());
    }
}