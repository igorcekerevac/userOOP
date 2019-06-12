<?php

namespace Db;


class Db
{


	public static function get_connected()
	{

        $db_host = 'localhost:3308';
        $db_username = 'root';
        $db_password = '';
        $db_name = 'phpoop2';

		try {
			$conn = new \PDO('mysql:host=' . $db_host .';dbname='.
			$db_name, $db_username, $db_password);

		} catch (PDOException $e) {
			echo 'Database connection error' .$e;
		}
		return $conn;
	}
}