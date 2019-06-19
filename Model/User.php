<?php

namespace Model;

use Db\Db;


class User extends Model
{

	public $name;
	public $job;
    public $password;
    public $email;
    public $user_id;

    protected static $table_name = 'user';


    public function save()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "INSERT INTO user SET name = ?, password = ?, email = ?, job = ?";

        $prep_state = $db_conn->prepare($sql);

        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $hash);
        $prep_state->bindParam(3, $this->email);
        $prep_state->bindParam(4, $this->job);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function update()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "UPDATE user SET name = :name, password = :password, email = :email, job = :job
         WHERE user_id = :id";
       
        $prep_state = $db_conn->prepare($sql);

        $prep_state->bindParam(':name', $this->name);
        $prep_state->bindParam(':password', $this->password);
        $prep_state->bindParam(':email', $this->email);
        $prep_state->bindParam(':job', $this->job);
        $prep_state->bindParam(':id', $this->user_id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function get_all_tasks()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM task where user_id= :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $this->user_id);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, '\Model\Task');

        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }
}

