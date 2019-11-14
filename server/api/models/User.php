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
    $query = "SELECT userId, username, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE username = :username
              LIMIT 1;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [
      ':username' => $username,
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

  /**
   * returns single user from database and returns user without password.
   *
   * @param int $userId
   * @return array Array of the value of user row from database
   */
  function getSingleFromId($userId) {
    // Creating query to get user from database
    $query = "SELECT userId, username, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE userId = :userId
              LIMIT 1;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [
      ':userId' => $userId,
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

  /**
   * Finds the user from the database with provided username with the password.
   *
   * @param string $username - username of the user
   * @return stdClass user object returned from the database
   */
  function getSingleWithPassword($username) {
    // Creating the query
    $query = "SELECT userId, username, password, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE username = :username;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preapring the binding values
    $bind_values = [
      ':username' => $username,
    ];

    try {
      // Executing the statement
      $statement->execute($bind_values);
      // Fetching the row and returning it
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  /**
   * Returns all users without password
   *
   * @return array 
   */
  function getAll() {
    // Creating query
    $query = "SELECT username, role, createdAt, modifiedAt
              FROM {$this->table_name};";
    // Preapring the query
    $statement = $this->db->prepare($query);

    try {
      // Executing the statement
      $statement->execute();
      // Fetching all rows and returning them
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  /**
   * Gets all users from database with the passwords
   *
   * @return array all users with the passwords
   */
  function getAllWithPassword() {
    // Creating the query
    $query = "SELECT username, password, role, createdAt, modifiedAt
              FROM {$this->table_name};";
    // Preparing the query
    $statement = $this->db->prepare($query);

    try {
      // Executing the query
      $statement->execute();
      // Fetching all rows and returning them
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  /**
   * Creates new row in user's table in database
   *
   * @param string $username
   * @param string $password
   * @return void
   */
  function create($username, $password) {
    // Time
    $time = date("Y-m-d H:i:s");

    // Creating the query
    $query = "INSERT INTO {$this->table_name} (username, password, createdAt)
              VALUES (:username, :password, :time);";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding the values
    $bind_values = [
      ':username' => $username,
      ':password' => $password,
      ':time' => $time,
    ];

    try {
      // Executing the query
      $statement->execute($bind_values);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  /**
   * Updates the user in the database
   *
   * @param string $username
   * @param string $password
   * @param integer $role
   * @return void
   */
  function update($username, $password, $role = 0) {
    $time = date("Y-m-d H:i:s");
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET password=:password, role=:role, modifiedAt=:modifiedAt
              WHERE username=:username;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':username' => $username,
      ':password' => $password,
      ':role' => $role,
      ':modifiedAt' => $time,
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  /**
   * Deletes the user in the database
   *
   * @param string $username
   * @return void
   */
  function delete($username) {
    // Creating the query
    $query = "DELETE FROM {$this->table_name}
              WHERE username=:username;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [ ':username' => $username, ];

    try {
      // Binding the values and executing the query
      $statement->execute($bind_values);
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }
}

?>