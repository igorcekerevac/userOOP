<?php

namespace Model;
use Db\Db;


class Client extends Model
{

	public $name;
	public $client_id;

	protected static $table_name = 'client';


    public function save()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "INSERT INTO client SET name = ?";

        $prep_state = $db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function get_client_id($project_id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT client.client_id from
            client
                 RIGHT JOIN
            project ON client.client_id=project.client_id
            where project_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $project_id);

        $prep_state->execute();

        $client= $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $client['client_id'];
    }

    public function get_all_projects()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM project where client_id= :id";

        $prep_state = $db_conn->prepare($sql);
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

