<?php
class Brand_Model
{
    private $conn;

    function __construct(?Database $db = null)
    {
        $this->conn = $db;
    }

    function get_brands_skills()
    {
        try {
            $query = "SELECT * FROM brands_skills";
            $result = $this->conn->query($query);

            $rows = [
                'data' => [],
                'status' => ''
            ];
            // Перевірка, чи є результати запиту
            if ($result) {
                // Отримання рядків в масив
                $rows['data'] = $result->fetchAll(PDO::FETCH_ASSOC);
                $rows['status'] = 'success';
                // Виведення у форматі JSON
                header('Content-Type: application/json');
                echo json_encode($rows, JSON_PRETTY_PRINT);
            } else {
                $rows = [
                    'data' => [],
                    'status' => $db->getError()
                ];
                // Виведення помилки
                header('Content-Type: application/json');
                echo json_encode($rows, JSON_PRETTY_PRINT);
            }
        } catch (\Throwable $th) {
            $rows = [
                'data' => [],
                'status' => $th->getMessage()
            ];

            echo json_encode($rows, JSON_PRETTY_PRINT);
        }
    }

    function get_all_data()
    {
        try {
            $query = "
            SELECT 'brands' as source, id, brandName, brandType, brandImg
            FROM brands
            UNION ALL
            SELECT 'brands_skills' as source, id, name, type, value
            FROM brands_skills
        ";

            $result = $this->conn->query($query);

            $brands_data = [];
            $skills_data = [];

            if ($result) {
                $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    if ($row['source'] === 'brands') {
                        $brands_data[] = $row;
                    } elseif ($row['source'] === 'brands_skills') {
                        $skills_data[] = $row;
                    }
                }
            }

            header('Content-Type: application/json');
            echo json_encode(['brands' => $brands_data, 'skills' => $skills_data], JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            $rows = [
                'data' => [],
                'status' => $th->getMessage()
            ];

            echo json_encode($rows, JSON_PRETTY_PRINT);
        }
    }

    function update_brand($data, $file)
    {
        // Перевірка чи прийшов файл та чи не виникло помилок
        if (isset($file['brandImg']['error']) && $file['brandImg']['error'] === UPLOAD_ERR_OK) {
            // Генеруємо унікальне ім'я файлу, щоб уникнути конфліктів
            $fileName = uniqid('image_') . '_' . $file['brandImg']['name'];
    
            // Повний шлях до директорії "uploads"
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    
            // Перевірка, чи існує директорія "uploads"
            if (!file_exists($uploadDir)) {
                // Якщо не існує, створюємо її
                mkdir($uploadDir, 0777, true);
            }
    
            // Повний шлях до файлу в директорії "uploads"
            $filePath = $uploadDir . $fileName;
    
            // Переміщуємо файл до вказаної директорії
            if (move_uploaded_file($file['brandImg']['tmp_name'], $filePath)) {
                // Оновлюємо поле brandImg у базі даних зі збереженим шляхом
                $sql = "UPDATE brands 
                        SET brandType = :brandType, oneItem = :oneItem, twoItems = :twoItems, 
                            threeItems = :threeItems, brandImg = :brandImg 
                        WHERE brandName = :brandName";
                $stmt = $this->conn->prepare($sql);
    
                $result = [
                    'status' => 'success',
                    'message' => 'Brand was updated'
                ];
                $db_img_path = BASE_URL . '/uploads/' . $fileName;
                $stmt->bindParam(':brandType', $data['brandType']);
                $stmt->bindParam(':oneItem', $data['oneItem']);
                $stmt->bindParam(':twoItems', $data['twoItems']);
                $stmt->bindParam(':threeItems', $data['threeItems']);
                $stmt->bindParam(':brandImg', $db_img_path); // Зберігаємо повний шлях у базі даних
                $stmt->bindParam(':brandName', $data['brandName']);
    
                if (!$stmt->execute()) {
                    $result['status'] = 'error';
                    $result['message'] = 'Try again later';
                }
            } else {
                $result['status'] = 'error';
                $result['message'] = 'Failed to move the uploaded file';
            }
        } else {
            $result['status'] = 'error';
            $result['message'] = 'No file uploaded or an error occurred';
        }
    
        echo json_encode($result);
    }
    
}
