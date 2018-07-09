<?php
namespace App\Classes;

class Database{
    private static $instance = null;
    private $pdo;

    public function __construct()
    {
        if(is_null($this->pdo)){
            $this->pdo = new \PDO("sqlite:".__DIR__.'/../../db/wol_manager.sqlite');
        }
    }

    public function querySingle($sql, array $params = null){
        $statement = $this->query($sql,$params);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function queryMultiple($sql, array $params = null){
        $data = array();
        $statement = $this->query($sql,$params);
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($data, $row);
        }
        return $data;
    }

    private function query($sql, array $params = null){
        $statement = $this->prepareStatement($sql,$params);
        $statement->execute();
        return $statement;
    }

    public function exec($sql, array $params = null){
        $statement = $this->prepareStatement($sql, $params);
        $statement->execute();
    }

    public function beginTransaction(){
        $this->pdo->beginTransaction();
    }

    public function commitTransaction(){
        $this->pdo->commit();
    }

    public function rollbackTransaction(){
        $this->pdo->rollBack();
    }

    private function prepareStatement($sql, array $params = null){
        $statement = $this->pdo->prepare($sql);
        if(!is_null($params)){
            foreach($params as $key => $value){
                $statement->bindValue($key, $value);
            }
        }
        return $statement;
    }

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}