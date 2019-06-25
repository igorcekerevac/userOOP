<?php

namespace Model;

class User extends Model
{
    public $dbConn;

	public $name;
	public $job;
    public $password;
    public $email;
    public $user_id;

    protected static $tableName = 'user';

    public function __construct()
    {
        parent::__construct();
    }

    public function save(): bool
    {
        $sql = "INSERT INTO user SET name = ?, password = ?, email = ?, job = ?";

        $stmt = $this->dbConn->prepare($sql);

        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $hash);
        $stmt->bindParam(3, $this->email);
        $stmt->bindParam(4, $this->job);

        return $stmt->execute();
    }


    public function update(): bool
    {
        $sql = "UPDATE user SET name = :name, password = :password, email = :email, job = :job
         WHERE user_id = :id";
       
        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':job', $this->job);
        $stmt->bindParam(':id', $this->user_id);

        return $stmt->execute();
    }


    public function getTasks(): array
    {
        $sql = "SELECT * FROM task where user_id= :id";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $this->user_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Task');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }


    public function getPosts(): array
    {
        $sql = "SELECT * FROM post where users_id= :id";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $this->user_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Post');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }
}

