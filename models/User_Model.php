<?php
class User_model
{
    private $conn;

    function __construct(?Database $db = null)
    {
        $this->conn = $db;
    }

    public function registration($name, $email, $user_password)
    {
        try {
            $sql = "INSERT INTO `users` (`name`, `email`, `password`, `salt`) VALUES (:name, :email, :password, :salt)";
            $stmt = $this->conn->prepare($sql);
    
            $salt = $this->generateRandomSalt();
            $hashedPassword = password_hash($user_password . $salt, PASSWORD_BCRYPT);
    
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':salt', $salt, PDO::PARAM_STR);
            $stmt->execute();
    
            $new_user_id = $this->conn->lastInsertId();
            session_start();
            $_SESSION['user_id'] = $new_user_id;
    
            $info = [
                'status' => 'success',
                "text" => 'Акаунт створено',
                'user_status' => 'is_login'
            ];
    
            echo json_encode($info, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $info = [
                    'status' => 'error',
                    "text" => 'Акаунт вже існує',
                ];
    
                echo json_encode($info, JSON_PRETTY_PRINT);
            } else {
                $info = [
                    'status' => 'error',
                    "text" => $e->getMessage(),
                ];
    
                echo json_encode($info, JSON_PRETTY_PRINT);
            }
        }
    }

    private function generateRandomSalt($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }

    public function login($email, $password_from_user)
    {
        try {
            $sql = "SELECT `id`, `name`, `email`, `password`, `salt` FROM `users` WHERE `email` = :email";
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $hashedPasswordFromDatabase = $result['password'];
                $salt_from_db = $result['salt'];
    
                if (password_verify($password_from_user . $salt_from_db, $hashedPasswordFromDatabase)) {
                    session_start();
                    $_SESSION['user_id'] = $result['id'];
    
                    $info = [
                        "name" => $result["name"],
                        "id" => $result["id"],
                        "text" => "Логанація успішна"
                    ];
    
                    echo json_encode($info);
                } else {
    
                    $info = [
                        "error" => "Помилка автентифікації",
                        "text" => "Не валідні дані"
                    ];
    
                    echo json_encode($info);
                }
            } else {
                $info = [
                    "error" => "Помилка автентифікації",
                    "text" => "Не валідні дані"
                ];
                echo json_encode($info);
            }
        } catch (PDOException $e) {
            echo "Помилка виконання SQL-запиту: " . $e->getMessage();
        }
    }
}
