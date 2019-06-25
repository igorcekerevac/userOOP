<?php

namespace Model;

class Client extends Model
{
    public $dbConn;

	public $name;
	public $client_id;

	protected static $tableName = 'client';


	public function __construct()
    {
        parent::__construct();
    }


    public function save(): bool
    {
        $sql = "INSERT INTO client SET name = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(1, $this->name);

        return $stmt->execute();
    }


    public function getProjects(): array
    {
        $sql = "SELECT * FROM project where client_id= :id";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $this->client_id);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Project');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }
}

