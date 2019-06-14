<?php

namespace Model;

use Db\Db;


class User extends Model
{

	public $db_conn;

	public $name;
	public $job;
    public $password;
    public $email;
    public $user_id;
    protected static $table_name = 'user';
 

	function __construct() {

	    $instance = Db::get_instance();
	    $this->db_conn = $instance->get_connection();
	}


    public function create()
    {
        $sql = "INSERT INTO user SET name = ?, password = ?, email = ?, job = ?";

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
        $sql = "UPDATE user SET name = :name, password = :password, email = :email, job = :job
         WHERE user_id = :id";
       
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':name', $this->name);
        $prep_state->bindParam(':password', $this->password);
        $prep_state->bindParam(':email', $this->email);
        $prep_state->bindParam(':job', $this->job);
        $prep_state->bindParam(':id', $id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

}

