<?php

require_once 'src/core/init.php';

use Classes\Proxies\DB;

$db = DB::select()->table('users')->get()->sql();

var_dump($db);