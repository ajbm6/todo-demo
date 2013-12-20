<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TodoController extends Controller
{
    private function getGateway()
    {
        return $this->container->get('todo_gateway');
    }

    public function deleteAction(Request $request, $id)
    {
        $this->getGateway()->deleteTask($id);
        
        return $this->redirect($request->getBasePath().'/');
    }

    public function closeAction(Request $request, $id)
    {
        $this->getGateway()->closeTask($id);

        return $this->redirect($request->getBasePath().'/');
    }

    public function todoAction(Request $request, $id)
    {
        if (!$todo = $this->getGateway()->find($id)) {
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
            'count'   => $this->getGateway()->countAllTasks(),
            'tasks'   => $this->getGateway()->findAllTasks(),
        ));
    }

    public function createAction(Request $request)
    {
        $this->getGateway()->createNewTask($request->request->get('title'));
        
        return $this->redirect('/');
    }
} 
