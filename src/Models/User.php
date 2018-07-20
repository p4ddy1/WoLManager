<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Classes\Database;

class User extends BaseModel{
    function __construct()
    {
        parent::__construct();
    }

    public static function loadByUsername($username){
        $db = Database::getInstance();
        $user = new User();
        if($row = $db->querySingle('SELECT * FROM users WHERE name=:name LIMIT 1;', [':name' => $username])){
            $user->setProperty('id', $row['id']);
            $user->setProperty('name', $username);
            $user->setProperty('password', $row['password']);
            $user->setProperty('active', $row['active']);
            return $user;
        }
        return false;
    }

    public function setUsername($username){
        $this->setProperty('name', $username);
    }

    public function setPassword($password){
        $this->setProperty('password', password_hash($password, PASSWORD_DEFAULT));
    }

    public function setActive($active){
        if($active){
            $this->setProperty('active', '1');
        }else{
            $this->setProperty('active', '0');
        }
    }

    public function getID(){
        return $this->getProperty('id');
    }

    public function getUsername(){
        return $this->getProperty('name');
    }

    public function getPasswordHash(){
        return $this->getProperty('password');
    }

    public function isActive(){
        if($this->getProperty('active') === 1){
            return true;
        }else{
            return false;
        }
    }
}