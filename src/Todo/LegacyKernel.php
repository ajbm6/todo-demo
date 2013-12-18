<?php

namespace Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LegacyKernel implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if ('/list' === $request->getPathInfo()) {
            ob_start();
            include realpath(__DIR__.'/../../legacy/list.php');
            return new Response(ob_get_clean());
        }

        if ('/todo' === $request->getPathInfo()) {
            ob_start();
            include realpath(__DIR__.'/../../legacy/todo.php');
            return new Response(ob_get_clean());
        }

        return new Response('Lost?', Response::HTTP_NOT_FOUND);
    }
} 
