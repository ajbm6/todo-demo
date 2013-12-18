<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Todo\LegacyKernel;

$routes = include realpath(__DIR__.'/config/routes.php');

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

$kernel = new LegacyKernel($urlMatcher);
$response = $kernel->handle($request);
$response->send();
