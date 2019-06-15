<?php
// подтягивает наборы конфигураций из init.php

// присваеваем $path = null чтобы проверить его существование далее
// path передается из index.php
class Config {
    public static function get($path = null) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            // '/' - символ, по которому делается explode, в $path записывается массив

            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
                // извлекает из массива $path элементы в $bit
            }

            return $config;

        }

        return false;
        // если путь не задан
    }
}