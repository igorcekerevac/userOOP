<?php

namespace Model;

use Db\Db;

class Project extends Model
{

	public $name;
	public $client_id;
	public $project_id;

    protected static $tableName = 'project';


    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO project SET name = ?, client_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->client_id);

        return $stmt->execute();
    }


    public static function getAllJoined(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT client.name AS client_name,project.project_id, project.name AS project_name,
            task.name AS task_name ,user.name AS user_name, task.task_id 
            FROM
            client
                 RIGHT JOIN
            project ON client.client_id=project.client_id
                 LEFT JOIN
            task ON project.project_id = task.project_id
                LEFT JOIN
            user ON task.user_id = user.user_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getTasks(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM task where project_id= :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $this->project_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Task');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }
}

