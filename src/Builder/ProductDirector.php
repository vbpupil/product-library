<?php


namespace vbpupil\ProductLibrary\Builder;


use Vbpupil\Collection\Collection;
use vbpupil\Collections\OptionCollection;
use vbpupil\ProductLibrary\Price\SinglePrice;
use vbpupil\ProductLibrary\Variation\SingleVariation;

/**
 * Class ProductDirector
 * @package vbpupil\Builder
 */
class ProductDirector
{
    /**
     * @param SimpleProductBuilder $product
     * @param array $data
     * @return \vbpupil\Product\SimpleProduct
     * @throws \Exception
     */
    public function buildSimpleProduct(SimpleProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setType($data['type']);
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setProductImages(new Collection());

        $this->populateData($p, $data, $product);

        unset($p->variations);

        return $p;
    }

    /**
     * @param GeneralProductBuilder $product
     * @param array $data
     * @return \vbpupil\Product\GeneralProduct
     * @throws \Exception
     */
    public function buildGeneralProduct(GeneralProductBuilder $product, array $data = [])
    {
        $p = $product->getProduct();
        $p->setType($data['type']);
        $p->setName($data['product_name']);
        $p->setDescriptions(new Collection());
        $p->setVariations(new Collection());
        $p->setProductImages(new Collection());


        $this->populateData($p, $data, $product);


        return $p;
    }


    protected function populateData(&$p, $data, $originalObject)
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
                $tmpVariation = new SingleVariation(
                    [
                        'id' => $v['id'],
                        'title' => $v['title'],
                        'weight' => intval($v['weight']),
                        'packQty' => intval($v['pack_qty']),
                        'boxQty' => intval($v['box_qty']),
                        'reorderLevel' => intval($v['reorder_level']),
                        'minOrderQty' => intval($v['min_order_qty']),
                    ]
                );
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

                $tmpVariation->setOptions(new Collection());

                $have_options = false;
                //if options exists do - look into now
                foreach ($v['option_categories'] as $k1 => $v1) {
                    if (empty($v1['options'])) {
                        continue;
                    }

                    $tmp_cat_options = new OptionCollection();

                    foreach ($v1['options'] as $opt) {
                        $tmp_cat_options->addItem(
                            new \vbpupil\Option\Option(
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

                    $tmp_opt_cat = new \vbpupil\Option\OptionCategory(
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
        }


        if (!empty($data['options'])) {
            foreach ($data['options'] as $k => $v) {
                $p->descriptions->addItem($v, $k);
            }
        }
    }
}