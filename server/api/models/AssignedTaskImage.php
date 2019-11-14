<?php

class AssignedTaskImage {
  private $table_name;
  private $db;

  function __construct($database) {
    $this->table_name = $_ENV['ASSIGNED_TASK_IMAGE_TABLE_NAME'];
    $this->db = $database;
  }

  function getSingle($assignedTaskImageId) {
    // Creating query to get all groups of user from database
    $query = "SELECT assignedTaskImageId, image, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE assignedTaskImageId = :assignedTaskImageId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [ ':assignedTaskImageId' => $assignedTaskImageId, ];

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

  function getAll() {
    // Creating query to get all groups of user from database
    $query = "SELECT assignedTaskImageId, image, createdAt, modifiedAt
              FROM {$this->table_name};";

    // Preparing the query
    $statement = $this->db->prepare($query);

    try {
      // executing the query and binding the values
      $statement->execute();
      // fetching the row and returning the value
      return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      // Hnadling the error
      errorHandler(null, null, $e);
    }
  }

  public function create($image) {
    // die(gettype($image));
    $time = date("Y-m-d H:i:s");
    // Creating the query
    $query = "INSERT INTO {$this->table_name}
              (`image`, `createdAt`) VALUES (:image, :createdAt);";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding the values
    $bind_values = [
      ':image' => $image,
      ':createdAt' => $time
    ];

    try {
      // Executing the query
      $statement->execute($bind_values);

      return [ 'image' => $image ];
    
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function update($image, $assignedTaskImageId) {
    $time = date("Y-m-d H:i:s");
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET image=:image, modifiedAt=:modifiedAt
              WHERE assignedTaskImageId = :assignedTaskImageId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':image' => $image,
      ':modifiedAt' => $time,
      ':assignedTaskImageId' => $assignedTaskImageId,
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
      return [
        'image' => $image,
        'modifiedAt' => $time,
        'assignedTaskImageId' => $assignedTaskImageId,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function delete($assignedTaskImageId) {
    // Creating the query
    $query = "DELETE FROM {$this->table_name}
              WHERE assignedTaskImageId=:assignedTaskImageId;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [ ':assignedTaskImageId' => $assignedTaskImageId, ];

    try {
      // Binding the values and executing the query
      $statement->execute($bind_values);

      return [ 'assignedTaskImageId' => $assignedTaskImageId, ];

    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }
}

?>