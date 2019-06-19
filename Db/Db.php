<?php

namespace Db;


class Db
{

    private static $instance = null;
    private $conn;

    private $dbHost = 'localhost:3308';
    private $dbUsername = 'root';
    private $dbPassword = '';
    private $dbName = 'phpoop2';


    private function __construct()
    {
        try {$this->conn = new \PDO('mysql:host=' . $this->dbHost .';dbname='.
                $this->dbName, $this->dbUsername, $this->dbPassword);

        } catch (PDOException $e) {
            echo 'Database connection error' .$e;
        }
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

}


