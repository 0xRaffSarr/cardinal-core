<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Collection;


class Collection implements \Iterator, \ArrayAccess, \Countable
{
    /**
     * @var int
     */
    private $position = 0;
    /**
     * @var array
     */
    protected $obj = [];


    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->obj[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return isset($this->obj[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->obj[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return ((isset($this->obj[$offset])) ? $this->obj[$offset] : null);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if(is_null($offset)) {
            $this->obj[] = $value;
        }
        else {
            $this->obj[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if(isset($this->obj[$offset])) {
            unset($this->obj[$offset]);
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->obj);
    }
}

