<?php

namespace vbpupil\Builder;

use Vbpupil\Collection\Collection;
use vbpupil\Product\Product;

/**
 * Interface ProductBuilderInterface
 * @package vbpupil\Builder
 */
interface ProductBuilderInterface
{

    /**
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return mixed
     */
    public function setDescriptions(Collection $descriptions);

    /**
     * @return mixed
     */
    public function setVariations(Collection $variations);

    /**
     * @return mixed
     */
    public function setLive(bool $live);
}