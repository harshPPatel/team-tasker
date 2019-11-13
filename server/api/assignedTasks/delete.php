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
if (!$data || !property_exists($data, 'assignedTaskId')) {
  errorHandler(422,
    'Unsuffecient Data provided',
    new Exception('Assigned Task ID does not exists on the database'));
}

if (!is_numeric($data->assignedTaskId)) {
  errorHandler(422,
    'Invalid Data',
    new Exception('Assigned Task ID is not a valid type'));
}

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

if ($authenticatedUser['role'] != 1) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('User is not a valid admin of the website'));
}

// Creating instance of Group to manipulate group in database
$assignedTask = new AssignedTask($db);

$tempResult = $assignedTask->getSingle($data->assignedTaskId);

if (!$tempResult || $tempResult == null) {
  errorHandler(
    404,
    'Assigned Task Not Found',
    new Exception('Assigend Task does not exists on the database'));
}

try {
  // Creating group in database
  $result = $assignedTask->delete($tempResult['assignedTaskId']);

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