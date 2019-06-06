<?php

class Task {

	public $db_conn;
	public $table_name = "task";

	public $name;
    public $project_id;
    public $user_id;
 

	function __construct($db) {
		$this->db_conn = $db;
	}
 

    function create_task()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?, project_id = ?, user_id = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->project_id);
        $prep_state->bindParam(3, $this->user_id);

        $prep_state->execute();
    }

    function get_all_tasks($project_id)
    {
        $sql = "SELECT * FROM task where project_id = $project_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_task($task_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE task_id = $task_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $task = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $task['name'];
        $this->project_id = $task['project_id'];
    }   

    function get_user_tasks($user_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id = $user_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);

    }     

}

?>