<?php
ini_set('display_errors', 1);
error_reporting (E_ALL);

require_once '../rbac/core/init.php';

//$user = DB::getInstance()->query("SELECT username FROM users WHERE username = ?", array('anna'));
$user = DB::getInstance()->update('users', 3, array(
    'password' => 'password123',
    'name' => 'Андрей Ватулин'
));



// $db = new DB(); - не работает в singleton

// echo Config::get('mysql/host'); - 127.0.0.1
// передает путь к БД из Config.php, куда параметры для подключения приходят из init.php

// пример запроса к БД через класс DB/PDO
// $users = DB::getInstance()->query('SELECT username FROM users');
// if($users->count()) {
//    foreach($users as $user) {
//        echo $user->username;
//    }
// }