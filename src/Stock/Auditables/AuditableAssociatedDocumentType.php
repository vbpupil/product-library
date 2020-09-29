<?php
/**
 * AuditableAssociatedDocumentTypeDocumentType.php
 * Version: 1.0.0 (09/09/19)

 * Author:   Dean Haines
 */


namespace vbpupil\ProductLibrary\Stock\Auditables;

use MyCLabs\Enum\Enum;

/**
 * a AuditableAssociatedDocumentType is a list of supporting documents - ie when a sales order is processed the supporting type is a
 * sales order document - the same as a purchase order is a supporting document etc etc.
 *
 * @method static self SALES_ORDER()
 * @method static self BOOKING_IN()
 * @method static self BOOKING_OUT()
 * @method static self MANUAL_STOCK_AMENDMENT()
 */
class AuditableAssociatedDocumentType extends Enum
{
    /**
     *
     */
    private const SALES_ORDER = 'SALES_ORDER';

    /**
     *
     */
    private const BOOKING_IN = 'BOOKING_IN';

    /**
     *
     */
    private const BOOKING_OUT = 'BOOKING_OUT';

    /**
     *
     */
    private const MANUAL_STOCK_AMENDMENT = 'MANUAL_STOCK_AMENDMENT';
}