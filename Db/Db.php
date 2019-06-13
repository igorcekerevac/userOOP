<?php

namespace Db;


class Db
{

    private static $instance = null;
    private $conn;

    private $db_host = 'localhost:3308';
    private $db_username = 'root';
    private $db_password = '';
    private $db_name = 'phpoop2';


    private function __construct()
    {
        try {
            $this->conn = new \PDO('mysql:host=' . $this->db_host .';dbname='.
                $this->db_name, $this->db_username, $this->db_password);

        } catch (PDOException $e) {
            echo 'Database connection error' .$e;
        }
    }

    public static function get_instance()
    {
        if(!self::$instance)
        {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function get_connection()
    {
        return $this->conn;
    }

}


