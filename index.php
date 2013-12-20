<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Todo\ApplicationKernel;


$locator = new FileLocator(array(realpath(__DIR__.'/config')));
$loader  = new YamlFileLoader($locator);
$routes  = $loader->load('routes.yml');

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addSubscriber(new RouterListener($urlMatcher, $context));
$eventDispatcher->addSubscriber(new ExceptionListener('Todo\\Controller\\ExceptionController::exceptionAction'));


$resolver = new ControllerResolver();
$httpKernel = new HttpKernel($eventDispatcher, $resolver);

$kernel = new ApplicationKernel($httpKernel);
$response = $kernel->handle($request);
$response->send();
