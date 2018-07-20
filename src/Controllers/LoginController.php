<?php

namespace App\Controllers;

use App\Base\BaseController;

class LoginController extends BaseController{
    public function index(){
        $loggedIn = $this->auth->isLoggedIn();
        echo $this->render('login.html.twig');
    }

    public function login(){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        if($this->auth->login($username, $password)){
            $this->setSuccess('Successfully logged in!');
            header('Location: /');
        }else{
            $this->setError('Login failed');
            header('Location: /login');
        }
    }

    public function logout(){
        $this->auth->logout();
        header('Location: /');
    }
}