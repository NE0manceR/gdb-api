<?php
class Database extends PDO
{
  public function __construct($db_config)
  {
    try {
      $dsn = "mysql:host={$db_config['server_name']};dbname={$db_config['db_name']}";
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Add any other PDO options as needed
      ];

      parent::__construct($dsn, $db_config['user_name'], $db_config['password'], $options);
    } catch (PDOException $e) {
      echo "Помилка виконання SQL-запиту. Будь ласка, спробуйте пізніше.";
      // You may want to log the error instead of echoing it in a production environment.
    }
  }
}
