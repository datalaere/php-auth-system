<?php

namespace Classes;

abstract class Singleton
{
    /**
     * The instance being proxied.
     * 
     */
    protected static $instance;

    public static function singleton()
    {
        if (!isset(self::$instance[static::class])) {
            $class = static::class;
            self::$instance[static::class] = new $class();
        }

        return self::$instance[static::class];
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::singleton();

        return $instance->$method(...$args);
    }
}