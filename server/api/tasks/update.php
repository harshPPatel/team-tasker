<?php

// requiring all important files
require_once('../../index.php');
require_once('../models/User.php');
require_once('../models/Group.php');
require_once('../models/Task.php');
require_once('../validators/token.php');
require_once('../validators/task.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();

// Decoding json data returned from request
$data = json_decode(file_get_contents("php://input"));

// Verifying the data
$validatedData = validateTask($data);

if (!property_exists($data, 'taskId')) {
  errorHandler(422,
    'Insufficient Data provided',
    new Exception('TaskId is not provided'));
}
  
if (!is_numeric($data->taskId)) {
  errorHandler(422,
    'Invalid Data Provided',
    new Exception('TaskId is not valid type (integer).'));
}

$taskId = filter_var($data->taskId, FILTER_SANITIZE_NUMBER_INT);

// Establishing the connection to the database
$db = $database->getConnection();

if ($validatedData != null) {
  $group = new Group($db);
  $result = $group->getSingle($validatedData['groupId']);
  if (!$result || $result == null) {
    errorHandler(
      404,
      'Task\'s Group Not Found',
      new Exception('The Group with provided GroupId does not exists'));
  }
}

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$task = new Task($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

$taskDatabase = $task->getSingle($taskId);

if (!$taskDatabase || $taskDatabase == null) {
  errorHandler(404,
    'Task not found',
    new Exception('Task does not exists in the database'));
}

if ($taskDatabase['userId'] !== $authenticatedUser['userId']) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('Task does not belongs to the logged in user'));
}

try {
  // Creating group in database
  $result = $task->update($validatedData, $taskDatabase['taskId'], $authenticatedUser['userId']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'task' => $result,
    'modified_at' => date("Y-m-d H:i:s"),
  ];

  // Returning message in json format
  echo json_encode($message);

} catch (Exception $e) {
  errorHandler(
    null,
    'Error while updating the task',
    $e
  );
}

?>