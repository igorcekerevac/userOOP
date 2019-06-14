<?php


namespace Model;

use Db\Db;


abstract class Model
{

    protected static $table_name = '';

    public static function delete($id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "DELETE FROM " . static::$table_name . " WHERE " . static::$table_name . "_id = :id ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

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

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get($id)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " .static::$table_name. " WHERE " . static::$table_name ."_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $found = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $found;
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

        return $prep_state;
    }


    public static function get_all_with_specific_id($id, $id_name)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . static::$table_name . " where " . $id_name . "_id= :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
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


    public static function check_column_value_exist($column)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . $column . " FROM " . static::$table_name . " WHERE " . $column . " = " . $column;

        $prep_state = $db_conn->prepare($sql);

        $prep_state->execute();

        if ($prep_state->fetch(\PDO::FETCH_ASSOC)) {
            return true;
        }
    }
}