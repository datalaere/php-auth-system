<?php

return [
    'db' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'mysql',
        'name' => 'php-auth-system'
    ],
    'cookie' => [
        'name' => 'hash',
        'expiry' => 604800
    ],
    'session' => [
        'name' => 'user'
    ],
    'aliases' => [
        'DB' => 'Classes\Proxies\DB'
    ]
];