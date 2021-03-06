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
require_once('../models/Group.php');
require_once('../validators/token.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();


// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$group = new Group($db);

$authenticatedUser = $user->getSingle($decoded->username);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $result = $group->getSingle($id, $authenticatedUser['userId']);
} else {
  $result = $group->getAll($authenticatedUser['userId']);
}

// If user does exists than validating user
if ($result != null) {
  // Preparing return message
  $message = [
    'username' => $decoded->username,
    'groups' => $result,
    'total' => count($result),
  ];

  // Returning message in json format
  echo json_encode($message);
} else {
  // Preparing return message
  $message = [
    'username' => $decoded->username,
    'groups' => [],
    'count' => 0,
    'message' => 'No groups found',
  ];

  // Returning message in json format
  echo json_encode($message);
}

?>