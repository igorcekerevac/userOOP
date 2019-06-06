<?php

class Client {

	public $db_conn;
	public $table_name = "client";

	public $name;
 

	function __construct($db) {
		$this->db_conn = $db;
	}
 

    function create()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        $prep_state->execute();
    }


    function update($id)
    {
        $sql = "UPDATE " . $this->table_name . " SET name = :name WHERE client_id = $id";
       
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':name', $this->name);
        $prep_state->execute();
    }


    function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE user_id = $id ";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
    }


    function get_all_clients()
    {
        $sql = "SELECT * FROM client";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function get_client($id)
    {
        $sql = "SELECT name FROM " . $this->table_name . " WHERE client_id = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $client = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $client['name'];

    }    

    //num of rows, pagination
    public function countAll()
    {
        $sql = "SELECT client_id FROM " . $this->table_name . "";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); 
        return $num;
    }

    function getAllClients($from_record_num, $records_per_page)
    {
        $sql = "SELECT * FROM " . $this->table_name . " LIMIT " . $from_record_num . ',' .$records_per_page;


        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }


    function get_client_name()
    {
        $sql = "SELECT name FROM client";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>