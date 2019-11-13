<?php

// requiring all important files
require_once('../../index.php');
require_once('../models/User.php');
require_once('../models/AssignedTaskImage.php');
require_once('../helpers/Image.php');
require_once('../validators/token.php');
require_once('../validators/assignedTaskImage.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();

// Verifying the data
$validatedData = validateDeleteAssignedTaskImage('id');

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$assignedTaskImage = new AssignedTaskImage($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

if ($authenticatedUser['role'] != 1) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('User is not a valid admin of the website'));
}

$image = new Image('image', $authenticatedUser['username']);

$resultTemp = $assignedTaskImage->getSingle($validatedData['id']);

if ($resultTemp == null) {
  errorHandler(404,
    'Assigned Task Image Does Not Exists',
    new Exception('Assigned Task Image ID does not exists in the database'));
}

try {
  // Creating group in database
  $result = $assignedTaskImage->delete($resultTemp['assignedTaskImageId']);
  $image->remove(urldecode($resultTemp['image']));

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'assignedTaskImage' => $result,
    'message' => 'Assigned Task Image deleted successfully',
    'deletedAt' => time(),
  ];

  // Returning message in json format
  echo json_encode($message);

} catch (Exception $e) {
  errorHandler(
    null,
    'Error while deleting the assigned Task Image',
    $e
  );
}

?>