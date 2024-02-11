<?php
// Отримуємо URL
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

// Визначаємо, який файл обробляє URL

switch ($url) {
  case '/admin':
    require_once(__DIR__ . '/pages/admin.php');
    break;
}
