<?php

require_once realpath(__DIR__.'/../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;

if (!$conn = mysql_connect('localhost', 'root', '')) {
    die('Unable to connect to MySQL : '. mysql_errno() .' '. mysql_error());
}

mysql_select_db('training_todo', $conn) or die('Unable to select database "training_todo"');

$request = Request::createFromGlobals();
$request->overrideGlobals();
