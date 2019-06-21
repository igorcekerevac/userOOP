<?php

namespace Model;
use Db\Db;


class Client extends Model
{

	public $name;
	public $client_id;

	protected static $tableName = 'client';


    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO client SET name = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->name);

        return $stmt->execute();
    }


    public function getProjects(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM project where client_id= :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $this->client_id);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Project');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }
}

