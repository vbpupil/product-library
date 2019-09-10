<?php

namespace vbpupil\Stock;


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
     * Auditable constructor.
     * @param int $qty
     * @param AuditableType $type
     * @param string $description
     * @param $date
     * @throws \Exception
     */
    public function __construct(int $qty, AuditableType $type, string $description = '', $date)
    {
        if (!$this->isDateTimeString($date)) {
            throw new \Exception('Invalid Date Format - requires 2019-01-01 14:22:00');
        }

        $this->qty = $qty;
        $this->type = $type->getKey();
        $this->direction = $type->getValue();
        $this->description = $description;
        $this->date = $date;
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


}