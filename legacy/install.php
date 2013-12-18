<?php

if (!$conn = mysql_connect('localhost', 'root', '')) {
    die('Unable to connect to MySQL : '. mysql_errno() .' '. mysql_error());
}

$query = 'CREATE DATABASE IF NOT EXISTS `training_todo`;';

mysql_query($query) or die('Unable to create database : '. $query);

mysql_select_db('training_todo', $conn) or die('Unable to select database "training_todo": '. mysql_error());

mysql_query('drop table if exists todo;') or die('Unable to delete existing table "todo": '. mysql_error());

$query  = 'CREATE TABLE IF NOT EXISTS `todo` ('."\n";
$query .= '`id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,';
$query .= '`title` VARCHAR(100),'."\n";
$query .= '`is_done` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0);';

mysql_query($query, $conn) or die('Unable to create table "todo": '. $query .' - '. mysql_error());

$data = array(
  array('title' => 'Do the dishes', 'is_done' => 1),
  array('title' => 'Read a book', 'is_done' => 0),
  array('title' => 'Do the homework', 'is_done' => 0),
  array('title' => 'Cook some cakes for birthday', 'is_done' => 1),
);

foreach ($data as $todo) {
    mysql_query("INSERT INTO todo (title, is_done) VALUES ('". $todo['title'] ."','". $todo['is_done'] ."');")
      or die('Unable to insert new todo : '. $todo['title']);
}

echo 'Installation done!';
echo "\n";
