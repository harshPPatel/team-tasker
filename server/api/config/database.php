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
      errorHandler(null, "Error while connecting to the database", $e);
    }

    return $this->connection;
  }
}

?>