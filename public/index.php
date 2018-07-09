<?php

require '../vendor/autoload.php';

$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

$router->get('/', 'IndexController@index');
$router->get('/wake/(\d+)', 'WakeController@wakeupDevice');

$router->run();