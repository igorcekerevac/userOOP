<?php

namespace Model;
use Db\Db;


class Client 
{

	public $db_conn;
	public $table_name = "client";

	public $name;


	function __construct()
    {
        $db = Db::get_connected();
        $this->db_conn = $db;
	}


    public function create()
    {

        $sql = "INSERT INTO " . $this->table_name . " SET name = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        $prep_state->execute();
    }


    public function update($id)
    {
        $sql = "UPDATE " . $this->table_name . " SET name = :name WHERE client_id = $id";
       
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':name', $this->name);
        $prep_state->execute();
    }


    public static function get_all_clients()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM client";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }

    
    public static function get_client($id)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT name FROM client WHERE client_id = $id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $client = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $client['name'];
    }    

    //num of rows, pagination
    public static function count_all()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT client_id FROM client";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); 
        return $num;
    }


    public static function get_all_clients_pagination($from_record_num, $records_per_page)
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT * FROM client LIMIT " . $from_record_num . ',' .$records_per_page;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }


    public static function get_client_name()
    {
        $db_conn = Db::get_connected();

        $sql = "SELECT name FROM client";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

