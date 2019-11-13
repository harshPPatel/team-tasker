<?php

function validateAssignedTask($data) {
  // Throwing the error if enough data is not provided
  if (!$data || !$data->task || !property_exists($data, 'status') || !property_exists($data, 'urgency') || !$data->description || !$data->dueDate || !$data->userId) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('All data is not provided')
    );
  }

  $task = $data->task;
  $status = $data->status;
  $urgency = $data->urgency;
  $description = $data->description;
  $dueDate = $data->dueDate;
  $userId = $data->userId;
  
  $isValidTask = (gettype($task) === 'string');
  $isValidStatus = (is_numeric($status))
    && ((int)$status == 0 ||  (int)$status == 1);
  $isValidUrgency = (is_numeric($urgency))
    && ((int)$urgency >= 0 ||  (int)$urgency <= 2);
  $isValidDescription = (gettype($description) === 'string');
  $isValidDueDate = (gettype($dueDate) === 'string');
  $isValidUserId = is_numeric($userId);

  if (!$isValidTask || !$isValidStatus || !$isValidUrgency || !$isValidDescription || !$isValidDueDate || !$isValidUserId) {
    errorHandler(
      422,
      'Invalid Data provided',
      new Exception('Values does not satisfy provided data guidelines')
    );
  }

  return [
    'task' => filter_var($task, FILTER_SANITIZE_STRING),
    'status' => filter_var($status, FILTER_SANITIZE_NUMBER_INT),
    'urgency' => filter_var($urgency, FILTER_SANITIZE_NUMBER_INT),
    'description' => filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS),
    'dueDate' => filter_var($dueDate, FILTER_SANITIZE_STRING),
    'userId' => filter_var($userId, FILTER_SANITIZE_NUMBER_INT),
  ];
}

function validateUpdateAssignedTask($data) {
  validateAssignedTask($data);
  if (!property_exists($data, 'assignedTaskId')) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('All data is not provided')
    );
  }
  if (!is_numeric($data->assignedTaskId)) {
    errorHandler(
      422,
      'Invalid Data provided',
      new Exception('Assigned Task ID is not valid integer')
    );
  }

  return [
    'assignedTaskId' => filter_var($data->assignedTaskId, FILTER_SANITIZE_NUMBER_INT),
    'task' => filter_var($data->task, FILTER_SANITIZE_STRING),
    'status' => filter_var($data->status, FILTER_SANITIZE_NUMBER_INT),
    'urgency' => filter_var($data->urgency, FILTER_SANITIZE_NUMBER_INT),
    'description' => filter_var($data->description, FILTER_SANITIZE_SPECIAL_CHARS),
    'dueDate' => filter_var($data->dueDate, FILTER_SANITIZE_STRING),
    'userId' => filter_var($data->userId, FILTER_SANITIZE_NUMBER_INT),
  ];
}

function validateUpdateAssignedTaskForUser($data) {
  if (!property_exists($data, 'assignedTaskId') || !property_exists($data, 'status')) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('All data is not provided')
    );
  }

  $isValidStatus = is_numeric($data->status)
    && (
      ($data->status == 0)
      || ($data->status == 1)
    );

  if (!is_numeric($data->assignedTaskId) || !$isValidStatus) {
    errorHandler(
      422,
      'Invalid Data provided',
      new Exception('Assigned Task ID is not valid integer')
    );
  }

  return [
    'assignedTaskId' => filter_var($data->assignedTaskId, FILTER_SANITIZE_NUMBER_INT),
    'status' => filter_var($data->status, FILTER_SANITIZE_NUMBER_INT),
  ];
}

?>