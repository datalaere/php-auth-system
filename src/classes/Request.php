<?php

namespace Classes;

use Classes\Session;

class Request
{
    public static function filled($item)
    {
        return static::has($item);
    }

    public static function has($item)
    {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } elseif(isset($_GET[$item])) {
            return $_GET[$item];
        } else {
            return false;
        }
    }

    public static function exists($type = 'post')
    {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;
            
            case 'get';
                return (!empty($_GET)) ? true : false;
            break;

            default:
                return false;
            break;
        }
    }

    public static function get($item)
    {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } elseif(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return false;
    }

    public static function input($item)
    {
        return static::get($item);
    }

    public static function old($item)
    {
        return static::get($item);
    }

    public static function all()
    {
        return array_merge($_POST, $_GET);
    }
    
}