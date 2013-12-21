<?php

namespace Todo\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension extends \Twig_Extension
{
    /**
     * A url generator.
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Constructor.
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Returns a generated url.
     *
     * @param  string  $route      The route name
     * @param  array   $parameters The route parameters
     * @param  boolean $absolute   Whether or not the url must be absolute
     * @return string
     */
    public function getPath($route, array $parameters = array(), $absolute = false)
    {
        return $this->urlGenerator->generate($route, $parameters, $absolute);
    }

    /**
     * Returns an array of new Twig functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('path', array($this, 'getPath')),
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
