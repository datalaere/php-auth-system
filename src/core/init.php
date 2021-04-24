<?php

session_start();

$GLOBALS['config'] = require_once 'config/system.php';

spl_autoload_register(function($class) {
    require_once 'src/' . str_replace('\\', '/', $class) . '.php';
});

require_once 'src/functions/sanitize.php';
require_once 'src/functions/system.php';