<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller
{
    protected $templating;

    public function setTemplating(\Twig_Environment $templating)
    {
        $this->templating = $templating;
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
