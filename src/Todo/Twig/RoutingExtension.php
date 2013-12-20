<?php

namespace Todo\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension extends \Twig_Extension
{
    private $urlGenerator;
    private $requestStack;
    
    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }
    
    public function getPath($route, array $parameters = array(), $absolute = false)
    {
        return $this->urlGenerator->generate($route, $parameters, $absolute);
    }

    public function getGlobals()
    {
        return array(
            'request' => $this->requestStack->getCurrentRequest(),
        );
    }
 
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('path', array($this, 'getPath'))
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'routing';
    }
}
