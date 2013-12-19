<?php

namespace Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class ApplicationKernel implements HttpKernelInterface
{
    private $httpKernel;
    private $urlMatcher;

    public function __construct(HttpKernelInterface $httpKernel, UrlMatcherInterface $urlMatcher)
    {
        $this->httpKernel = $httpKernel;
        $this->urlMatcher = $urlMatcher;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        try {
            $params = $this->urlMatcher->match($request->getPathInfo());

            $request->attributes->add($params);

            return $this->httpKernel->handle($request, $type, false);
        } catch (NotFoundHttpException $e) {
            return new Response('Page Not Found', Response::HTTP_NOT_FOUND);
        } catch (ResourceNotFoundException $e) {
            return new Response('Lost?', Response::HTTP_NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            return new Response('Method Not Allowed!', Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\Exception $e) {
            if ($catch) {
                return new Response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
            }   
            throw $e;
        }
    }
} 
