<?php
include(__DIR__ . '/../config/config.php');

try {
    require_once(__DIR__ . '/../db/Database.php');
    require_once(__DIR__ . '/../controllers/User_Controller.php');
    require_once(__DIR__ . '/../models/User_Model.php');

    $db = new Database($db_config);
    $user_model = new User_Model($db);
    $user_controller = new User_Controller($user_model);

    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    // session_start();

    // print_r($_SESSION);

    if (isset($data['email']) && isset($data['password'])) {
        echo $user_controller->login($data['email'], $data['password']);
    }
} catch (\Throwable $th) {
    echo $th->getMessage();
}
