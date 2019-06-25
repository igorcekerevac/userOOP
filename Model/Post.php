<?php

namespace Model;

class Post extends Model
{
    public $dbConn;

	public $title;
    public $body;
    public $date;
    public $task_id;
    public $users_id;
    public $post_id;

    protected static $tableName = 'post';

    public function __construct()
    {
        parent::__construct();
    }


    public function save(): bool
    {
        $sql = "INSERT INTO post SET title = ?, body = ?, date = ? , task_id = ?, users_id = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->body);
        $stmt->bindParam(3, $this->date);
        $stmt->bindParam(4, $this->task_id);
        $stmt->bindParam(5, $this->users_id);

        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE post SET title = :title WHERE users_id = :id";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':id', $this->users_id);

        return $stmt->execute();
    }
}

