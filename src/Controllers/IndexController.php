<?php
namespace App\Controllers;

use App\Base\BaseController;

class IndexController extends BaseController
{
    public function index(){
        echo $this->twig->render('index.html.twig');
    }
}