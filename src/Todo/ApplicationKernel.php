<?php

namespace Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ApplicationKernel implements HttpKernelInterface
{
    private $httpKernel;

    public function __construct(HttpKernelInterface $httpKernel)
    {
        $this->httpKernel = $httpKernel;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return $this->httpKernel->handle($request, $type, $catch);
    }
} 
