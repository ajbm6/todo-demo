<?php

namespace Database;

class ResultSet implements ResultSetInterface
{
    protected $items;

    public function __construct(array $items = array())
    {
        $this->items = $items;
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid()
    {
        return null !== $this->key() && false !== $this->key();
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function getFirst()
    {
        return $this->get(0);
    }

    public function getLast()
    {
        return $this->get($this->count() - 1);
    }

    public function get($index)
    {
        if (isset($this->items[$index])) {
            return $this->items[$index];
        }
    }
}
