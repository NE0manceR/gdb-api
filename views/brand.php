<?php

global $db_config;


// Інші необхідні заголовки і код вашого серверного коду...

// Ваш код обробки запитів...

include(__DIR__ . '/../config/config.php');

require_once(__DIR__ . '/../db/Database.php');
require_once(__DIR__ . '/../controllers/Brand_Controller.php');
require_once(__DIR__ . '/../models/Brand_Model.php');

$db = new Database($db_config);
$brand_model = new Brand_Model($db);
$brand_controller = new Brand_Controller($brand_model);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'get_brands_skills') {
    echo $brand_controller->brands_info();
  }

  if ($action === 'get_all_data') {
    echo $brand_controller->get_all_data();
  }


  if ($action === 'update_brand') {

    echo $brand_controller->update_brand($_POST);

    if (!empty($_FILES['file']['name'])) {
      $brand_controller->update_brand_img($_POST['id'], $_FILES['file']);
    }
  }
}







//$request_uri = $_SERVER['REQUEST_URI'];
//$segments = explode('/', trim($request_uri, '/'));
//
//if (
//    isset($segments[0]) && isset($segments[1]) && isset($segments[2]) &&
//    $segments[0] === 'views' && $segments[1] === 'brand' && $segments[2] === 'add'
//) {
//
//    echo $brand_conteroller->update_brand($_POST, $_FILES);
//
//} elseif (
//    isset($segments[0]) && isset($segments[1]) && isset($segments[2]) &&
//    $segments[0] === 'views' && $segments[1] === 'brand' && $segments[2] === 'get_info'
//) {
//    echo $brand_conteroller->brands_info();
//
//} 