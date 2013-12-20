<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Todo\ApplicationKernel;

$container = new ContainerBuilder();
$container->setParameter('kernel.root_dir', __DIR__);
$container->setParameter('file_locator.paths', array('%kernel.root_dir%/config'));

$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('config/services.yml');


$request = Request::createFromGlobals();
$request->overrideGlobals();

$kernel = new ApplicationKernel($container->get('http_kernel'));
$response = $kernel->handle($request);
$response->prepare($request);
$response->send();
