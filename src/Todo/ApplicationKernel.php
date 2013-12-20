<?php

namespace Todo;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ApplicationKernel implements HttpKernelInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $root = $this->container->getParameter('kernel.root_dir');
        $loader = new YamlFileLoader($this->container, new FileLocator($root));
        $loader->load('config/services.yml');

        return $this->container->get('http_kernel')->handle($request, $type, $catch);
    }
} 
