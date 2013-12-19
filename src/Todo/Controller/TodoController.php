<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Todo\Model\TodoGateway;

class TodoController
{
    private $templating;
    private $gateway;

    public function __construct()
    {
        $this->gateway = new TodoGateway('training_todo', 'root');

        $loader = new \Twig_Loader_Filesystem(array(
            realpath(__DIR__.'/../../../views')
        ));

        $this->templating = new \Twig_Environment($loader, array(
            'debug' => true,
            'strict_variables' => true,
            'cache' => realpath(__DIR__.'/../../../cache')
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $this->gateway->deleteTask($id);
        
        return $this->redirect($request->getBasePath().'/');
    }

    public function closeAction(Request $request, $id)
    {
        $this->gateway->closeTask($id);

        return $this->redirect($request->getBasePath().'/');
    }

    public function todoAction(Request $request, $id)
    {
        if (!$todo = $this->gateway->find($id)) {
            throw new NotFoundHttpException(sprintf(
                'No todo record found for primary key %u.',
                $id
            ));
        }

        return $this->render('todo', array(
            'request' => $request,
            'todo'    => $todo,
        ));
    }

    public function indexAction(Request $request)
    {
        return $this->render('index', array(
            'request' => $request,
            'count'   => $this->gateway->countAllTasks(),
            'tasks'   => $this->gateway->findAllTasks(),
        ));
    }

    public function createAction(Request $request)
    {
        $this->gateway->createNewTask($request->request->get('title'));
        
        return $this->redirect('/');
    }
    
    private function redirect($url)
    {
        return new RedirectResponse($url);
    }
    
    private function render($view, array $variables = array())
    {
        return new Response($this->templating->render($view.'.twig', $variables));
    }
} 
