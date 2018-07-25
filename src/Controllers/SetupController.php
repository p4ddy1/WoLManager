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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['password_repeat'];
        $dbPath = filter_var($_POST['db_path'], FILTER_SANITIZE_STRING);

        if(!preg_match('/^[A-z0-9_]{3,20}$/', $username)){
            $this->setError('Invalid username!');
            $this->redirect();
        }
        if(!$dbPath){
            $this->setError('Invalid database path!');
            $this->redirect();
        }
        if($password !== $passwordRepeat){
            $this->setError('Passwords do not match!');
            $this->redirect();
        }
        if(!$this->createConfig($dbPath)){
            $this->setError('Could not create config file. Check permissions!');
            $this->redirect();
        }

        $this->databaseCreateTables();
        $this->databaseCreateAdminUser($username, $password);

        $this->setSuccess('Setup completed successfully');
        header('Location: /');
    }

    private function redirect(){
        header('Location: /');
        exit;
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
     * @return bool
     */
    private function createConfig($dbPath){
        $config = Config::getInstance();
        $config->set('db.path', $dbPath);
        return $config->save();
    }
}