<?php

namespace Model;
use Db\Db;

class Post extends Model
{

	public $title;
    public $body;
    public $date;
    public $task_id;
    public $users_id;
    public $post_id;

    protected static $tableName = 'post';


    public function save()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO post SET title = ?, body = ?, date = ? , task_id = ?, users_id = ?";

        $prep_state = $conn->prepare($sql);

        $prep_state->bindParam(1, $this->title);
        $prep_state->bindParam(2, $this->body);
        $prep_state->bindParam(3, $this->date);
        $prep_state->bindParam(4, $this->task_id);
        $prep_state->bindParam(5, $this->users_id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

