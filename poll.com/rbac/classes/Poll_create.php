<?php

class Poll_create {
    private $_passed = false,
            $_errors = array(),
            $_db = null;



    public function __construct() {
        if($validation->passed()) {
            $this->_db = DB::getInstance();
        } else {
            echo 'Создание опросов доступно только зарегистрированным пользователям';
        }
    }

    // название совпадает с Validate.php
    public function check($poll_create, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = trim($source[$item]);

                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} необходимое поле");
                } else if(!empty($value)) {
                    switch($rule) {
                        // case?
                    }
                }
            }
        }
    }

    // проверяет факт нажатия сабмита (попытки отправки)
    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;
            case 'get':
                return (!empty($_GET)) ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }
}