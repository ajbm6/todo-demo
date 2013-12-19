<?php

namespace Todo\Model;

class TodoGateway
{
    private $username;
    private $password;
    private $hostname;
    private $database;
    private $port;
    private $conn;

    public function __construct($database, $username, $password = null, $hostname = 'localhost', $port = 3306)
    {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->hostname = $hostname;
        $this->port     = (int) $port;
    }

    public function deleteTask($pk)
    {
        $conn = $this->connect();

        $query = 'DELETE FROM todo WHERE id = '. (int) $pk;

        if (!mysql_query($query, $conn)) {
            throw new DatabaseException(sprintf(
                'Unable to delete existing task #%u: %s',
                $pk,
                mysql_error()
            ));
        }

        return 1 === mysql_affected_rows($conn);
    }

    public function closeTask($pk)
    {
        $conn = $this->connect();

        $query = 'UPDATE todo SET is_done = 1 WHERE id = '. (int) $pk;

        if (!mysql_query($query, $conn)) {
            throw new DatabaseException(sprintf(
                'Unable to close existing task #%u: %s',
                $pk,
                mysql_error()
            ));
        }

        return 1 === mysql_affected_rows($conn);
    }
    
    public function createNewTask($title)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty.');
        }

        $conn = $this->connect();

        $query = sprintf(
            "INSERT INTO todo (title) VALUES('%s');",
            mysql_real_escape_string($title, $conn)
        );

        if (!mysql_query($query, $conn)) {
            throw new DatabaseException(sprintf(
                'Unable to create new "%s" task: %s',
                $title,
                mysql_error($conn)
            ));
        }

        return mysql_insert_id($conn);
    }
    
    public function find($pk)
    {
        $conn = $this->connect();

        $result = mysql_query('SELECT * FROM todo WHERE id = '. (int) $pk, $conn);

        return mysql_fetch_assoc($result);
    }

    public function findAllTasks()
    {
        $conn = $this->connect();

        $result = mysql_query('SELECT * FROM todo', $conn);
        $tasks = array();
        while ($todo = mysql_fetch_assoc($result)) {
            $tasks[] = $todo;
        }

        return $tasks;
    }
    
    public function countAllTasks()
    {
        $conn = $this->connect();

        $result = mysql_query('SELECT COUNT(*) FROM todo', $conn);

        return (int) current(mysql_fetch_row($result));
    }
    
    public function __destruct()
    {
        if (null !== $this->conn) {
            mysql_close($this->conn);
        }
    }
    
    private function connect()
    {
        if (null !== $this->conn) {
            return $this->conn;
        }

        $server = $this->hostname.':'.$this->port;
        if (!$this->conn = mysql_connect($server, $this->username, $this->password)) {
            throw new DatabaseException(sprintf(
                'Unable to connect to MySQL: %s %s',
                mysql_errno(),
                mysql_error()
            ));
        }

        if (!mysql_select_db($this->database, $this->conn)) {
            throw new DatabaseException(sprintf(
                'Unable to select database "%s".',
                $this->database
            ));
        }

        return $this->conn;
    }
} 
