<?php

namespace Database;

class Connection implements ConnectionInterface
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

    public function query($sql)
    {
        $result = $this->executeQuery($sql);
        
        if (!is_resource($result)) {
            throw new DatabaseException(sprintf('Resource data type expected, %s given.', gettype($result)));
        }

        return new LazyResultSet($result);
    }

    public function exec($sql)
    {
        $this->executeQuery($sql);

        return mysql_affected_rows($this->conn);
    }

    private function executeQuery($sql)
    {
        $conn = $this->connect();

        if (!$result = mysql_query($sql, $conn)) {
            throw new DatabaseException(sprintf('Unable to exec query: %s - %s', $sql, mysql_error()));
        }

        return $result;
    }
    
    public function getLastInsertId()
    {
        return mysql_insert_id($this->conn);
    }

    public function fetchOne($sql)
    {
        return $this->query($sql)->getFirst();
    }

    public function fetchAll($sql)
    {
        return $this->query($sql);
    }

    public function quote($param)
    {
        $conn = $this->connect();

        return mysql_real_escape_string($param, $conn);
    }
}
