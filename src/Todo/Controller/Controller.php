<?php

namespace Todo\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller extends ContainerAware
{
    protected function redirect($url)
    {
        return new RedirectResponse($url);
    }

    protected function generateUrl($route, array $parameters = array(), $absolute = false)
    {
        return $this->container->get('router')->generate($route, $parameters, $absolute);
    }
    
    protected function render($view, array $variables = array())
    {
        return new Response($this->container->get('templating')->render($view.'.twig', $variables));
    }
} 
