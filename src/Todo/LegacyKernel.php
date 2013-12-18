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
            return $this->executeLegacyScript('list');
        }

        if ('/todo' === $request->getPathInfo()) {
            return $this->executeLegacyScript('todo');
        }

        return new Response('Lost?', Response::HTTP_NOT_FOUND);
    }

    private function executeLegacyScript($scriptName)
    {
        ob_start();
        include realpath(__DIR__.'/../../legacy/'.$scriptName.'.php');

        return new Response(ob_get_clean());
    }
} 
