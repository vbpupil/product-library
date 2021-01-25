<?php


namespace vbpupil\ProductLibrary\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\ProductLibrary\Collections\OptionCollection;
use vbpupil\ProductLibrary\Price\PivotPrice;
use vbpupil\ProductLibrary\Price\SinglePrice;
use vbpupil\ProductLibrary\Traits\JsonValidateTrait;
use vbpupil\ProductLibrary\Variation\PhysicalVariation;

/**
 * Class ProductDirector
 * @package vbpupil\Builder
 */
class ProductDirector
{
    use JsonValidateTrait;

    /**
     * @param SimpleProductBuilder $builder
     * @param array $data
     * @return \vbpupil\ProductLibrary\Product\SimpleProduct
     * @throws \Exception
     */
    public function buildSimpleProduct(SimpleProductBuilder $builder, array $data = [])
    {
        $builder->initProduct($data['style']);
        $p = $builder->getProduct();
        $p->setType($data['type']);
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setProductImages(new Collection());

        $this->populateData($p, $data, $builder);

        unset($p->variations);

        return $p;
    }

    /**
     * @param GeneralProductBuilder $builder
     * @param array $data
     * @return \vbpupil\ProductLibrary\Product\GeneralProduct
     * @throws \Exception
     */
    public function buildGeneralProduct(GeneralProductBuilder $builder, array $data = [])
    {
        $builder->initProduct($data['style']);
        $builder->getProduct();
        $p = $builder->getProduct();
        $p->setType($data['type']);
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setVariations(new Collection());
        $p->setProductImages(new Collection());


        $this->populateData($p, $data, $builder);

        $this->setCheapestVariantDetails($p);

        return $p;
    }


    protected function populateData(&$p, $data, $originalObject)
    {
        $kill_variation = false; //something serious has gone wrong - remove this variant

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

        $p->setBrandId($data['brand_id']);
        $p->setBrandName($data['brand_name']);
        $p->setBrandSlug($data['brand_slug']);

        //
        if (!empty($data['product_images'])) {
            foreach ($data['product_images'] as $k => $v) {
                $p->product_images->addItem($v['path']);
            }
        }

        if (!empty($data['variations'])) {
            $abort = false; //allows us to exit loop - somehting has gone wrong

            foreach ($data['variations'] as $k => $v) {
                // TODO use product style to fetch variation
                $tmpVariation = new PhysicalVariation(
                    [
                        'id' => $v['id'],
                        'title' => $v['title'],
                        'weight' => intval($v['weight']),
                        'packQty' => intval($v['pack_qty']),
                        'boxQty' => intval($v['box_qty']),
                        'reorderLevel' => intval($v['reorder_level']),
                        'minOrderQty' => intval($v['min_order_qty']),
                        'productCode' => ($v['product_code'] ?: ''),
                        'barcode' => ($v['barcode'] ?: ''),
                        'ean' => ($v['ean'] ?: ''),
                        'mpn' => ($v['mpn'] ?: ''),
                        'price_type' => $v['price_type'],
                        'unit_of_sale' => $v['unit_of_sale'],
                        'min_del_qty' => intval($v['min_delivery_qty']),
                        'max_del_qty' => intval($v['max_delivery_qty']),
                        'brand_id' => ($v['brand_id'] ?: ''),
                        'brand_name' => ($v['brand_name'] ?: '')

                    ]
                );

                $tmpVariation->setStyleOptions($v['style_options']);

                switch ($v['price_type']) {
                    case 'single':
                        $tmpVariation->setPrice(
                            new SinglePrice([
                                'vatRate' => $v['vat'],
                                'vatRateId' => $v['vat_rate_id'],
                                'exVat' => intval($v['price']),
                                'currency' => 'GBP',
                                'specialPriceActive' => $v['special_price_active'],
                                'specialPriceActiveUntil' => $v['special_price_expiry'],
                                'specialPrice' => intval($v['special_price']),
                                'showSpecialOfferCountdown' => intval($v['special_price_countdown']),
                            ])
                        );
                        break;
                    case 'pivot':
                        try {
                            $tmpVariation->setPrice(
                                new PivotPrice([
                                    'pivot' => $v['price_pivot'],
                                    'vatRate' => $v['vat'],
                                    'vatRateId' => $v['vat_rate_id'],
                                    'currency' => 'GBP'
                                ])
                            );
                        } catch (\Exception $e) {
                            //variant price has gone wrong in some way lets kill this variant
                            $abort = true;
                            $kill_variation = true;
                        }
                        break;
                }

                if ($abort) {
                    continue;
                }


                $tmpVariation->setOptions(new Collection());

                $have_options = false;
                //if options exists do - look into now
                foreach ($v['option_categories'] as $k1 => $v1) {
                    if (empty($v1['options'])) {
                        continue;
                    }

                    $tmp_cat_options = new \vbpupil\ProductLibrary\Collections\OptionCollection();

                    foreach ($v1['options'] as $opt) {
                        $tmp_cat_options->addItem(
                            new \vbpupil\ProductLibrary\Option\Option(
                                $opt['id'],
                                $opt['title'],
                                $opt['price_ex_vat'],
                                $opt['qty'],
                                $opt['cost_ex_vat'],
                                $opt['rrp_ex_vat'],
                                $opt['weight'],
                                $opt['prod_code'],
                                $opt['ean']
                            )
                        );
                    }

                    $tmp_opt_cat = new \vbpupil\ProductLibrary\Option\OptionCategory(
                        $v1['id'],
                        $v1['title'],
                        $tmp_cat_options
                    );

                    $have_options = true;
                    $tmpVariation->options->addItem($tmp_opt_cat);
                }

                if ($have_options) {
                }


                if ($originalObject instanceof GeneralSimpleProductBuilder) {
                    $p->variations->addItem($tmpVariation);
                    break;
                }

                $p->variations->addItem($tmpVariation);
            }

            if ($kill_variation) {
                unset($p);
            }
        }


        if (!empty($data['options'])) {
            foreach ($data['options'] as $k => $v) {
                $p->descriptions->addItem($v, $k);
            }
        }
    }


    /**
     * loops through all variant details and gives details on the cheapest variant
     * helpful eh!
     * @param $p
     */
    public function setCheapestVariantDetails($p)
    {
        $cheapestPrice = null;
        $cheapestVariantId = null;
        $variantPriceTypes = []; //outlines what types of variants a product contains - ie singlePrice and/or pivot

        foreach ($p->variations->getItems() as $item) {
            switch ($item->getPriceType()) {
                case 'pivot':
                    if (is_null($cheapestPrice) || $cheapestPrice > $item->prices->getCheapest()['price']) {
                        $cheapestPrice = $item->prices->getCheapest()['price'];
                        $cheapestVariantId = $item->getId();
                    }

                    if (!in_array('pivot', $variantPriceTypes)) {
                        $variantPriceTypes[] = 'pivot';
                    }
                    break;
                case 'single':
                    if (is_null($cheapestPrice) || $cheapestPrice > $item->prices->getPrice()) {
                        $cheapestPrice = $item->prices->getPrice();
                        $cheapestVariantId = $item->getId();
                    }

                    if (!in_array('single', $variantPriceTypes)) {
                        $variantPriceTypes[] = 'single';
                    }
                    break;
            }
        }

        if (!is_null($cheapestVariantId) && !is_null($cheapestPrice)) {
            $p->setCheapestVariantiD($cheapestVariantId);
            $p->setCheapestVariantPrice($cheapestPrice);
        }

        $p->setVariantPriceTypes($variantPriceTypes);
    }
}
