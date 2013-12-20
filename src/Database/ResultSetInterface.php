<?php

namespace Database;

interface ResultSetInterface extends \Countable, \Iterator
{
    public function getFirst();

    public function getLast();

    public function get($index);

    public function isEmpty();
} 
