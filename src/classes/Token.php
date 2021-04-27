<?php
namespace Classes;

use Classes\Session;
use Classes\Request;

class Token
{
    public static $name = '_token';

    public static function csrf()
    {
        $name = self::$name;
        $token = static::set();

        return "<input type='hidden' name='{$name}' value='{$token}'>" . PHP_EOL;
    }

    public static function set()
    {
        return Session::put(self::$name, md5(uniqid()));
    }

    public static function get()
    {
        $name = self::$name; 
        $token = Request::input($name);

        if(Session::has($name) && $token === Session::get($name)) {
            Session::delete($name);
            return true;
        }

        return false;
    }
}