<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('homepage', new Route('/', array('script' => 'list')));
$routes->add('todo_list', new Route('/list.php', array('script' => 'list')));
$routes->add('todo_show', new Route('/todo.php', array('script' => 'todo')));

return $routes;
