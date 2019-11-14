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
$validatedData = validateUpdateAssignedTaskImage('image', 'id');

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$assigendTaskImage = new AssignedTaskImage($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

if ($authenticatedUser['role'] != 1) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('User is not a valid admin to the website'));
}

$image = new Image('image', 'assignedTasks');

$resultTemp = $assigendTaskImage->getSingle($validatedData['id']);

if (!$resultTemp || $resultTemp == null) {
  errorHandler(404,
    'Assigned Task Image Does Not Exists',
    new Exception('Group ID does not exists in the database'));
}

try {
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $taskImage = $image->upload();
    $imageEncoded = urlencode(filter_var($taskImage, FILTER_SANITIZE_URL));
    $image->remove(urldecode($resultTemp['image']));
  } else {
    $imageEncoded = $resultTemp['image'];
  }

  // Creating group in database
  $result = $assigendTaskImage->update($imageEncoded, $validatedData['id']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'assignedTaskImage' => [
      'assignedTaskImageId' => $result['assignedTaskImageId'],
      'image' => urldecode($result['image']),
      'modifiedAt' => $result['modifiedAt'],
    ],
    'message' => 'Assigned Task Image updated successfully',
    'modifiedAt' => date("Y-m-d H:i:s"),
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