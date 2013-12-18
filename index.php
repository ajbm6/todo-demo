<?php

require_once realpath(__DIR__.'/vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Todo\LegacyKernel;

$kernel = new LegacyKernel();
$response = $kernel->handle(Request::createFromGlobals());
$response->send();
