<?php

require_once 'src/core/init.php';

use Classes\Database;
use Classes\Config;

$db =  new Database(Config::get('db'));
$data = $db->table('users')->where('id = 1')->update([
    'username' => 'Alex Garret',
    'password' => '12345'
]);

var_dump($data);