<?php

namespace Model;
use Db\Db;


class Client extends Model
{

	public $db_conn;

	public $name;
	protected static $table_name = 'client';
    protected static $class_name = __CLASS__;

	function __construct()
    {
        $instance = Db::get_instance();
        $this->db_conn = $instance->get_connection();
	}


    public function create()
    {

        $sql = "INSERT INTO client SET name = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->name);

        $prep_state->execute();
    }
    
}

