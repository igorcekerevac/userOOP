<?php

namespace Model;
use Db\Db;

class Task extends Model
{

	public $name;
    public $project_id;
    public $user_id;
    public $task_id;

    protected static $tableName = 'task';
 

    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO task SET name = ?, project_id = ?, user_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->project_id);
        $stmt->bindParam(3, $this->user_id);

        return $stmt->execute();
    }


    public function getPosts(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM post where task_id = :task_id ORDER BY date DESC ";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':task_id', $this->task_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Post');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }
}

