<?php

require '../vendor/autoload.php';

$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

$router->get('/', 'IndexController@index');

$router->run();