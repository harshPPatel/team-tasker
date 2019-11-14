<?php

class Task {
  private $table_name;
  private $db;

  function __construct($database) {
    $this->table_name = $_ENV['TASK_TABLE_NAME'];
    $this->db = $database;
  }

  function getSingle($taskId) {
    // Creating query to get all groups of user from database
    $query = "SELECT taskId, task, status, urgency, description, dueDate, userId, groupId, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE taskId = :taskId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [ ':taskId' => $taskId, ];

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

  function getAllUserTasks($userId) {
    // Creating query to get all groups of user from database
    $query = "SELECT taskId, task, status, urgency, description, dueDate, userId, groupId, createdAt, modifiedAt
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

  function getAllUserGroupTasks($groupId, $userId) {
    // Creating query to get all groups of user from database
    $query = "SELECT taskId, task, status, urgency, description, dueDate, userId, groupId, createdAt, modifiedAt
              FROM {$this->table_name}
              WHERE userId = :userId && groupId = :groupId
              ORDER BY modifiedAt DESC;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding values
    $bind_values = [
      ':userId' => $userId,
      ':groupId' => $groupId,
    ];

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

  public function create($task, $userId) {
    // die(gettype($image));
    $time = date("Y-m-d H:i:s");
    // Creating the query
    $query = "INSERT INTO {$this->table_name}
              (`task`, `status`, `urgency`, `description`, `dueDate`, `userId`, `groupId`, `createdAt`)
              VALUES (:task, :status, :urgency, :description, :dueDate, :userId, :groupId, :createdAt);";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Binding the values
    $bind_values = [
      ':task' => $task['task'],
      ':status' => $task['status'],
      ':urgency' => $task['urgency'],
      ':description' => htmlspecialchars($task['description'], ENT_QUOTES),
      ':dueDate' => $task['dueDate'],
      ':userId' => $userId,
      ':groupId' => $task['groupId'],
      ':createdAt' => $time,
    ];

    // die(print_r($bind_values));

    try {
      // Executing the query
      $statement->execute($bind_values);
      // die(print_r($statement));
      return [
        'task' => $task['task'],
        'status' => $task['status'],
        'urgency' => $task['urgency'],
        'description' => htmlspecialchars_decode($task['description'], ENT_QUOTES),
        'dueDate' => $task['dueDate'],
        'userId' => $userId,
        'groupId' => $task['groupId'],
        'createdAt' => $time,
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function update($task, $taskId, $userId) {
    $time = date("Y-m-d H:i:s");
    // Creating the query
    $query = "UPDATE {$this->table_name}
              SET task=:task, status=:status, urgency=:urgency, description=:description, dueDate=:dueDate, groupId=:groupId, modifiedAt=:modifiedAt
              WHERE taskId = :taskId
                AND userId = :userId;";

    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':task' => $task['task'],
      ':status' => $task['status'],
      ':urgency' => $task['urgency'],
      ':description' => htmlspecialchars($task['description'], ENT_QUOTES),
      ':dueDate' => $task['dueDate'],
      ':modifiedAt' => $time,
      ':groupId' => $task['groupId'],
      ':taskId' => $taskId,
      ':userId' => $userId,
    ];

    try {
      // Binding values and executing the query
      $statement->execute($bind_values);
      return [
        'task' => $task['task'],
        'status' => $task['status'],
        'urgency' => $task['urgency'],
        'description' => htmlspecialchars_decode($task['description'], ENT_QUOTES),
        'dueDate' => $task['dueDate'],
        'modifiedAt' => $time,
        'groupId' => $task['groupId'],
      ];
    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }

  public function delete($taskId, $userId) {
    // Creating the query
    $query = "DELETE FROM {$this->table_name}
              WHERE taskId=:taskId
                AND userId=:userId;";
    // Preparing the query
    $statement = $this->db->prepare($query);

    // Preparing the binding values
    $bind_values = [
      ':taskId' => $taskId,
      ':userId' => $userId,
    ];

    try {
      // Binding the values and executing the query
      $statement->execute($bind_values);

      return [
        'taskId' => $taskId,
      ];

    } catch (PDOException $e) {
      // Handling the error
      errorHandler(null, null, $e);
    }
  }
}

?>