<?php


namespace Model;

use Db\Db;


abstract class Model
{

    public static function delete($id, $table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "DELETE FROM " . $table . " WHERE " . $table . "_id = :id ";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function get_all($table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . $table;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get($id, $table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " .$table. " WHERE " . $table ."_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $found = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $found;
    }


    //num of rows, pagination
    public static function count_all($table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . $table ."_id FROM " .$table;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount();
        return $num;
    }


    public static function get_all_pagination($from_record_num, $records_per_page, $table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . $table . " LIMIT " . $from_record_num . ',' .$records_per_page;

        $prep_state = $db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }


    public static function get_all_with_specific_id($table , $id, $id_name)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT * FROM " . $table . " where " . $id_name . "_id= :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        return $prep_state->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function get_column_value($id, $column, $table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . $column . " FROM " . $table . " WHERE " . $table . "_id = :id";

        $prep_state = $db_conn->prepare($sql);
        $prep_state->bindParam(':id', $id);

        $prep_state->execute();

        $result = $prep_state->fetch(\PDO::FETCH_ASSOC);

        return $result[$column];
    }


    public static function check_column_value_exist($column, $table)
    {
        $instance = Db::get_instance();
        $db_conn = $instance->get_connection();

        $sql = "SELECT " . $column . " FROM " . $table . " WHERE " . $column . " = " . $column;

        $prep_state = $db_conn->prepare($sql);

        $prep_state->execute();

        if ($prep_state->fetch(\PDO::FETCH_ASSOC)) {
            return true;
        }
    }
}