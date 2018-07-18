<?php
namespace App\Base;

abstract class BaseController
{
    protected $twigLoader, $twig;

    function __construct()
    {
        $this->twigLoader = new \Twig_Loader_Filesystem(__DIR__.'/../../templates');
        $this->twig = new \Twig_Environment($this->twigLoader);
    }

    protected function render($template, $vars = array()){
        if($error = $this->getError()){
            $vars['error'] = $error;
        }

        if($success = $this->getSuccess()){
            $vars['success'] = $success;
        }

        echo $this->twig->render($template, $vars);
    }

    private function getError(){
        if(isset($_SESSION['displayError'])){
            $error = $_SESSION['displayError'];
            unset($_SESSION['displayError']);
            return $error;
        }
        return false;
    }

    private function getSuccess(){
        if(isset($_SESSION['displaySuccess'])){
            $error = $_SESSION['displaySuccess'];
            unset($_SESSION['displaySuccess']);
            return $error;
        }
        return false;
    }

    protected function setError($error){
        $_SESSION['displayError'] = $error;
    }

    protected function setSuccess($success){
        $_SESSION['displaySuccess'] = $success;
    }
}