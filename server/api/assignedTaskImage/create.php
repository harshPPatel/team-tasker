<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  // respond to preflights
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && in_array($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'], ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'])) {
    // TODO: more validation:
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization');
  } else {
    header('Allow: GET, POST, OPTIONS, PUT, DELETE');
  }
  
  header('Vary: Origin');
  
  // 204 No Content
  http_response_code(200);
  
  exit;
}

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
  $taskImage = $image->upload();

  $imageEncoded = urlencode(filter_var($taskImage, FILTER_SANITIZE_URL));

  // Creating group in database
  $result = $assigendTaskImage->create($imageEncoded);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'group' => [
      'image' => urldecode($result['image']),
    ],
    'created_at' => date("Y-m-d H:i:s"),
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