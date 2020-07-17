<?php
/**
 * \vbpupil\ProductLibrary\Variation\PhysicalVariation.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Variation;


class DownloadableVariation extends AbstractVariation
{
    /**
     * @var string Downloadable resoure.
     */
    protected $resources;

    /**
     * @var int No of downloads allowed.
     */
    protected $downloads_max;
}
