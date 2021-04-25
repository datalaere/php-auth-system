<?php

session_start();

$GLOBALS['config'] = require_once 'config/app.php';


spl_autoload_register(function($class) {
    require_once 'src/' . str_replace('\\', '/', $class) . '.php';
});


$app = new Classes\Container;

$app->set('DB', function() {
    return new Classes\Database(Classes\Config::get('db'));
});

Classes\Proxies\Proxy::setProxyApplication($app);

Classes\Proxies\Alias::getInstance(Classes\Config::get('aliases'))->register();

require_once 'src/functions/sanitize.php';
require_once 'src/functions/app.php';