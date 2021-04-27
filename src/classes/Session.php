<?php

namespace Classes;

class Session
{
    public static function has($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        if(static::has($name)) {
            return $_SESSION[$name];
        }
        return false;
    }

    public static function delete($name)
    {
        if(static::has($name)) {
            unset($_SESSION[$name]);
            return true;
        }
        return false;
    }
}