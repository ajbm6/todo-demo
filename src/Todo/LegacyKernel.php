<?php

namespace Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class LegacyKernel implements HttpKernelInterface
{
    private $urlMatcher;

    public function __construct(UrlMatcherInterface $urlMatcher)
    {
        $this->urlMatcher = $urlMatcher;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        try {
            $params = $this->urlMatcher->match($request->getPathInfo());
            
            if (isset($params['script'])) {
                return $this->executeLegacyScript($params['script']);
            }
            
            if (!isset($params['_controller'])) {
                throw new \RuntimeException(sprintf(
                    'No controller has been set for the route %s.',
                    $params['_route']
                ));
            }
            
            $parts = explode('::', $params['_controller']);
            $className = $parts[0];
            $actionName = $parts[1];

            $object = new $className();
            $controller = array($object, $actionName);
            if (!is_callable($controller)) {
                throw new \RuntimeException(sprintf(
                    'Controller %s::%s is not a valid callable',
                    $className,
                    $actionName
                ));
            }
            
            $request->attributes->add($params);
            $response = call_user_func_array($controller, array($request));
            if (!$response instanceof Response) {
                throw new \RuntimeException(sprintf(
                    'Controller %s::%s must return a response object (%s given).',
                    $className,
                    $actionName,
                    gettype($response)
                ));
            }

            return $response;
            
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

    private function executeLegacyScript($scriptName)
    {
        ob_start();
        include realpath(__DIR__.'/../../legacy/'.$scriptName.'.php');

        return new Response(ob_get_clean());
    }
} 
