<?php
/**
 * OptionCategory.php.
 * Version: 1.0.0 (17/09/19)
 * Copyright: Freetimers Internet
 * Author:   Dean Haines
 */

namespace vbpupil\Option;


use vbpupil\Collections\OptionCollection;

/**
 * Class OptionCategory
 * @package vbpupil\Option
 */
class OptionCategory
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var OptionCollection
     */
    public $options;

    /**
     * OptionCategory constructor.
     * @param int $id
     * @param string $title
     * @param \vbpupil\Option\OptionCollection $options
     */
    public function __construct(int $id, string $title, OptionCollection $options)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setOptions($options);
    }

    /**
     * @return mixed
     */
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OptionCategory
     */
    protected function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle():string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return OptionCategory
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param OptionCollection $options
     */
    protected function setOptions(OptionCollection $options)
    {
        $this->options = $options;
    }


}