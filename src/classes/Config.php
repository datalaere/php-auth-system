<?php

namespace Classes;

use Exception;

class Config
{

    public static function get($path = null, $name = 'config')
    {
        if($path) {
            $config = $GLOBALS[$name];
            $path = explode('.', $path);

            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                } else {
                    throw new Exception("No config value found!");
                }
            }
            return $config;
        }
        return false;
    }

}