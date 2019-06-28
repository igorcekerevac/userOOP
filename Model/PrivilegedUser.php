<?php


namespace Model;


class PrivilegedUser extends User
{
    public $roles;

    public function __construct()
    {
        parent::__construct();
    }

    public function getRoles()
    {
        $sql = "SELECT  roles.role, roles.id
                FROM user
                RIGHT JOIN
                user_role ON user.user_id=user_role.user_id
                RIGHT JOIN
                roles ON user_role.role_id = roles.id
                where user.user_id = :id";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':id', $this->user_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Model\Role');

        $stmt->execute();

      #  return $this->roles = $stmt->fetchAll();
        while ($row = $stmt->fetch()) {
            $row->permissions = $row->getPermissions();
            $this->roles = $row;
        }
        return $this->roles;
    }


    public function getByEmail(string $email)
    {
        $sql = "SELECT * FROM user WHERE email = :email";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);

        $stmt->execute();

        $obj = $stmt->fetch();

        if (!empty($obj)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $obj->user_id;
            $privUser->job = $obj->job;
            $privUser->password = $obj->password;
            $privUser->name = $obj->name;
            $privUser->email = $email;
            $privUser->roles = $privUser->getRoles();
            return $privUser;
        } else {
            return false;
        }

    }
}