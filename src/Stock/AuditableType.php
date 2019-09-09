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
 */
class AuditableType extends Enum
{
    private const BOOK_IN = 'IN';
    private const BOOK_OUT = 'OUT';
    private const REJECTED = 'OUT';
}