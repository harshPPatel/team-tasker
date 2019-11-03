<?php

/**
 * Represnts user table in database
 */
class User {

  // Table name in database
  private $table_name;
  // database connection object
  private $db;

  /**
   * Creates instance of the User class. Sets private variable table's name's value from env variables.
   *
   * @param PDO database connection object
   */
  function __construct($database) {
    $this->table_name = $_ENV['USER_TABLE_NAME'];
    $this->db = $database;
  }

  /**
   * returns single user from database and returns user without password.
   *
   * @param string $username
   * @return array Array of the value of user row from database
   */
  function getSingle($username) {
    // Creating query to get user from database
    $query = "SELECT username, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE username = :username
              LIMIT 1;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [
      'username' => $username,
    ];

    try {
      // executing the query and binding the values
      $statement->execute($bind_values);
      // fetching the row and returning the value
      return $statement->fetch();

    } catch (PDOException $e) {
      // Hnadling the error
      errorHandler(null, null, $e);
    }
  }

  function getSingleWithPassword($username) {
    $query = "SELECT username, password, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE username = :username;";
    $statement = $this->db->prepare($query);

    $bind_values = [
      'username' => $username,
    ];
    try {
      $statement->execute($bind_values);
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function getAll() {
    $query = "SELECT username, role, createdAt, modifiedAt
              FROM {$this->table_name};";
    $statement = $this->db->prepare($query);

    try {
      $statement->execute();
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function getAllWithPassword() {
    $query = "SELECT username, password, role, createdAt, modifiedAt
              FROM {$this->table_name};";
    $statement = $this->db->prepare($query);

    try {
      $statement->execute();
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function create($username, $password) {
    $query = "INSERT INTO {$this->table_name} (username, password)
              VALUES (:username, :password)";
    $statement = $this->db->prepare($query);

    $bind_values = [
      'username' => $username,
      'password' => $password,
    ];
    try {
      $statement->execute($bind_values);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function update($username, $password, $role = 0) {
    $query = "UPDATE {$this->table_name}
              SET password=:password, role=:role
              WHERE username=:username;";
    $statement = $this->db->prepare($query);

    $bind_values = [
      'username' => $username,
      'password' => $password,
      'role' => $role,
    ];

    try {
      $statement->execute($bind_values);
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function delete($username) {
    $query = "DELETE FROM {$this->table_name}
              WHERE username=:username;";
    $statement = $this->db->prepare($query);

    $bind_values = [ 'username' => $username, ];

    try {
      $statement->execute($bind_values);
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }
}

?>