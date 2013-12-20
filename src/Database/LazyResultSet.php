<?php

namespace Database;

class LazyResultSet extends ResultSet
{
    private $result;
    private $loaded;

    public function __construct($result)
    {
        $this->loaded = false;
        $this->result = $result;
        
        parent::__construct();
    }

    public function getFirst()
    {
        $this->load();

        return parent::getFirst();
    }

    public function getLast()
    {
        $this->load();

        return parent::getLast();
    }

    public function get($index)
    {
        $this->load();

        return parent::get($index);
    }

    public function isEmpty()
    {
        $this->load();

        return parent::isEmpty();
    }

    public function current()
    {
        $this->load();

        return parent::current();
    }

    public function next()
    {
        $this->load();

        return parent::next();
    }

    public function key()
    {
        $this->load();

        return parent::key();
    }

    public function valid()
    {
        $this->load();

        return parent::valid();
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function count()
    {
        $this->load();

        return parent::count();
    }

    private function load()
    {
        if ($this->loaded) {
            return;
        }

        while ($item = mysql_fetch_assoc($this->result)) {
            $this->items[] = $item;
        }

        $this->loaded = true;
    }
}
