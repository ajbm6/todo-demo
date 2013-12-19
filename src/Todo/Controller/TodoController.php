<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController
{
    public function indexAction(Request $request)
    {
        $foo = $request->attributes->get('foo');

        return new Response('Hello '.$request->getClientIp());
    }
} 
