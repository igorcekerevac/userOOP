<?php

namespace Model;
use Db\Db;

class Task extends Model
{

	public $name;
    public $project_id;
    public $user_id;
    public $task_id;

    protected static $table_name = 'task';
 

    public function save()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "INSERT INTO task SET name = ?, project_id = ?, user_id = ?";

        $prep_state = $db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);
        $prep_state->bindParam(2, $this->project_id);
        $prep_state->bindParam(3, $this->user_id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function get_all_posts()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM post where task_id = :task_id ORDER BY date DESC ";

        $prep_state = $db_conn->prepare($sql);

        $prep_state->bindParam(':task_id', $this->task_id);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, '\Model\Post');

        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }
}

