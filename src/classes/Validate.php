<?php

namespace Classes;

use Classes\Database;
use Classes\Error;

class Validate
{
    protected $db;

    protected $error;

    protected $items;

    protected $rules = [
        'required', 
        'min', 
        'max', 
        'email',
        'alnum',
        'match',
        'unique'
    ];

    public $messages = [
        'required' => ':input field is required',
        'min' => ':input field must be a minimum of :rule length',
        'max' => ':input field must be a maximum of :rule length',
        'email' => 'Invalid email address!',
        'alnum' => ':input field must be only letters and numbers',
        'match' => ':input field must match the :rule field',
        'unique' => ':input is already taken!'
    ];

    public function __construct(Database $db, Error $error)
    {
        $this->db = $db;
        $this->error = $error;
    }

    public function validate($rules, $items = [])
    {
        if(empty($items)) {
            $items = $_POST;
        }
        
        $this->items = $items;

        foreach($items as $item => $value)
        {
            if(in_array($item, array_keys($rules))) {
                $this->check([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }

        return $this;
    }

    public function fails()
    {
        return $this->error->has();
    }

    public function passed()
    {
        if(!$this->error->has()) {
            return true;
        }
        return false;
    }

    public function errors()
    {
        return $this->error;
    }

    protected function check($item)
    {
        $field = $item['field'];

        if(is_string($item['rules'])) {
            $items  = explode('|', $item['rules']);
            foreach($items as $key => $value) {
                list($k, $v) = explode(':', $value);
                if(empty($v)) {
                    $v = true;
                }
                $rules[$k] = $v;
            }
            $item['rules'] = $rules;
        }

        foreach($item['rules'] as $rule => $check) {
            if(in_array($rule, $this->rules)) {
                if(!call_user_func_array([$this, $rule], [$field, $item['value'], $check])) {
                    $input = str_replace('_', ' ', $field);
                    $this->error->set(
                        str_replace([':input', ':rule'], [ucfirst($input), $check], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }

    protected function required($field, $value, $check)
    {
        return !empty(trim($value));
    }

    protected function min($field, $value, $check)
    {
        return mb_strlen($value) >= $check;
    }

    protected function max($field, $value, $check)
    {
        return mb_strlen($value) <= $check;
    }

    protected function email($field, $value, $check)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function alnum($field, $value, $check)
    {
        return ctype_alnum($value);
    }

    protected function match($field, $value, $check)
    {
        return $value === $this->items[$check];
    }

    protected function unique($field, $value, $check)
    {
        return !$this->db->select($field)->table($check)->where($field, '=', $value)->first();
    }
}