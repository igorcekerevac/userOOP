<?php

namespace Model;

use Db\Db;

class Project extends Model
{

	public $name;
	public $client_id;
	public $project_id;

    protected static $tableName = 'project';


    public function save()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO project SET name = ?, client_id = ?";

        $prep_state = $conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->client_id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function getAllJoined()
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

        $prep_state = $conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getTasks()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM task where project_id= :id";

        $prep_state = $conn->prepare($sql);
        $prep_state->bindParam(':id', $this->project_id);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, '\Model\Task');

        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }
}

