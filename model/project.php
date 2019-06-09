<?php

class Project 
{

	public $db_conn;
	public $table_name = "project";

	public $name;
 

	function __construct($db) {
		$this->db_conn = $db;
	}
 

    public function create($client_id)
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?, client_id = $client_id";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        $prep_state->execute();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE project_id = $id ";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
    }


    public function get_all_projects()
    {
        $sql = "SELECT * FROM project";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_all_projects_join()
    {
        $sql = "SELECT client.name AS client_name,project.project_id, project.name AS project_name,task.name AS task_name ,user.name AS user_name, task.task_id FROM
            client
                 RIGHT JOIN
            project ON client.client_id=project.client_id
                 RIGHT JOIN
            task ON project.project_id = task.project_id
                LEFT JOIN
            user ON task.user_id = user.user_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_project($id)
    {
        $sql = "SELECT name FROM " . $this->table_name . " WHERE project_id = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $project = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $project['name'];
    }    


    public function get_project_client($client_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE client_id = $client_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $project = $prep_state->fetchAll(PDO::FETCH_ASSOC);

        return $project;
    }   


    public function get_project_name()
    {
        $sql = "SELECT name FROM project";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }
   
}

