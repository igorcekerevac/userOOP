<?php

namespace Model;
use Db\Db;

class Post 
{

	public $db_conn;

	public $title;
    public $body;
    public $date;
    public $task_id;
    public $users_id;
    protected static $table_name = 'post';
    protected static $class_name = __CLASS__;

    function __construct()
    {
        $instance = Db::get_instance();
        $this->db_conn = $instance->get_connection();
	}
 

    public function create_post()
    {
        $sql = "INSERT INTO post SET title = ?, body = ?, date = ? , task_id = ?, users_id = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->title);
        $prep_state->bindParam(2, $this->body);
        $prep_state->bindParam(3, $this->date);
        $prep_state->bindParam(4, $this->task_id);
        $prep_state->bindParam(5, $this->users_id);

        $prep_state->execute();
    }


    public static function get_all_posts($task_id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM post where task_id = :task_id ORDER BY date DESC ";

        $prep_state = $db_conn->prepare($sql);

        $prep_state->bindParam(':task_id', $task_id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


}

