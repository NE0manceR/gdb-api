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
          'status' => $this->conn->getError()
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
      $queryBrands = 'SELECT
            "brands" AS source,
            id,
            brandName,
            brandType,
            brandImg
        FROM brands';

      $resultBrands = $this->conn->query($queryBrands);

      $brands_data = [];

      if ($resultBrands) {
        $brands_data = $resultBrands->fetchAll(PDO::FETCH_ASSOC);
      }

      $querySkills = 'SELECT
            "brands_skills" AS source,
            id,
            name,
            type,
            value AS brandImg
        FROM brands_skills';

      $resultSkills = $this->conn->query($querySkills);

      $skills_data = [];

      if ($resultSkills) {
        $skills_data = $resultSkills->fetchAll(PDO::FETCH_ASSOC);
      }

      echo json_encode(['brands' => $brands_data, 'skills' => $skills_data], JSON_PRETTY_PRINT);
    } catch (\Throwable $th) {
      $rows = [
        'data' => [],
        'status' => $th->getMessage()
      ];


      echo json_encode($rows, JSON_PRETTY_PRINT);
    }
  }

  function update_brand($data)
  {
    $res = [
      'status' => 'success',
      'message' => 'The data has been updated'
    ];

    foreach ($data as $item) {
      if ($item == '0' || $item ==  "" || $item == null) {
        $res['message'] = 'Data is not valid';

        break;
      }
    }

    try {
      $query = "UPDATE brands SET
            brandType = :brandType,
            oneItem = :oneItem,
            twoItems = :twoItems,
            threeItems = :threeItems
            WHERE
            id = :id";

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':brandType', $data['brandType']);
      $stmt->bindParam(':oneItem', $data['oneItem']);
      $stmt->bindParam(':twoItems', $data['twoItems']);
      $stmt->bindParam(':threeItems', $data['threeItems']);
      $stmt->bindParam(':id', $data['id']);

      $stmt->execute();
    } catch (\Throwable $th) {
      $res['message'] = $th->getMessage();
      $res['status'] = 'error';
    }

    echo json_encode($res);
  }

  public function update_brand_img($id, $file, $img_format)
  {
    try {

      $result = [
        'status' => 'success',
        'message' => 'BrandImg with id ' . $id . ' was updated'
      ];

      if (!empty($file['name'])) {
        $file_extansion = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (in_array($file_extansion, $img_format)) {
          $img_directories = 'uploads/brands/';
          $img_to_delete = $_SERVER['DOCUMENT_ROOT'] . '/' . $img_directories . $id;
          $new_img_name = $id . '.' . $file_extansion;
          $result['qwe']  = $img_to_delete . '.' . 'png';

          foreach ($img_format as $format) {
            if (file_exists($img_to_delete . '.' . $format)) {
              unlink($img_to_delete . '.' . $format);
            }
          }

          $img_path = 'uploads/brands/' .  $id . '.' . $file_extansion;
          $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/' . $img_directories;
          $uploadPath =  $uploadDir . basename($new_img_name);
          move_uploaded_file($file['tmp_name'], $uploadPath);

          // Оновлення поля brandImg за ідентифікатором
          $sql = "UPDATE brands SET brandImg = :brandImg WHERE id = :id";
          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':brandImg', $img_path);
          $stmt->bindParam(':id', $id);
          $stmt->execute();

          $result['test info']  = $img_to_delete;
          echo json_encode($result);
        }
      } else {
        $result = [
          'status' => 'error',
          'message' => 'No file uploaded',
        ];
      }
    } catch (\Throwable $th) {
      $result = [
        'status' => 'error',
        'message' => 'Error updating brandImg: ' . $th->getMessage()
      ];
    }

    // echo json_encode($result, JSON_PRETTY_PRINT);
  }

  function brands_info()
  {
    try {
      $query = "
            SELECT
            b.id,
            b.brandName,
            b.brandType,
            b.brandImg,
            JSON_OBJECT('name', bs1.name, 'value', bs1.value, 'type', bs1.type) AS oneItem,
            JSON_OBJECT('name', bs2.name, 'value', bs2.value, 'type', bs2.type) AS twoItems,
            JSON_OBJECT('name', bs3.name, 'value', bs3.value, 'type', bs3.type) AS threeItems
            FROM brands b
            LEFT JOIN brands_skills bs1 ON b.oneItem = bs1.id
            LEFT JOIN brands_skills bs2 ON b.twoItems = bs2.id
            LEFT JOIN brands_skills bs3 ON b.threeItems = bs3.id
            ";

      $result = $this->conn->query($query);

      $brands_data = [];

      if ($result) {
        $brands_data = $result->fetchAll(PDO::FETCH_ASSOC);
      }

      echo json_encode(['brands' => $brands_data], JSON_PRETTY_PRINT);
    } catch (\Throwable $th) {
      $rows = [
        'data' => [],
        'status' => $th->getMessage()
      ];

      echo json_encode($rows, JSON_PRETTY_PRINT);
    }
  }
}
