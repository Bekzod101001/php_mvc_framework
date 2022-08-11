<?php

namespace app\core;

class DbModel extends Model
{
    public static string $tableName;
    public array $attributes;

    public function create()
    {
        $attributesAsString = implode(',', $this->attributes);
        $paramsAsString = implode(',', array_map(fn($param) => ":$param", $this->attributes));
        $statement = Application::$app->database->prepare("INSERT INTO $this->tableName (" . $attributesAsString . ") VALUES(" . $paramsAsString . ")");

        foreach($this->attributes as $attribute){
            $statement->bindValue(":$attribute", $this->$attribute);
        }

        $statement->execute();
    }

    public static function find(array $where)
    {
        $attributes = array_keys($where);
        $attributesForSql = implode('AND ', array_map(fn($attr) => "$attr = :$attr", $attributes));
        $tableName = static::$tableName;
        $statement = Application::$app->database->prepare("SELECT * FROM $tableName WHERE $attributesForSql");

        foreach($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}