<?php

namespace Model;
use Db\Db;

class Post 
{

	public $db_conn;
	public $table_name = "post";

	public $title;
    public $body;
    public $date;
    public $task_id;
    public $users_id;
 

	function __construct()
    {
        $db = Db::get_connected();
        $this->db_conn = $db;
	}
 

    public function create_post()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET title = ?, body = ?, date = ? , task_id = ?, users_id = ?";

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
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM post where task_id = $task_id ORDER BY date DESC ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


}

