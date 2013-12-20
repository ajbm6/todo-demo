<?php

namespace Database;

interface ConnectionInterface
{
    public function quote($param);

    public function query($sql);

    public function exec($sql);

    public function getLastInsertId();

    public function fetchOne($sql);

    public function fetchAll($sql);
} 
