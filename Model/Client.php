<?php

namespace Model;

class Client extends Model
{
    public $dbConn;

	public $name;
	public $client_id;
    public $user_id;

	protected static $tableName = 'client';


	public function __construct()
    {
        parent::__construct();
    }


    public function save(): bool
    {
        $sql = "INSERT INTO client SET name = ?, user_id = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->user_id);

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

    public function addRole(): bool
    {
        $sql = "INSERT INTO user_role (user_id, role_id) VALUES (:user_id, 3)";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }

    public function addPermissions(): bool
    {
        $sql = "INSERT INTO role_permission (role_id, permission_id) VALUES (3, 12)";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }
}

