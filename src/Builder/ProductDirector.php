<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;

class ProductDirector
{
    public function buildSimpleProduct(SimpleProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setName('Simple Product');
        $p->setDescriptions(new Collection());

        $this->populateData($p, $data);

        unset($p->variations);

        return $p;
    }

    public function buildGeneralProduct(GeneralProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setName('General Product');
        $p->setDescriptions(new Collection());
        $p->setVariations(new Collection());


        $this->populateData($p, $data);


        return $p;
    }


    protected function populateData(&$p, $data)
    {
        if(!empty($data['descriptions'])){
            foreach ($data['descriptions'] as $k => $v){
                $p->descriptions->addItem($v, $k);
            }
        }

        if(!empty($data['variations'])){
            foreach ($data['variations'] as $v){

                $p->variations->addItem(new \vbpupil\Variation\SimpleVariation(
                    [
                        'title' => $v['title'],
                        'productCode' => $v['productCode']
                    ]
                ));

            }
        }


    }
}