<?php

$db_config = [
    "server_name" => "localhost",
    "db_name" => "gdb",
    "user_name" => "root",
    "password" => ""
];

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Отримуємо хост (назву сервера)
$host = $_SERVER['HTTP_HOST'];
// Збираємо базовий URL
$baseURL = $protocol . '://' . $host;
define('BASE_URL', $baseURL);

$img_format = ['png', 'jpeg', 'wepb'];