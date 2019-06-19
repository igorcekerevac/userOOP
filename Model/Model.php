<?php


namespace Model;

use Db\Db;

abstract class Model
{

    protected static $tableName = '';


    public function delete()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $id = static::$tableName.'_id';

        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$tableName . "_id = :id ";

        $prep_state = $conn->prepare($sql);
        $prep_state->bindParam(':id', $this->$id);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function getAll()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName;

        $prep_state = $conn->prepare($sql);
        $prep_state->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $prep_state->execute();

        if ($array = $prep_state->fetchAll()) {
            return $array;
        } else {
            return array();
        }
    }


    public static function getById($id)
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " .static::$tableName. " WHERE " . static::$tableName ."_id = :id";

        $prep_state = $conn->prepare($sql);
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
    public static function countAll()
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT " . static::$tableName ."_id FROM " . static::$tableName;

        $prep_state = $conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount();
        return $num;
    }


    public static function getAllPagination($from_record_num, $records_per_page)
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName . " LIMIT " . $from_record_num . ',' .$records_per_page;

        $prep_state = $conn->prepare($sql);
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
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . $column . " = :value";

        $prep_state = $conn->prepare($sql);
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