<?php

require './vendor/autoload.php';

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
