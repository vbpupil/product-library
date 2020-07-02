<?php
/**
 * SimpleProductTest.php.
 * Version: 1.0.0 (11/09/19)

 * Author:   Dean Haines
 */


namespace src\Product;


use PHPUnit\Framework\TestCase;
use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Product\SimpleProduct;
use vbpupil\ProductLibrary\Variation\PhysicalVariation;

class SimpleProductTest extends TestCase
{
    protected $sut;


    public function setUp()
    {
        $this->description = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->variations = $this->getMockBuilder(Collection::class)
            ->setMethods(['addItem', 'getItems'])
            ->getMock();


        $this->physicalVariation = $this->getMockBuilder(PhysicalVariation::class)
            ->disableOriginalConstructor()
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->sut = new SimpleProduct(
            'Sony PS4 With 1 Controller',
            $this->description,
            true
        );
    }

    public function testNewingUpAProduct()
    {
        try {
            $this->sut = new SimpleProduct(
                'ball',
                new Collection()
            );
            $this->assertTrue($this->sut instanceof SimpleProduct);


            $this->sut = new SimpleProduct(null, new Collection());
        } catch (\Exception $e) {
            $this->assertEquals('SimpleProduct name required.', $e->getMessage());
        }
    }

    public function testGetAndSetName()
    {
        $this->sut->setName('Bike');
        $this->assertEquals('Bike', $this->sut->getName());
    }

    public function testLive()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        $this->assertEquals(false, $this->sut->isLive());

        $this->sut->setLive(true);
        $this->assertEquals(true, $this->sut->isLive());
    }

    public function testSlug()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        $this->sut->setSlug('my-ball-1');
        $this->assertEquals('my-ball-1', $this->sut->getSlug());

        $this->sut->setSlug('');
        $this->assertEquals('', $this->sut->getSlug());
    }

    public function testFeatured()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isFeatured());

        $this->sut->setFeatured(true);
        $this->assertTrue($this->sut->isFeatured());
    }

    public function testIsBestSeller()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isBestSeller());

        $this->sut->setBestSeller(true);
        $this->assertTrue($this->sut->isBestSeller());
    }

    public function testIsNewProduct()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isNewProduct());

        $this->sut->setNewProduct(true);
        $this->assertTrue($this->sut->isNewProduct());
    }

    public function testSettingAndGettingDescriptions()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        //create a new collection object
        $this->sut->setDescriptions(new Collection());

        //delete some descriptions
        $this->sut->descriptions->addItem('i am testing long description', 'long');
        $this->sut->descriptions->addItem('i am testing shorty description', 'shorty');

        $this->assertEquals('i am testing shorty description', $this->sut->descriptions->getItem('shorty'));
        $this->assertEquals(2, $this->sut->descriptions->getLength());

        //delete a description
        $this->sut->descriptions->deleteItem('shorty');
        $this->assertEquals(1, $this->sut->descriptions->getLength());

        $this->assertTrue($this->sut->descriptions->keyExists('long'));
    }
    public function testProductImages()
    {
        $this->sut = new SimpleProduct(
            'ball',
            new Collection()
        );

        //create a new collection object
        $this->sut->setProductImages(new Collection());

        //delete some descriptions
        $this->sut->product_images->addItem('cat.jpg');
        $this->sut->product_images->addItem('doggy.png');

        $this->assertEquals('doggy.png', $this->sut->product_images->getItem(1));
        $this->assertEquals(2, $this->sut->product_images->getLength());

        //delete a description
        $this->sut->product_images->deleteItem(0);
        $this->assertEquals(1, $this->sut->product_images->getLength());
    }

    public function testGetAndSetId()
    {
        $this->sut->setId(123);
        $this->assertEquals(123, $this->sut->getId());
    }

    public function testGetAndSetType()
    {
        $this->sut->setType('MyTypeTest');
        $this->assertEquals('MyTypeTest', $this->sut->getType());
    }

    public function testGettingStyle()
    {
        $this->assertEquals('simple', $this->sut->getStyle());
    }
}