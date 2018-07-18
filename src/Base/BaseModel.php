<?php
namespace App\Base;

use App\Classes\Database;

abstract class BaseModel {
    protected $properties, $db, $tableName;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->tableName = self::generateTableName($this);
    }

    public function setProperty($key, $value){
        $this->properties[$key] = $value;
    }

    public function getProperty($key){
        return $this->properties[$key];
    }

    public function deleteProperty($key){
        unset($this->properties[$key]);
    }

    public function checkProperty($key){
        return array_key_exists($key,$this->properties);
    }

    public function delete(){
        if(!$this->checkProperty('id')) return false;

        $this->db->exec('DELETE FROM '.$this->tableName.' WHERE id=:id', [':id' => $this->getProperty('id')]);
        return true;
    }

    public function create(){
        if($this->checkProperty('id')) return false;

        $sql = 'INSERT INTO '. $this->tableName;
        $columns = '';
        $values = '';
        $parameters = array();
        foreach(array_keys($this->properties) as $count => $key){
            $columns .= $key;
            $values .= ':'. $key;
            $parameters[':'.$key] = $this->properties[$key];
            if($count<count($this->properties) - 1){
                $columns .= ',';
                $values .= ',';
            }
        }
        $sql .= ' ('.$columns.') VALUES ('.$values.')';
        $this->db->exec($sql, $parameters);
        return true;
    }

    public function update(){
        if(!$this->checkProperty('id')) return false;

        $sql = 'UPDATE '. $this->tableName. ' SET ';
        $parameters = ['id' => $this->getProperty('id')];
        foreach(array_keys($this->properties) as $count => $key){
            if($count < 1) continue;
            $sql .= $key.'=:'.$key;
            $parameters[':'.$key] = $this->properties[$key];
            if($count<count($this->properties)-1){
                $sql .= ',';
            }
        }
        $sql .= ' WHERE id=:id';
        $this->db->exec($sql, $parameters);
        return true;
    }

    public static function generateTableName($object){
        $reflection = new \ReflectionClass($object);
        $tableName = $reflection->getShortName();
        $tableName = strtolower($tableName);
        $tableName = $tableName.'s';
        return $tableName;
    }

    public static function loadById($id){
        $db = Database::getInstance();
        $model = new static();
        $tableName = self::generateTableName($model);
        $row = $db->querySingle('SELECT * FROM '.$tableName.' WHERE id = :id', [':id' => $id]);

        foreach ($row as $key => $value){
            $model->setProperty($key, $value);
        }
        return $model;
    }

    public static function loadAll(){
        $db = Database::getInstance();
        $model = new static();
        $tableName = self::generateTableName($model);
        $rows = $db->queryMultiple('SELECT * FROM '.$tableName);
        $models = array();
        foreach ($rows as $row){
            $currentModel = new static();
            foreach($row as $key => $value){
                $currentModel->setProperty($key, $value);
            }
            array_push($models,$currentModel);
        }
        return $models;
    }

    public static function where($attribute, $operator, $value)
    {
        $db = Database::getInstance();
        $model = new static();
        $tableName = self::generateTableName($model);
        $rows = $db->queryMultiple('SELECT * FROM ' . $tableName . ' WHERE ' . $attribute . ' ' . $operator . ' :val',
            ['val' => $value]);
        $models = array();
        foreach ($rows as $row) {
            $currentModel = new static();
            foreach ($row as $key => $value) {
                $currentModel->setProperty($key, $value);
            }
            array_push($models, $currentModel);
        }
        return $models;
    }
}