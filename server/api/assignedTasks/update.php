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
validateUpdateAssignedTask($data);

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


$assignedUser = $user->getSingleFromId($data->userId);
if (!$assignedUser || $assignedUser == null) {
  errorHandler(
    404,
    'Assigned Task\'s User Not Found',
    new Exception('The user with provided UserId does not exists in database'));
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
  $result = $assignedTask->update($data, $tempResult['assignedTaskId']);

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