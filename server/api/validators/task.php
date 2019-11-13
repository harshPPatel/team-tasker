<?php

function validateTask($data) {
  // Throwing the error if enough data is not provided
  if (!$data || !$data->task || !property_exists($data, 'status') || !property_exists($data, 'urgency') || !$data->description || !$data->dueDate) {
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
  $groupId = property_exists($data, 'groupId')
    ? $data->groupId
    : null;
  
  $isValidTask = (gettype($task) === 'string');
  $isValidStatus = (is_numeric($status))
    && ((int)$status == 0 ||  (int)$status == 1);
  $isValidUrgency = (is_numeric($urgency))
    && ((int)$urgency >= 0 ||  (int)$urgency <= 2);
  $isValidDescription = (gettype($description) === 'string');
  $isValidDueDate = (gettype($dueDate) === 'string');
  $isValidGroupId = $groupId
    ? (is_numeric($groupId))
    : true;

  if (!$isValidTask || !$isValidStatus || !$isValidUrgency || !$isValidDescription || !$isValidDueDate || !$isValidGroupId) {
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
    'description' => filter_var($description, FILTER_SANITIZE_STRING),
    'dueDate' => filter_var($dueDate, FILTER_SANITIZE_STRING),
    'groupId' => ($groupId == null)
                  ? null
                  : filter_var($data->groupId, FILTER_SANITIZE_NUMBER_INT),
  ];
}

?>