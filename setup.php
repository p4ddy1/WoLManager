<?php

require './vendor/autoload.php';

echo "Checking if db directory is writable...\n";
if(!is_writable(__DIR__.'/db')){
    echo "Error! db directory is not writable. Please check permissions!\n";
    exit(1);
}
echo "db directory is writable. Good!\n";

echo "Creating tables...\n";

$db = \App\Classes\Database::getInstance();

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

echo "Tables created!\n";
echo "Please add an account\n";
do {
    echo "Username: ";
    $username = trim(fgets(STDIN));
}while(empty($username));

do {
    echo "Password: ";
    $password = trim(fgets(STDIN));
}while(empty($password));

$user = new \App\Models\User();
$user->setUsername($username);
$user->setPassword($password);
$user->create();

echo "\nUser created!\n";
echo "We are done!\n";
exit(0);