<?php


namespace Model;

use Db\Db;

class Role
{
    public $role;
    public $id;
    public $dbConn;

    public $permissions;

    public function __construct() {
        $instance = Db::getInstance();
        $this->dbConn = $instance->getConnection();
    }

    public function getPermissions()
    {
        $sql = "SELECT  permissions.description, permissions.id
                FROM roles
                RIGHT JOIN
                role_permission ON roles.id=role_permission.role_id
                RIGHT JOIN
                permissions ON role_permission.permission_id=permissions.id
                where roles.id = :id";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':id', $this->id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Model\Permissions');

        $stmt->execute();

        return $permissions = $stmt->fetchAll();
    }

    public function hasPermission($permission)
    {
        return isset($this->permissions[$permission]);
    }


}