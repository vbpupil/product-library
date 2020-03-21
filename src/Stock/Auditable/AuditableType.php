<?php
/**
 * AuditableType.php
 * Version: 1.0.0 (09/09/19)

 * Author:   Dean Haines
 */


namespace vbpupil\Stock\Auditable;

use MyCLabs\Enum\Enum;

/**
 * an AuditableType is the reason for the stock movement change so book in/out, return of damaged stock etc etc.
 *
 * @method static self SALE()
 * @method static self BOOK_IN()
 * @method static self BOOK_OUT()
 * @method static self RETURN_FAULTY()
 * @method static self RETURN_DAMAGED()
 * @method static self RETURN_NOT_REQUIRED()
 */
class AuditableType extends Enum
{
    //PLACE BACK INTO STOCK
    private const SALE = 'SALE'; //sold to customer
    private const BOOK_IN = 'BOOK_IN'; //booked in from supplier
    private const BOOK_OUT = 'BOOK_OUT'; //booked out
    private const RETURN_FAULTY = 'RETURN_FAULTY'; //customer returned - faulty item
    private const RETURN_DAMAGED = 'RETURN_DAMAGED'; //customer returned - damaged item
    private const RETURN_NOT_REQUIRED = 'RETURN_NOT_REQUIRED'; //surplus to requirements
}