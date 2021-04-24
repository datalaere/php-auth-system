<?php

namespace Classes;

use PDO;
use PDOException;
use Classes\Config;

class DB
{
    private static $_instance = null;

    private $_driver,
            $_host,
            $_dbname,
            $_username,
            $_password;

    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    public function __construct($config = [])
    {
        if(!empty($config)) {
            $this->_driver = $config['driver'];
            $this->_host =  $config['host'];
            $this->_dbname = $config['dbname'];
            $this->_username = $config['username'];
            $this->_password = $config['password'];
        } else {
            $this->_driver = Config::get('db.driver');
            $this->_host =  Config::get('db.host');
            $this->_dbname = Config::get('db.name');
            $this->_username = Config::get('db.username');
            $this->_password = Config::get('db.password');
        }

        try {
            $this->_pdo = new PDO("{$this->_driver}:host={$this->_host};dbname={$this->_dbname}", $this->_username, $this->_password);
        } catch(PDOException $error) {
            die($error->getMessage());
        }
    }

    public static function singleton()
    {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB;
        } else {
            return self::$_instance;
        }
    }

    public function query($sql, $params = [])
    {
        $this->_error = false;
    }

    public static function find($id, $singleton = true)
    {
        if($singleton) {
            $db = static::singleton();
        }

        return $id;
    }
}