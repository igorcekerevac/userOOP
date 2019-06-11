<?php

namespace Model;
use Db;


class User 
{

	public $db_conn;
	public $table_name = "user";

	public $name;
	public $job;
    public $password;
    public $email;
    public $user_id;
 

	function __construct() {

	    $conn = new db\Db();
	    $db = $conn->get_connected();
		$this->db_conn = $db;
	}
 

    public function create()
    {
        $sql = "INSERT INTO " . $this->table_name . " SET name = ?, password = ?, email = ?, job = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->password);
        $prep_state->bindParam(3, $this->email);
        $prep_state->bindParam(4, $this->job);

        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $prep_state->execute([$this->name, $hash, $this->email, $this->job]);
    }


    public function user_update($id)
    {
        $sql = "UPDATE " . $this->table_name . " SET name = :name, password = :password, email = :email, job = :job
         WHERE user_id = $id";
       
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':name', $this->name);
        $prep_state->bindParam(':password', $this->password);
        $prep_state->bindParam(':email', $this->email);
        $prep_state->bindParam(':job', $this->job);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }


    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE user_id = $id ";

        $prep_state = $this->db_conn->prepare($sql);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function get_all_users()
    {
        $sql = "SELECT * FROM user";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function get_user_mail()
    {
        $sql = "SELECT email FROM user";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function get_user($id)
    {
        $sql = "SELECT name, password, email, job FROM " . $this->table_name . " WHERE user_id = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $user = $prep_state->fetch(\PDO::FETCH_ASSOC);

        $this->name = $user['name'];
        $this->password = $user['password'];
        $this->email = $user['email'];
        $this->job = $user['job'];
    }   

    //num of rows, pagination
    public function count_all_users()
    {
        $sql = "SELECT user_id FROM " . $this->table_name . "";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); 
        return $num;
    }


    public function get_all_users_pagination($from_record_num, $records_per_page)
    {
        $sql = "SELECT * FROM " . $this->table_name . " LIMIT " . $from_record_num . ',' .$records_per_page;


        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }

}

