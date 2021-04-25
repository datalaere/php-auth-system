<?php

namespace Classes;

use PDO;
use Exception;
use PDOException;

class Database
{

    private const ACTION_SELECT = 'SELECT ';
    private const ACTION_DELETE = 'DELETE ';
    private const ACTION_WHERE = 'WHERE ';

    private $_driver,
            $_host,
            $_dbname,
            $_username,
            $_password;

    private $_pdo,
            $_sql,
            $_query,
            $_table,
            $_where,
            $_fields,
            $_results,
            $_count = 0,
            $_values = [],
            $_error = false,
            $_fetchStyle = PDO::FETCH_OBJ;

    public function __construct($config = [])
    {
        if(!empty($config)) {
            $this->_driver = $config['driver'];
            $this->_host =  $config['host'];
            $this->_dbname = $config['dbname'];
            $this->_username = $config['username'];
            $this->_password = $config['password'];
        } else {
            throw new Exception('Missing config!');
        }

        try {
            $this->_pdo = new PDO("{$this->_driver}:host={$this->_host};dbname={$this->_dbname}", $this->_username, $this->_password);
        } catch(PDOException $error) {
            die($error->getMessage());
        }
    }

    public function query($sql, $values = [])
    {
        $this->_error = false;

        if($this->_query = $this->_pdo->prepare($sql)) {

            $parameter = 1;
            if(count($values)) {
                foreach($values as $value) {
                    $this->_query->bindValue($parameter, $value);
                    $parameter++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll($this->_fetchStyle);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function action($action, $table, $where, $options = null)
    {

        if(isset($action) && isset($table)) {
            $this->_sql = "{$action} FROM {$table} {$where} {$options}";
                    
            if(!$this->query($this->_sql, $this->_values)) {
                return $this;
            }
        }

        return $this;
       
    }

    public function select($fields = '*')
    {
        if(is_array($fields)) {
              $fields = implode(', ', $fields);
        }
        $this->_fields = $fields;
        return $this;
    }

    public function table($table)
    {
        if($table) { 
            $this->_table = $table;
            return $this;
        }

        return false;
    }

    public function where($where = [])
    {
        if(count($where) === 3) {
            $operators = ['=', '>', '<', '>=', '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $this->_where = self::ACTION_WHERE . "{$field} {$operator} ?";
                $this->_values = [$value];
                return $this;
            }
        }

        return false;
    }

    public function sql()
    {
        if($this->_sql) {
            return $this->_sql;
        }
    }

    public function get($options = null)
    {
        return $this->action(self::ACTION_SELECT . $this->_fields, $this->_table, $this->_where, $options);
    }

    public function delete()
    {
        return $this->action(self::ACTION_DELETE, $this->_table, $this->_where);
    }


    public function error()
    {
        return $this->_error;
    }

    public function find($id, $singleton = true)
    {
        return $id;
    }
    
}