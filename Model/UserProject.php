<?php


namespace Model;

use Db\Db;

class UserProject
{

    public $user_id;
    public $project_id;

    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO user_project SET project_id = ?, user_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->project_id);
        $stmt->bindParam(2, $this->user_id);

        return $stmt->execute();
    }

    public function delete(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "DELETE FROM user_project WHERE user_id = :user_id and project_id = :project_id ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':project_id', $this->project_id);

        return $stmt->execute();
    }
}