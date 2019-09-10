<?php
/**
 * AuditableType.php
 * Version: 1.0.0 (09/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */


namespace vbpupil\Stock;

use MyCLabs\Enum\Enum;

/**
 * @method static self BOOK_IN()
 * @method static self BOOK_OUT()
 * @method static self REJECTED()
 * @method static self RETURN_FAULTY()
 * @method static self RETURN_DAMAGED()
 * @method static self RETURN_NOT_REQUIRED()
 */
class AuditableType extends Enum
{
    //PLACE BACK INTO STOCK
    private const BOOK_IN = 'IN';
    private const RETURN_NOT_REQUIRED = 'IN';

    private const BOOK_OUT = 'OUT';
    private const REJECTED = 'OUT';

    //NOT PLACED BACK INTO STOCK
    private const RETURN_FAULTY = '';
    private const RETURN_DAMAGED = '';
}