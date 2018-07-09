<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Models\Device;

class IndexController extends BaseController
{
    public function index(){
        $devices = Device::loadAll();
        echo $this->twig->render('index.twig.html', ['devices' => $devices]);
    }
}