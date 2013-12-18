<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Todo\LegacyKernel;


$locator = new FileLocator(array(realpath(__DIR__.'/config')));
$loader  = new YamlFileLoader($locator);
$routes  = $loader->load('routes.yml');

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

$kernel = new LegacyKernel($urlMatcher);
$response = $kernel->handle($request);
$response->send();
