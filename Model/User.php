<?php

namespace Model;
use Db\Db;


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

        $db = Db::get_connected();
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


    public static function delete($id)
    {
        $db_conn = Db::get_connected();

        $sql = "DELETE FROM user WHERE user_id = $id ";

        $prep_state = $db_conn->prepare($sql);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function get_all_users()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM user";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get_user_mail()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT email FROM user";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function get_user($id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT name, password, email, job FROM user WHERE user_id = $id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $user = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }   

    //num of rows, pagination
    public static function count_all_users()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT user_id FROM user";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); 
        return $num;
    }


    public static function get_all_users_pagination($from_record_num, $records_per_page)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM user LIMIT " . $from_record_num . ',' .$records_per_page;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }

}

