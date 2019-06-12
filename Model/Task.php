<?php

namespace Model;
use Db\Db;

class Task 
{

	public $db_conn;

	public $name;
    public $project_id;
    public $user_id;
 

	function __construct() {

        $db = Db::get_connected();
        $this->db_conn = $db;
	}
 

    public function create_task()
    {
        $sql = "INSERT INTO task SET name = ?, project_id = ?, user_id = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->project_id);
        $prep_state->bindParam(3, $this->user_id);

        $prep_state->execute();
    }


    public static function get_all_tasks($project_id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM task where project_id = :project_id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':project_id', $project_id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get_task($task_id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM task WHERE task_id = :task_id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':task_id', $task_id);

        $prep_state->execute();

        $task = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $task;
    }   


    public static function get_user_tasks($user_id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM task WHERE user_id = :user_id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':user_id', $user_id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function get_client_id($id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT client.client_id from
            client
                 RIGHT JOIN
            project ON client.client_id=project.client_id
            where project_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $client= $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $client;
    }


    public static function delete($id)
    {
        $db_conn = Db::get_connected();

        $sql = "DELETE FROM task WHERE task_id = :id ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }

}

