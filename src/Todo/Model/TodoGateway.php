<?php

namespace Todo\Model;

use Database\ConnectionInterface;
use Database\DatabaseException;

class TodoGateway
{
    private $database;

    public function __construct(ConnectionInterface $database)
    {
        $this->database = $database;
    }

    public function deleteTask($pk)
    {
        try {
            return $this->database->exec('DELETE FROM todo WHERE id = '. (int) $pk);
        } catch (DatabaseException $e) {
            throw new GatewayException(sprintf('Unable to delete existing task #%u.', $pk), 0, $e);
        }
    }

    public function closeTask($pk)
    {
        try {
            return $this->database->exec('UPDATE todo SET is_done = 1 WHERE id = '. (int) $pk);
        } catch (DatabaseException $e) {
            throw new GatewayException(sprintf('Unable to close existing task #%u.', $pk), 0, $e);
        }
    }
    
    public function createNewTask($title)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty.');
        }

        $safeTitle = $this->database->quote($title);

        try {
            $this->database->exec(sprintf("INSERT INTO todo (title) VALUES('%s');", $safeTitle));
        } catch (DatabaseException $e) {
            throw new GatewayException(sprintf('Unable to create new "%s" task.', $title), 0, $e);
        }

        return $this->database->getLastInsertId();
    }
    
    public function find($pk)
    {
        return $this->database->fetchOne('SELECT * FROM todo WHERE id = '. (int) $pk);
    }

    public function findAllTasks()
    {
        return $this->database->fetchAll('SELECT * FROM todo');
    }
    
    public function countAllTasks()
    {
        $record = $this->database->fetchOne('SELECT COUNT(*) FROM todo');

        return (int) current($record);
    }
} 
