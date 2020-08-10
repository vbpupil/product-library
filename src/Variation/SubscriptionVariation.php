<?php
/**
 * \vbpupil\ProductLibrary\Variation\PhysicalVariation.php.
 * Version: 1.0.0 (02/07/2020)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Variation;


class SubscriptionVariation extends VirtualVariation
{
    /**
     * @var string How ofter payments are taken i.e. montly.
     */
    protected $subscription_period;

    /**
     * @var int Length of subscription - number of periods.
     */
    protected $subscription_length;
}
