<?php


namespace Model;

use Db\Db;

abstract class Model
{

    protected static $table_name = '';


    public function delete()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $id = static::$table_name.'_id';

        $sql = "DELETE FROM " . static::$table_name . " WHERE " . static::$table_name . "_id = :id ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $this->$id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function get_all()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }


    public static function get_by_id($id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " .static::$table_name. " WHERE " . static::$table_name ."_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        $prep_state->execute();

        if ($obj = $prep_state->fetch()) {
            return $obj;
        } else {
            return false;
        }
    }


    //num of rows, pagination
    public static function count_all()
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . static::$table_name ."_id FROM " . static::$table_name;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount();
        return $num;
    }


    public static function get_all_pagination($from_record_num, $records_per_page)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name . " LIMIT " . $from_record_num . ',' .$records_per_page;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }


    public static function where($column, $value)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name . " WHERE " . $column . " = :value";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':value', $value);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        $prep_state->execute();

        if ($obj = $prep_state->fetch()) {
            return $obj;
        } else {
            return false;
        }
    }
}