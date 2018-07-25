<?php

namespace App\Controllers;


use App\Base\BaseController;

class ErrorController extends BaseController
{
    public function error404(){
        $this->render('error/404.html.twig');
    }
}