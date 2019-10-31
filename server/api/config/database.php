<?php
class Database {

  private $host;
  private $db_name;
  private $username;
  private $password;
  public $connection;

  function __construct() {
    $this->host = $_ENV['DATABASE_HOST'];
    $this->db_name = $_ENV['DATABASE_NAME'];
    $this->username = $_ENV['DATABASE_USER'];
    $this->password = $_ENV['DATABASE_PASSWORD'];
  }

  public function getConnection(){
    $this->connection = null;

    try {
      // Connecting to teh database
      $this->connection = new PDO(
        "mysql:host={$this->host};dbname={$this->db_name}",
        $this->username,
        $this->password
      );
    } catch (PDOException $e) {
      http_response_code(500);
      $message = [
        "message" => "Error while connecting to the database",
        "stack" => ($_ENV['APP_ENV'] === 'development') ? $e->getTrace() : [],
      ];
      
      echo json_encode($message);

      die();
    }

    return $this->connection;
  }
}
?>