<?php
/**
 * OptionCategory.php.
 * Version: 1.0.0 (17/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */

namespace vbpupil\Option;

use Vbpupil\Collection\Collection;

class OptionCategory
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $options;

    /**
     * OptionCategory constructor.
     * @param int $id
     * @param string $name
     * @param Collection $options
     */
    public function __construct(int $id, string $name, Collection $options)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setOptions($options);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OptionCategory
     */
    protected function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return OptionCategory
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param \Vbpupil\Collection\Collection $options
     */
    protected function setOptions($options)
    {
        $this->options = $options;
    }
}