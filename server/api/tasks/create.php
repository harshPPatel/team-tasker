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

// Establishing the connection to the database
$db = $database->getConnection();

if ($validatedData['groupId'] !== null) {
  $group = new Group($db);
  $result = $group->getSingle($data->groupId);
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

try {
  // Creating group in database
  $result = $task->create($validatedData, $authenticatedUser['userId']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'task' => $result,
    'created_at' => time(),
  ];

  // Returning message in json format
  echo json_encode($message);

} catch (Exception $e) {
  errorHandler(
    null,
    'Error while creating the task',
    $e
  );
}

?>