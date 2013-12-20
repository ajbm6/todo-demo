<?php

namespace Todo\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Todo\Controller\Controller;
use Todo\Controller\TodoController;
use Todo\Model\TodoGateway;

class ControllerListener implements EventSubscriberInterface
{
    private $templating;
    private $todoGateway;

    public function __construct(\Twig_Environment $templating, TodoGateway $todoGateway)
    {
        $this->templating = $templating;
        $this->todoGateway = $todoGateway;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $callable = $event->getController();
        $controller = $callable[0];

        if ($controller instanceof Controller) {
            $controller->setTemplating($this->templating);
        }
        
        if ($controller instanceof TodoController) {
            $controller->setGateway($this->todoGateway);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController', 100),
        );
    }
} 
