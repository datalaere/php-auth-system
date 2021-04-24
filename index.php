<?php

require_once 'src/core/init.php';

use Classes\DB;

$data = DB::singleton()->select()->table('users')->where(['id', '=', 1])->get();

var_dump($data);