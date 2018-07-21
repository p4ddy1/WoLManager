<?php
namespace App\Classes;

class Database{
    private static $instance = null;
    private $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        if(is_null($this->pdo)){
            $this->pdo = new \PDO("sqlite:".__DIR__.'/../../db/wol_manager.sqlite');
        }
    }

    /**
     * Queries database for a single row
     * @param $sql
     * @param array|null $params
     * @return mixed
     */
    public function querySingle($sql, array $params = null){
        $statement = $this->query($sql,$params);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Queries database for multiple rows
     * @param $sql
     * @param array|null $params
     * @return array
     */
    public function queryMultiple($sql, array $params = null){
        $data = array();
        $statement = $this->query($sql,$params);
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($data, $row);
        }
        return $data;
    }

    /**
     * Executes a query on the database
     * @param $sql
     * @param array|null $params
     * @return bool|\PDOStatement
     */
    private function query($sql, array $params = null){
        $statement = $this->prepareStatement($sql,$params);
        $statement->execute();
        return $statement;
    }

    /**
     * Executes a command on the database with no result expected
     * @param $sql
     * @param array|null $params
     */
    public function exec($sql, array $params = null){
        $statement = $this->prepareStatement($sql, $params);
        $statement->execute();
    }

    /**
     * Start a transaction
     */
    public function beginTransaction(){
        $this->pdo->beginTransaction();
    }

    /**
     * Commit the transaction
     */
    public function commitTransaction(){
        $this->pdo->commit();
    }

    /**
     * Rollback the transaction
     */
    public function rollbackTransaction(){
        $this->pdo->rollBack();
    }

    /**
     * Prepares a statement with the given SQL and parameters
     * @param $sql
     * @param array|null $params
     * @return bool|\PDOStatement
     */
    private function prepareStatement($sql, array $params = null){
        $statement = $this->pdo->prepare($sql);
        if(!is_null($params)){
            foreach($params as $key => $value){
                    $statement->bindValue($key, $value);
            }
        }
        return $statement;
    }

    /**
     * Returns the instance. (Singleton)
     * @return Database|null
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}