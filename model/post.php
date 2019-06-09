<?php

class Post 
{

	public $db_conn;
	public $table_name = "post";

	public $title;
    public $body;
    public $date;
    public $task_id;
    public $user_id;
 

	function __construct($db) 
    {
		$this->db_conn = $db;
	}
 

    public function create_post()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET title = ?, body = ?, date = ? , task_id = ?, user_id = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->title);
        $prep_state->bindParam(2, $this->body);
        $prep_state->bindParam(3, $this->date);
        $prep_state->bindParam(4, $this->task_id);
        $prep_state->bindParam(5, $this->user_id);

        $prep_state->execute();
    }


    public function get_all_posts($task_id)
    {
        $sql = "SELECT * FROM post where task_id = $task_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_task($post_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE post_id = $post_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $post = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->title = $post['title'];
        $this->body = $post['body'];
        $this->date = $post['date'];
    }   

}

