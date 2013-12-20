<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Todo\ApplicationKernel;

$container = new ContainerBuilder();
$container->setParameter('kernel.root_dir', __DIR__);

$request = Request::createFromGlobals();
$request->overrideGlobals();

$kernel = new ApplicationKernel($container);
$response = $kernel->handle($request);
$response->prepare($request);
$response->send();
