<?php
include(__DIR__ . '/../config/config.php');

require_once(__DIR__ . '/../db/Database.php');
require_once(__DIR__ . '/../controllers/Brand_Controller.php');
require_once(__DIR__ . '/../models/Brand_Model.php');

$db = new Database($db_config);
$brand_model = new Brand_Model($db);
$brand_conteroller = new Brand_Controller($brand_model);


$request_uri = $_SERVER['REQUEST_URI'];
$segments = explode('/', trim($request_uri, '/'));

if (
    isset($segments[0]) && isset($segments[1]) && isset($segments[2]) &&
    $segments[0] === 'views' && $segments[1] === 'brand' && $segments[2] === 'add'
) {

    echo $brand_conteroller->update_brand($_POST, $_FILES);
} else {
    echo $brand_conteroller->get_all_data();
}
