<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\Config;
use App\Classes\Database;
use App\Models\User;

class SetupController extends BaseController{

    /**
     * Displays the setup page
     * @throws \Exception
     */
    public function index(){
        $defaultDbPath = Config::getInstance()->get('database.path');
        $this->render("setup.html.twig", ['defaultDbPath' => $defaultDbPath]);
    }

    /**
     * Called by POST Request. Retrieves the user input, creates the database tables, adds the first user and
     * writes settings to the config file
     */
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
        $this->createConfig($dbPath);

    }

    /**
     * Creates tables
     */
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

    /**
     * Adds first user to database
     * @param $username
     * @param $password
     */
    private function databaseCreateAdminUser($username, $password){
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->create();
    }

    /**
     * Creates config file
     * @param $dbPath
     * @throws \Exception
     */
    private function createConfig($dbPath){
        $config = Config::getInstance();
        $config->set('db.path', $dbPath);
        $config->save();
    }
}