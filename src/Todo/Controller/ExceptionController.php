<?php

namespace Todo\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends Controller
{
    public function exceptionAction(FlattenException $exception, Request $request)
    {
        $vars = array('request' => $request, 'exception' => $exception);
        
        try {
            $response = $this->render('error'.$exception->getStatusCode(), $vars);
        } catch (\Exception $e) {
            $response = $this->render('error', $vars);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
 
        return $response;       
    }
} 
