<?php

namespace Todo\Controller;

use Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Todo\Model\TodoGateway;

class TodoController extends Controller
{
    private $gateway;

    public function __construct()
    {
        parent::__construct();

        $this->gateway = new TodoGateway(new Connection('training_todo', 'root'));
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
} 
