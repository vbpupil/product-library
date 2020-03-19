<?php


namespace vbpupil\Builder;


use Vbpupil\Collection\Collection;

/**
 * Class ProductDirector
 * @package vbpupil\Builder
 */
class ProductDirector
{
    /**
     * @param SimpleProductBuilder $product
     * @param array $data
     * @return \vbpupil\Product\Product
     * @throws \Exception
     */
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

    /**
     * @param GeneralProductBuilder $product
     * @param array $data
     * @return \vbpupil\Product\Product
     * @throws \Exception
     */
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


    /**
     * @param $p
     * @param $data
     * @throws \Exception
     */
    protected function populateData(&$p, $data)
    {
        if (isset($data['id']) && $data['id'] !== '') {
            $p->setId($data['id']);
        }

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
            foreach ($data['variations'] as $k => $v) {
                $tmpVariation = new \vbpupil\Variation\SimpleVariation(
                    [
                        'title' => $v['title'],
                        'packQty' => intval($v['pack_qty']),
                        'boxQty' => intval($v['box_qty']),
                        'reorderLevel' => intval($v['reorder_level']),
                        'minOrderQty' => intval($v['min_order_qty']),
                    ]
                );
                $tmpVariation->setPrice(
                    new \vbpupil\Price\SinglePrice([
                            'vatRate' => 20,
                            'exVat' => intval($v['price']),
                            'currency' => 'GBP',
                            'specialPriceActive' => $v['special_price_active'],
                            'specialPriceActiveUntil' => $v['special_price_expiry'],
                            'specialPrice' => intval($v['special_price'])
                        ])
                );

                $p->variations->addItem($tmpVariation);
            }
        }


        if (!empty($data['options'])) {
            foreach ($data['options'] as $k => $v) {
                $p->descriptions->addItem($v, $k);
            }
        }
    }
}