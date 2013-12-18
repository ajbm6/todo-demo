<?php

namespace Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LegacyKernel implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if ('/hello' === $request->getPathInfo()) {
            return new Response('Hello World');
        }

        return new Response('Lost?', Response::HTTP_NOT_FOUND);
    }
} 
