<?php

class Project {

	public $db_conn;
	public $table_name = "project";

	public $name;
 

	function __construct($db) {
		$this->db_conn = $db;
	}
 

    function create($client_id)
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?, client_id = $client_id";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        $prep_state->execute();
    }


    function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE project_id = $id ";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
    }


    function get_all_projects()
    {
        $sql = "SELECT * FROM project";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function get_project($id)
    {
        $sql = "SELECT name FROM " . $this->table_name . " WHERE project_id = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $project = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $project['name'];
    }    

    function get_project_client($client_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE client_id = $client_id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $project = $prep_state->fetchAll(PDO::FETCH_ASSOC);

        return $project;
    }   

    function get_project_name()
    {
        $sql = "SELECT name FROM project";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }

    
}

?>