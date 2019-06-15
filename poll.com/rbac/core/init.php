<?php
// соединение с БД и параметры сессии
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1', // 'localhost' обращается к таблицам DNS и замедляет подключение
        'username' => 'root',
        'password' => '12345678',
        'db' => 'poll'

    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ), // время жизни cookie по чекбоксу 'запомнить меня'
    'session' => array(
        'session_name' => 'user'
    )

);

// автоподгрузка классов
spl_autoload_register(function($class) {
    require_once '../rbac/classes/' . $class . '.php';
});

require_once '../rbac/functions/sanitize.php';

//    require_once '../rbac/classes/' . $class . '.php';
