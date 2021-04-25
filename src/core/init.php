<?php

session_start();

$GLOBALS['config'] = require_once 'config/system.php';

spl_autoload_register(function($class) {
    require_once 'src/' . str_replace('\\', '/', $class) . '.php';
});

$app = new Classes\Container;

$app->set('DB', function() {
    return new Classes\Database(Classes\Config::get('db'));
});

Classes\Proxies\Proxy::setProxyApplication($app);

$aliases = require 'config/aliases.php';
Classes\Proxies\Alias::getInstance($aliases)->register();

require_once 'src/functions/sanitize.php';
require_once 'src/functions/system.php';