<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\Config;
use App\Classes\Database;
use App\Models\User;

class SetupController extends BaseController{
    public function index(){
        $defaultDbPath = Config::getInstance()->get('database.path');
        $this->render("setup.html.twig", ['defaultDbPath' => $defaultDbPath]);
    }

    public function setup(){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $passwordRepeat = $_POST['password_repeat'];
        $dbPath = filter_var($_POST['db_path'], FILTER_SANITIZE_STRING);

        if($username && $dbPath){
            if($password == $passwordRepeat){
                $this->databaseCreateTables();
                $this->databaseCreateAdminUser($username, $password);
                $this->setSuccess('Setup completed successfully');
                header('Location: /');
            }
        }

        $this->databaseCreateTables();
    }

    private function databaseCreateTables(){
        $db = Database::getInstance();
        $db->beginTransaction();
        //Create Tables
        $query = 'CREATE TABLE IF NOT EXISTS devices
                (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    ip TEXT,
                    subnet TEXT,
                    mac TEXT
                );';
        $db->exec($query);
        $query = 'CREATE TABLE IF NOT EXISTS users
                (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    password TEXT,
                    active INTEGER DEFAULT 1
                );';
        $db->exec($query);
        $db->commitTransaction();
    }

    private function databaseCreateAdminUser($username, $password){
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->create();
    }
}