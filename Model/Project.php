<?php

namespace Model;
use Db\Db;

class Project 
{

	public $db_conn;

	public $name;
 

	function __construct()
    {
        $db = Db::get_connected();
        $this->db_conn = $db;
	}
 

    public function create($client_id)
    {
        $sql = "INSERT INTO project SET name = ?, client_id = :client_id";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(':client_id', $client_id);

        $prep_state->execute();
    }


    public static function delete($id)
    {
        $db_conn = Db::get_connected();

        $sql = "DELETE FROM project WHERE project_id = :id ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();
    }


    public static function get_all_projects()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM project";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get_all_projects_join()
    {
        $db_conn = Db::get_connected();

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

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get_project($id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT name FROM project WHERE project_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $project = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $project['name'];
    }    


    public static function get_project_client($client_id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM project WHERE client_id = :client_id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':client_id', $client_id);

        $prep_state->execute();

        $project = $prep_state->fetchAll(\PDO::FETCH_ASSOC);

        return $project;
    }   


    public static function get_projects_names()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT name FROM project";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }
   
}

