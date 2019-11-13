<?php

class AssignedTask {
  private $table_name;
  private $db;

  function __construct($database) {
    $this->table_name = $_ENV['ASSIGNED_TASK_TABLE_NAME'];
    $this->db = $database;
  }

  function getSingle($assignedTaskId) {
    // Creating query to get all groups of user from database
    $query = "SELECT assignedTaskId, task, status, urgency, description, dueDate, userId, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE assignedTaskId = :assignedTaskId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [ ':assignedTaskId' => $assignedTaskId, ];

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
    $query = "SELECT assignedTaskId, task, status, urgency, description, dueDate, userId, createdAt, modifiedAt
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

  function getAllUserTasks($userId) {
    // Creating query to get all groups of user from database
    $query = "SELECT assignedTaskId, task, status, urgency, description, dueDate, userId, createdAt, modifiedAt
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


  public function create($task) {
    // die(gettype($image));
    $time = time();
    // Creating the query
    $query = "INSERT INTO {$this->table_name}
              (`task`, `status`, `urgency`, `description`, `dueDate`, `userId`, `createdAt`)
              VALUES (:task, :status, :urgency, :description, :dueDate, :userId, :createdAt);";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding the values
    $bind_values = [
      ':task' => $task['task'],
      ':status' => $task['status'],
      ':urgency' => $task['urgency'],
      ':description' => $task['description'],
      ':dueDate' => $task['dueDate'],
      ':userId' => $task['userId'],
      ':createdAt' => $time,
    ];

    try {
      // Executing the query
      $statement->execute($bind_values);

      return [
        'task' => $task['task'],
        'status' => $task['status'],
        'urgency' => $task['urgency'],
        'description' => $task['description'],
        'dueDate' => $task['dueDate'],
        'userId' => $task['userId'],
        'createdAt' => $time,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function update($task, $assignedTaskId) {
    $time = time();
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET task=:task, status=:status, urgency=:urgency, description=:description, dueDate=:dueDate, userId=:userId, modifiedAt=:modifiedAt
              WHERE assignedTaskId = :assignedTaskId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':task' => $task['task'],
      ':status' => (int)$task['status'],
      ':urgency' => (int)$task['urgency'],
      ':description' => $task['description'],
      ':dueDate' => (int)$task['dueDate'],
      ':modifiedAt' => (int)$time,
      ':assignedTaskId' => (int)$assignedTaskId,
      ':userId' => (int)$task['userId'],
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
      return [
        'task' => $task['task'],
        'status' => (int)$task['status'],
        'urgency' => (int)$task['urgency'],
        'description' => $task['description'],
        'dueDate' => (int)$task['dueDate'],
        'modifiedAt' => (int)$time,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function updateUserTask($taskStatus, $assignedTaskId, $userId) {
    $time = time();
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET status=:status, modifiedAt=:modifiedAt
              WHERE assignedTaskId = :assignedTaskId
                AND userId = :userId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':status' => (int)$taskStatus,
      ':modifiedAt' => (int)$time,
      ':assignedTaskId' => (int)$assignedTaskId,
      ':userId' => (int)$userId,
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
      return [
        'assignedTaskId' => (int)$assignedTaskId,
        'status' => (int)$taskStatus,
        'userId' => (int)$userId,
        'modifiedAt' => (int)$time,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function delete($assignedTaskId) {
    // Creating the query
    $query = "DELETE FROM {$this->table_name}
              WHERE assignedTaskId=:assignedTaskId;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [ ':assignedTaskId' => $assignedTaskId, ];

    try {
      // Binding the values and executing the query
      $statement->execute($bind_values);

      return [ 'assignedTaskId' => $assignedTaskId, ];

    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }
}

?>