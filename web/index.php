<?php

require_once realpath(__DIR__.'/../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Todo\ApplicationKernel;

$request = Request::createFromGlobals();
$request->overrideGlobals();

$kernel = new ApplicationKernel(realpath(__DIR__.'/..'));
$response = $kernel->handle($request);
$response->prepare($request);
$response->send();

$kernel->terminate($request, $response);
