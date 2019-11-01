<?php

class User {
  private $table_name;
  private $db;

  function __construct($database) {
    $this->table_name = $_ENV['USER_TABLE_NAME'];
    $this->db = $database;
  }

  function getSingle($username) {
    $query = "SELECT username, role, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE username = :username;";
    $statement = $this->db->prepare($query);

    $bind_values = [
      'username' => $username,
    ];
    try {
      $statement->execute($bind_values);
      return $statement->fetch();
    } catch (PDOException $e) {
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

    $bind_values = [ 'username' => $username, ];
    try {
      $statement->execute($bind_values);
      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      errorHandler(null, null, $e);
    }
  }

  function getAllWithPassword() {
    $query = "SELECT username, password, role, createdAt, modifiedAt
              FROM {$this->table_name};";
    $statement = $this->db->prepare($query);

    $bind_values = [ 'username' => $username, ];
    try {
      $statement->execute($bind_values);
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