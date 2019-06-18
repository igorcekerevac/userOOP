<?php


namespace Model;

use Db\Db;

abstract class Model
{

    protected static $table_name = '';
    protected static $class_name;


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
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function get($id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " .static::$table_name. " WHERE " . static::$table_name ."_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, static::$class_name);

        $prep_state->execute();

        $obj = $prep_state->fetch();

        return $obj;
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
        $prep_state->execute();

        $users = $prep_state->fetchAll(\PDO::FETCH_OBJ);

        return $users;
    }


    public static function get_all_with_specific_id($id, $id_name)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name . " where " . $id_name . "_id= :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function get_column_value($id, $column)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . $column . " FROM " . static::$table_name . " WHERE " . static::$table_name . "_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $result = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $result[$column];
    }


    public static function check_row_exists_where_column_value($column, $value)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name . " WHERE " . $column . " = :value";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':value', $value);

        $prep_state->execute();

        if ($obj = $prep_state->fetch(\PDO::FETCH_OBJ)) {
            return $obj;
        } else {
            return false;
        }
    }
}