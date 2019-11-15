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
require_once('../validators/user.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

// Decoding json data returned from request
$data = json_decode(file_get_contents("php://input"));

// Validating the user
$validatedData = validateUser($data);

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate user in database
$user = new User($db);

// Checking if user already exists in the database
$result = $user->getSingleWithPassword($validatedData['username']);

// If user does not exists than creating new user in database
if ($result == null) {

  // Encrypting the password
  $encryptPassword = password_hash($validatedData['password'], PASSWORD_BCRYPT);

  // Creating new user in database
  $user->create($validatedData['username'], $encryptPassword);

  // Preparing return message
  $message = [
    'username' => $validatedData['username'],
    'created_at' => date("Y-m-d H:i:s"),
  ];

  // Returning message in json format
  echo json_encode($message);

} else {
  // Throwing error if user already exists
  errorHandler(
    409,
    'Username already exists',
    new Exception('Username Already exists in the database')
  );
}

?>