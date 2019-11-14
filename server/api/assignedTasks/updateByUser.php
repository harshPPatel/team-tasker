<?php

// requiring all important files
require_once('../../index.php');
require_once('../models/User.php');
require_once('../models/AssignedTask.php');
require_once('../validators/token.php');
require_once('../validators/assignedTask.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();

// Decoding json data returned from request
$data = json_decode(file_get_contents("php://input"));

// Verifying the data
$validatedData = validateUpdateAssignedTaskForUser($data);

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

if ($authenticatedUser['role'] == 1) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('Admin is not allowed to complete the task'));
}

// Creating instance of Group to manipulate group in database
$assignedTask = new AssignedTask($db);

$tempResult = $assignedTask->getSingle($validatedData['assignedTaskId']);

if (!$tempResult || $tempResult == null) {
  errorHandler(
    404,
    'Assigned Task Not Found',
    new Exception('Assigend Task does not exists on the database'));
}

if ($tempResult['userId'] != $authenticatedUser['userId']) {
  errorHandler(
    401,
    'Unauthorized request',
    new Exception('Assigend Task does not belongs to logged in user'));
}

try {
  // Creating group in database
  $result = $assignedTask->updateUserTask($validatedData['status'], $tempResult['assignedTaskId'], $authenticatedUser['userId']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'task' => $result,
    'created_at' => date("Y-m-d H:i:s"),
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