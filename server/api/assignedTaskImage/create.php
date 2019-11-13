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
validateAssigendTaskImage('image');

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$assigendTaskImage = new AssignedTaskImage($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

$image = new Image('image', 'assignedTasks');

try {
  $groupImage = $image->upload();

  $imageEncoded = filter_var($groupImage, FILTER_SANITIZE_ENCODED);

  // Creating group in database
  $result = $assigendTaskImage->create($imageEncoded);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'group' => [
      'image' => urldecode($result['image']),
    ],
    'created_at' => time(),
  ];

  // Returning message in json format
  echo json_encode($message);

} catch (Exception $e) {
  errorHandler(
    null,
    'Error while creating the group',
    $e
  );
}

?>