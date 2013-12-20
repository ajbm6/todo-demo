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

    public function deleteAction($id)
    {
        $this->getGateway()->deleteTask($id);
        
        return $this->redirect($this->generateUrl('homepage'));
    }

    public function closeAction($id)
    {
        $this->getGateway()->closeTask($id);

        return $this->redirect($this->generateUrl('homepage'));
    }

    public function todoAction($id)
    {
        if (!$todo = $this->getGateway()->find($id)) {
            throw new NotFoundHttpException(sprintf(
                'No todo record found for primary key %u.',
                $id
            ));
        }

        return $this->render('todo', array('todo' => $todo));
    }

    public function indexAction(Request $request)
    {
        return $this->render('index', array(
            'count'   => $this->getGateway()->countAllTasks(),
            'tasks'   => $this->getGateway()->findAllTasks(),
        ));
    }

    public function createAction(Request $request)
    {
        $this->getGateway()->createNewTask($request->request->get('title'));
        
        return $this->redirect($this->generateUrl('homepage'));
    }
} 
