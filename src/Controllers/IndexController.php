<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\Auth;

class IndexController extends BaseController
{
    /**
     * Displays the front page
     */
    public function index(){
        echo $this->render('index.html.twig');
    }
}