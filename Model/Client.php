<?php

namespace Model;
use Db\Db;


class Client extends Model
{

	public $name;
	public $client_id;

	protected static $tableName = 'client';


    public function save()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO client SET name = ?";

        $prep_state = $conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getProjects()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM project where client_id= :id";

        $prep_state = $conn->prepare($sql);
        $prep_state->bindParam(':id', $this->client_id);

        $prep_state->setFetchMode(\PDO::FETCH_CLASS, '\Model\Project');

        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }
}

