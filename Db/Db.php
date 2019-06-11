<?php

namespace Db;


class Db
{

	private $db_host = 'localhost:3308';
	private $db_username = 'root';
	private $db_password = '';
	private $db_name = 'phpoop2';

	public function get_connected()
	{
		try {
			$conn = new \PDO('mysql:host=' . $this->db_host .';dbname='.
			$this->db_name, $this->db_username, $this->db_password);

		} catch (PDOException $e) {
			echo 'Database connection error' .$e;
		}
		return $conn;
	}
}