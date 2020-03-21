<?php

namespace vbpupil\Stock\Auditable;


use vbpupil\Traits\DateTrait;

/**
 * Class Auditable
 * @package vbpupil\Stock
 *
 * An auditable is an object which is to be used to explain stock in both directions.
 * It requires a qty, type, description and date string - (although description can be blank ie '')
 *
 * The qty and the type are very important as these explain how many and why,
 * for instance a type of BOOK_IN will show 5 entering the stock room.
 *
 * Direction is a consequence of the type and simply indicates if stock is inbound or outbound.
 */
class Auditable
{
    use DateTrait;

    /**
     * @var int
     */
    protected $qty;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var const
     */
    protected $type;

    /**
     * @var string
     */
    protected $direction;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var AuditableAssociatedDocumentType|null
     */
    protected $associatedDocType;

    /**
     * @var int|null
     */
    protected $associatedDocID;

    /**
     * Auditable constructor.
     * @param int $qty - the amount being booked in/out
     * @param AuditableType $type - the type of transaction book in/book out etc
     * @param string $description - any additional info offered by the end user
     * @param $date - the date and time of the event
     * @param AuditableAssociatedDocumentType|null $associatedDocType - the type of document supporting this transaction ie SALES ORDER this info is optional
     * @param int|null $associatedDocID - the ID of the SALES ORDER this info is optional
     * @throws \Exception
     */
    public function __construct(int $qty, AuditableType $type, string $description = '', $date, ?AuditableAssociatedDocumentType $associatedDocType, ?int $associatedDocID)
    {
        if (!$this->isDateTimeString($date)) {
            throw new \Exception('Invalid Date Format - requires 2019-01-01 14:22:00');
        }

        $this->qty = $qty;
        $this->type = $type->getKey();

        $this->direction = $this->decideDirection();

        $this->description = $description;
        $this->date = $date;

        if ($associatedDocType) {
            $this->associatedDocType = $associatedDocType->getKey();
        }

        if ($associatedDocID) {
            $this->associatedDocID = $associatedDocID;
        }
    }

    /**
     * @return string
     */
    protected function decideDirection()
    {
        switch ($this->type) {
            case 'BOOK_IN':
            case 'RETURN_NOT_REQUIRED':
                return 'IN';
                break;
            case 'SALE':
            case 'BOOK_OUT':
                return 'OUT';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * @return int
     */
    public function getTypeValue(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getAssociatedDocType(): ?string
    {
        return $this->associatedDocType;
    }

    /**
     * @return int|null
     */
    public function getAssociatedDocID(): ?int
    {
        return $this->associatedDocID;
    }

}