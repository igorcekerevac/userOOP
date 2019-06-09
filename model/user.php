<?php

class User 
{

	public $db_conn;
	public $table_name = "user";

	public $name;
	public $age;
	public $email;
    public $user_id;
 

	function __construct($db) {
		$this->db_conn = $db;
	}
 

    public function create()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?, age = ?, email = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->age);
        $prep_state->bindParam(3, $this->email);

        $prep_state->execute();
    }


    public function update($id)
    {
        $sql = "UPDATE " . $this->table_name . " SET name = :name, age = :age, email = :email WHERE user_id = $id";
       
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':name', $this->name);
        $prep_state->bindParam(':age', $this->age);
        $prep_state->bindParam(':email', $this->email);
        $prep_state->execute();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE user_id = $id ";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
    }


    public function getUsers()
    {
        $sql = "SELECT * FROM user";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserMail()
    {
        $sql = "SELECT email FROM user";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUser($id)
    {
        $sql = "SELECT name, age, email FROM " . $this->table_name . " WHERE user_id = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $user = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $user['name'];
        $this->age = $user['age'];
        $this->email = $user['email'];
    }   

    //num of rows, pagination
    public function countAll()
    {
        $sql = "SELECT user_id FROM " . $this->table_name . "";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); 
        return $num;
    }


    public function getAllUsers($from_record_num, $records_per_page)
    {
        $sql = "SELECT * FROM " . $this->table_name . " LIMIT " . $from_record_num . ',' .$records_per_page;


        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }

}

