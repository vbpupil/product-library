<?php
/**
 * GeneralProductTest.php.
 * Version: 1.0.0 (11/09/19)

 * Author:   Dean Haines
 */


namespace src\Product;


use PHPUnit\Framework\TestCase;
use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Product\GeneralProduct;
use vbpupil\ProductLibrary\Variation\AbstractVariation;

class GeneralProductTest extends TestCase
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


        $this->simpleVariation = $this->getMockBuilder(AbstractVariation::class)
            ->disableOriginalConstructor()
            ->setMethods(['addItem', 'getItems'])
            ->getMock();

        $this->sut = new GeneralProduct('physical');
    }

    public function testNewingUpAProduct()
    {
        try {
            $this->sut = new GeneralProduct('physical');
            $this->assertTrue($this->sut instanceof GeneralProduct);


            $this->sut = new GeneralProduct('physical');
        } catch (\Exception $e) {
            $this->assertEquals('GeneralProduct name required.', $e->getMessage());
        }
    }

    public function testGetAndSetName()
    {
        $this->sut->setName('Bike');
        $this->assertEquals('Bike', $this->sut->getName());
    }

    public function testLive()
    {
        $this->sut = new GeneralProduct(
            'ball',
            new Collection()
        );

        $this->assertEquals(false, $this->sut->isLive());

        $this->sut->setLive(true);
        $this->assertEquals(true, $this->sut->isLive());
    }

    public function testSlug()
    {
        $this->sut = new GeneralProduct(
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
        $this->sut = new GeneralProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isFeatured());

        $this->sut->setFeatured(true);
        $this->assertTrue($this->sut->isFeatured());
    }

    public function testIsBestSeller()
    {
        $this->sut = new GeneralProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isBestSeller());

        $this->sut->setBestSeller(true);
        $this->assertTrue($this->sut->isBestSeller());
    }

    public function testIsNewProduct()
    {
        $this->sut = new GeneralProduct(
            'ball',
            new Collection()
        );

        $this->assertFalse($this->sut->isNewProduct());

        $this->sut->setNewProduct(true);
        $this->assertTrue($this->sut->isNewProduct());
    }

    public function testSettingAndGettingDescriptions()
    {
        $this->sut = new GeneralProduct(
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
        $this->sut = new GeneralProduct(
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


//    public function testAddingVariations()
//    {
//        $this->variations
//            ->expects($this->once())
//            ->method('getItems')
//            ->will($this->returnValue(
//                [$this->simpleVariation]
//            ));
//
//        $this->sut->setVariations(
//            $this->variations
//        );
//    }

//    public function testWrongTypeAdded()
//    {
//        try {
//            $this->variations
//                ->expects($this->once())
//                ->method('getItems')
//                ->will($this->returnValue(
//                    ['test', 'test2']
//                ));
//
//            $this->sut->setVariations(
//                $this->variations
//            );
//        }catch(\Exception $e){
//            $this->assertEquals('Incompatible type, must be/extend from AbstractVariation', $e->getMessage());
//        }
//    }

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

    public function testAddingVariations()
    {
        $this->variations
            ->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(
                [$this->simpleVariation]
            ));

        $this->sut->setVariations(
            $this->variations
        );
    }

    public function testWrongTypeAdded()
    {
        try {
            $this->variations
                ->expects($this->once())
                ->method('getItems')
                ->will($this->returnValue(
                    ['test', 'test2']
                ));

            $this->sut->setVariations(
                $this->variations
            );
        }catch(\Exception $e){
//            echo $e->getMessage();
            $this->assertEquals('Incompatible type, must be/extend from AbstractVariation', $e->getMessage());
        }
    }

    public function testGetAndSetStyle()
    {
        $this->assertEquals('physical', $this->sut->getStyle());
    }
}
