<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller
{
    protected $templating;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(array(
            realpath(__DIR__.'/../../../views')
        ));

        $this->templating = new \Twig_Environment($loader, array(
            'debug' => true,
            'strict_variables' => true,
            'cache' => realpath(__DIR__.'/../../../cache')
        ));
    }

    protected function redirect($url)
    {
        return new RedirectResponse($url);
    }

    protected function render($view, array $variables = array())
    {
        return new Response($this->templating->render($view.'.twig', $variables));
    }
} 
