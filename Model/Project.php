<?php

namespace Model;

use Db\Db;

class Project extends Model
{

	public $db_conn;

	public $name;
	public $client_id;
    protected static $table_name = 'project';
    protected static $class_name = __CLASS__;

    function __construct()
    {
        $instance = Db::get_instance();
        $this->db_conn = $instance->get_connection();
	}
 

    public function create()
    {
        $sql = "INSERT INTO project SET name = ?, client_id = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->client_id);

        $prep_state->execute();
    }


    public static function get_all_projects_join()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

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
   
}

