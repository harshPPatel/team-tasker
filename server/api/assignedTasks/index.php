<?php

// requiring all important files
require_once('../../index.php');
require_once('../models/User.php');
require_once('../models/AssignedTask.php');
require_once('../validators/token.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();

// Decoding json data returned from request
$data = json_decode(file_get_contents("php://input"));

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$assignedTask = new AssignedTask($db);

$authenticatedUser = $user->getSingle($decoded->username);

if ($authenticatedUser['role'] === 1) {
  $result = $assignedTask->getAll();
} else {
  $result = $assignedTask->getAllUserTasks($authenticatedUser['userId']);
}


// If user does exists than validating user
if ($result != null) {
  // Preparing return message
  $message = [
    'username' => $decoded->username,
    'tasks' => $result,
    'total' => count($result),
  ];

  // Returning message in json format
  echo json_encode($message);

} else {
  // Preparing return message
  $message = [
    'username' => $decoded->username,
    'tasks' => [],
    'count' => 0,
    'message' => 'No tasks found',
  ];

  // Returning message in json format
  echo json_encode($message);
}

?>