<?php

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();

    }

    public function check($source, $items = array()) {
        foreach($items as $item => $rules) { // $items здесь это массив правил в register.php
            foreach($rules as $rule => $rule_value) {
                
                $value = trim($source[$item]);

                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} необходимое поле");
                } else if(!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(mb_strlen($value) < $rule_value) {
                                $this->addError("{$item} должно быть минимум {$rule_value} символа");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$item} должно быть максимум {$rule_value} символов");
                        }
                        break;
                        case 'matches':
                            if($value !=$source[$rule_value]) {
                                $this->addError("{$rule_value} должно совпадать с {$item}");
                            }
                        break;
                        case 'unique': // проверка на существование в БД
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError("{$item} уже зарегистрирован");
                            }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)) { // если функция errors ничего не вернула
            $this->_passed = true; // то валидация прошла
        }

        return $this; // поэтому check() возвращает введенные данные
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }
}