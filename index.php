<?php

require_once 'src/core/init.php';

$db = DB::select()->table('users')->get()->sql();

var_dump($db);