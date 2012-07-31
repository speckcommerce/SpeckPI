<?php

namespace SpeckPI\Entity;

class PerformanceIndicator
{
    const TYPE_INT    = 'int';
    const TYPE_STRING = 'string';

    protected $itemId = null;
    protected $key    = null;
    protected $value  = null;
    protected $type   = null;

    public function __construct($key = null, $value = null, $type = self::TYPE_STRING)
    {
        $this->key = $key;
        $this->value = $value;
        $this->type = $type;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getValue()
    {
        if ($this->type === self::TYPE_INT) {
            return intval($this->value);
        }

        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type = self::TYPE_STRING)
    {
        $this->type = $type;
        return $this;
    }
}

