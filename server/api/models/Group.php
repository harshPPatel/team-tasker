<?php

class Group {
  private $table_name;
  private $db;

  function __construct($database) {
    $this->table_name = $_ENV['GROUP_TABLE_NAME'];
    $this->db = $database;
  }

  function getSingle($groupId) {
    // Creating query to get all groups of user from database
    $query = "SELECT groupId, name, image, userId
              FROM {$this->table_name}
              WHERE groupId = :groupId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [ ':groupId' => $groupId, ];

    try {
      // executing the query and binding the values
      $statement->execute($bind_values);
      // fetching the row and returning the value
      return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      // Hnadling the error
      errorHandler(null, null, $e);
    }
  }

  function getAll($userId) {
    // Creating query to get all groups of user from database
    $query = "SELECT groupId, name, image, userId
              FROM {$this->table_name}
              WHERE userId = :userId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [ ':userId' => $userId, ];

    try {
      // executing the query and binding the values
      $statement->execute($bind_values);
      // fetching the row and returning the value
      return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      // Hnadling the error
      errorHandler(null, null, $e);
    }
  }

  public function create($name, $image, $userId) {
    // die(gettype($image));
    $time = time();
    // Creating the query
    $query = "INSERT INTO `{$this->table_name}`
              (`name`, `image`, `userId`, `createdAt`)
              VALUES (:groupName, :groupImage, :groupUser, :groupTime);";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding the values
    $bind_values = [
      ':groupName' => $name,
      ':groupImage' => $image,
      ':groupTime' => $time,
      ':groupUser' => $userId,
    ];

    // die(print_r($bind_values));

    try {
      // Executing the query
      $statement->execute($bind_values);
      // die(print_r($statement));
      return [
        'name' => $name,
        'image' => $image,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function update($groupId, $name, $image) {
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET name=:name, image=:image
              WHERE groupId=:groupId;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':name' => $name,
      ':image' => $image,
      ':groupId' => $groupId,
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
      return [
        'groupId' => $groupId,
        'name' => $name,
        'image' => $image,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function delete($groupId) {
    // Creating the query
    $query = "DELETE FROM {$this->table_name}
              WHERE groupId=:groupId;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [ ':groupId' => $groupId, ];

    try {
      // Binding the values and executing the query
      $statement->execute($bind_values);

      return [
        'groupId' => $groupId
      ];

    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }
}

?>