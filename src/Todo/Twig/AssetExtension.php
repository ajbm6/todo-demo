<?php

namespace Todo\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

class AssetExtension extends \Twig_Extension
{
    /**
     * The request stack.
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Returns an asset path.
     *
     * @param  string $path A relative or absolute path
     * @return string
     */
    public function getAssetPath($path)
    {
        if ('/' === $path[0]) {
            return $path;
        }

        return $this->getRequest()->getBasePath().'/'.$path;
    }

    /**
     * Returns an array of Twig global variables.
     *
     * @return array
     */
    public function getGlobals()
    {
        return array('request' => $this->getRequest());
    }

    /**
     * Returns an array of Twig new functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('asset', array($this, 'getAssetPath')),
        );
    }

    /**
     * Returns the master request.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    private function getRequest()
    {
        return $this->requestStack->getMasterRequest();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'asset';
    }
}
