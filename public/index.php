<?php
session_start();
require '../vendor/autoload.php';

$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

$router->get('/', 'IndexController@index');
$router->get('/devices', 'DeviceController@index');
$router->get('/devices/add', 'DeviceController@create');
$router->post('/devices/add', 'DeviceController@save');
$router->get('/devices/delete/(\d+)', 'DeviceController@delete');
$router->get('/devices/edit/(\d+)', 'DeviceController@edit');
$router->post('/devices/edit', 'DeviceController@update');
$router->get('/wake/(\d+)', 'WakeController@wakeupDevice');

$router->run();