<?php


namespace Model;

use Db\Db;

abstract class Model
{

    protected static $tableName = '';


    public function delete(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $id = static::$tableName.'_id';

        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$tableName . "_id = :id ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $this->$id);

        return $stmt->execute();
    }


    public static function getAll(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName;

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }


    public static function getById(int $id)
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " .static::$tableName. " WHERE " . static::$tableName ."_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return ($obj = $stmt->fetch()) ? $obj : false;
    }


    //num of rows, pagination
    public static function countAll(): int
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT " . static::$tableName ."_id FROM " . static::$tableName;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $num = $stmt->rowCount();
    }


    public static function getAllPagination(int $fromRecordNum, int $recordsPerPage): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName . " LIMIT " . $fromRecordNum . ',' .$recordsPerPage;

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();

    }


    public static function where(string $column, $value)
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . $column . " = :value";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return ($obj = $stmt->fetch()) ? $obj : false;

    }
}