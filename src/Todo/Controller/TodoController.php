<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController
{
    public function indexAction(Request $request)
    {
        if (!$conn = mysql_connect('localhost', 'root', '')) {
            die('Unable to connect to MySQL : '. mysql_errno() .' '. mysql_error());
        }

        mysql_select_db('training_todo', $conn) or die('Unable to select database "training_todo"');

        $result = mysql_query('SELECT COUNT(*) FROM todo', $conn);
        $count  = current(mysql_fetch_row($result));
        
        $result = mysql_query('SELECT * FROM todo', $conn);
        $tasks = array();
        while ($todo = mysql_fetch_assoc($result)) {
            $tasks[] = $todo;
        }

        mysql_close($conn);
        
        return $this->render('index', array(
            'request' => $request,
            'count'   => $count,
            'tasks'   => $tasks,
        ));
    }

    private function render($view, array $variables = array())
    {
        extract($variables);
        ob_start();
        include realpath(__DIR__.'/../../../views/'.$view.'.php');
        
        return new Response(ob_get_clean());
    }
} 
