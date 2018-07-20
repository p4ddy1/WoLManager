<?php

require './vendor/autoload.php';

echo 'Creating tables...';

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

echo 'Tables created!';