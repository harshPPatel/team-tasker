<?php
/**
 * Represents MySQL database and establishes the connection to the database
 */
class Database {

  // Database host
  private $host;
  // Database name
  private $db_name;
  // Database user name
  private $username;
  // Database user password
  private $password;
  // Database connection
  public $connection;

  /**
   * creates the instances of Database class. and sets private variables's value from environment variables.
   */
  function __construct() {
    $this->host = $_ENV['DATABASE_HOST'];
    $this->db_name = $_ENV['DATABASE_NAME'];
    $this->username = $_ENV['DATABASE_USER'];
    $this->password = $_ENV['DATABASE_PASSWORD'];
  }

  /**
   * Creates connection to the database
   *
   * @return PDO database connection
   */
  public function getConnection(){
    // Setting connection to null
    $this->connection = null;

    try {
      // Connecting to teh database
      $this->connection = new PDO(
        "mysql:host={$this->host};dbname={$this->db_name}",
        $this->username,
        $this->password
      );

    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, "Error while connecting to the database", $e);
    }

    // Returning database connection object
    return $this->connection;
  }
}

?>