<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;

class ProductDirector
{
    public function buildSimpleProduct(SimpleProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setProductImages(new Collection());

        $this->populateData($p, $data);

        unset($p->variations);

        return $p;
    }

    public function buildGeneralProduct(GeneralProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setVariations(new Collection());
        $p->setProductImages(new Collection());


        $this->populateData($p, $data);


        return $p;
    }


    protected function populateData(&$p, $data)
    {
        if (isset($data['live']) && is_bool($data['live'])) {
            $p->setLive($data['live']);
        }

        if (isset($data['featured']) && is_bool($data['featured'])) {
            $p->setFeatured($data['featured']);
        }

        if (isset($data['best_seller']) && is_bool($data['best_seller'])) {
            $p->setBestSeller($data['best_seller']);
        }

        if (isset($data['new_product']) && is_bool($data['new_product'])) {
            $p->setNewProduct($data['new_product']);
        }

        if (isset($data['slug']) && $data['slug'] !== '') {
            $p->setSlug($data['slug']);
        }

        if (!empty($data['descriptions'])) {
            foreach ($data['descriptions'] as $k => $v) {
                $p->descriptions->addItem($v, $k);
            }
        }

        //
        if (!empty($data['product_images'])) {
            foreach ($data['product_images'] as $k => $v) {
                $p->product_images->addItem($v['path']);
            }
        }

        if (!empty($data['variations'])) {
            foreach ($data['variations'] as $v) {
                $p->variations->addItem(new \vbpupil\Variation\SimpleVariation(
                    [
                        'title' => $v['title'],
                        'product_code' => $v['product_code']
                    ]
                ));
            }
        }


        if (!empty($data['options'])) {
            foreach ($data['options'] as $k => $v) {
                $p->descriptions->addItem($v, $k);
            }
        }
    }
}