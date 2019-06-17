<?php

namespace Model;
use Db\Db;

class Task extends Model
{

	public $db_conn;

	public $name;
    public $project_id;
    public $user_id;
    public $task_id;
    protected static $table_name = 'task';
    protected static $class_name = __CLASS__;


    function __construct() {

        $instance = Db::get_instance();
        $this->db_conn = $instance->get_connection();
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


    public static function get_client_id($id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

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


}

