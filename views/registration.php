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

    if (isset($data['name']) && isset($data['password']) && isset($data['email'])) {
        echo $user_controller->registration($data['name'], $data['email'], $data['password']);
    }
} catch (\Throwable $th) {
    echo $th->getMessage();
}
