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


    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO post SET title = ?, body = ?, date = ? , task_id = ?, users_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->body);
        $stmt->bindParam(3, $this->date);
        $stmt->bindParam(4, $this->task_id);
        $stmt->bindParam(5, $this->users_id);

        return $stmt->execute();
    }
}

