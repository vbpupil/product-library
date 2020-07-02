<?php
/**
 * OptionCollectionTest.php.
 * Version: 1.0.0 (19/09/19)

 * Author:   Dean Haines
 */


namespace src\Collection;


use PHPUnit\Framework\TestCase;
use vbpupil\ProductLibrary\Collections\OptionCollection;
use vbpupil\ProductLibrary\Option\Option;

class OptionCollectionTest extends TestCase
{
    protected $sut;

    protected $option;

    public function setUp()
    {
        $this->sut = new OptionCollection();

        $this->option = $this->getMockBuilder(Option::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testAddingWrongType()
    {
        try{
            $this->sut->addItem(new \stdClass());
        }catch(\Exception $e) {
            $this->assertEquals('Incorrect Collections Type, requires a Option to continue.', $e->getMessage());
        }
    }

    public function testTypeOfCollectionReturned()
    {
        $this->assertTrue(
            $this->sut->addItem($this->option) instanceof OptionCollection
        );
    }
}