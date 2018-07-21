<?php

namespace App\Classes;

use App\Models\User;

class Auth{
    private static $instance = null;

    /**
     * Login the user with the given username and password. Checks if the username exists and if the password is correct
     * @param $username
     * @param $password
     * @return bool
     */
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

    /**
     * Returns true if the user is currently logged in
     * @return bool
     */
    public function isLoggedIn(){
        if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['currentUserId'])&& !isset($_SESSION['currentUsername'])){
            return false;
        }
        if($_SESSION['loggedIn'] === true){
            return true;
        }
        return false;
    }

    /**
     * Logs the current user out
     */
    public function logout(){
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['currentUserId']);
        unset($_SESSION['currentUsername']);
    }

    /**
     * Returns the username of the current user
     * @return bool
     */
    public function getUsername(){
        if(isset($_SESSION['currentUsername'])){
            return $_SESSION['currentUsername'];
        }
        return false;
    }

    /**
     * Get instance. (Singleton)
     * @return Auth|null
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}