<?php

namespace App\Classes;

use App\Models\User;

class Auth{
    private static $instance = null;

    public function login($username, $password){
        if($user = User::loadByUsername($username)){
            if(password_verify($password, $user->getPasswordHash())){
                $_SESSION['loggedIn'] = true;
                $_SESSION['currentUserId'] = $user->getID();
                $_SESSION['currentUsername'] = $user->getUsername();
                return true;
            }
        }
        $_SESSION['loggedIn'] = false;
        return false;
    }

    public function isLoggedIn(){
        if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['currentUserId'])&& !isset($_SESSION['currentUsername'])){
            return false;
        }
        if($_SESSION['loggedIn'] === true){
            return true;
        }
        return false;
    }

    public function logout(){
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['currentUserId']);
        unset($_SESSION['currentUsername']);
    }

    public function getUsername(){
        if(isset($_SESSION['currentUsername'])){
            return $_SESSION['currentUsername'];
        }
        return false;
    }

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}