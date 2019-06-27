<?php

namespace Model;

class Task extends Model
{
    public $dbConn;

	public $name;
    public $project_id;
    public $user_id;
    public $task_id;

    protected static $tableName = 'task';


    public function __construct()
    {
        parent::__construct();
    }


    public function save(): bool
    {
        $sql = "INSERT INTO task SET name = ?, project_id = ?, user_id = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->project_id);
        $stmt->bindParam(3, $this->user_id);

        return $stmt->execute();
    }


    public function getPosts(): array
    {
        $sql = "SELECT * FROM post where task_id = :task_id ORDER BY date DESC ";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':task_id', $this->task_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Post');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }

    public function getUser()
    {
        $sql = "SELECT * FROM user WHERE user_id = :id";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $this->user_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Model\User');

        $stmt->execute();

        return ($obj = $stmt->fetch()) ? $obj : false;
    }
}

