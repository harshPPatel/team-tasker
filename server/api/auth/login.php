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

// If user does exists than validating user
if ($result != null) {

  // Decrypting the password
  $isValidHash = password_verify($validatedData['password'], $result['password']);

  // Throwing error if password is invalid
  if (!$isValidHash) {
    errorHandler(
      409,
      'Invalid Username or Password',
      new Exception('Password is invalid for the provided user')
    );
  }

  // importing Token file
  require_once('../helpers/Token.php');

  // Creating instance of JsonWebToken class
  $jwt = new JsonWebToken();

  if ($result['role']) {
    // Generating the token
    $token = $jwt->generateToken($result['username']);

    // Preparing return message
    $message = [
      'username' => $result['username'],
      'isAdmin' => true,
      'logged_in_at' => date("Y-m-d H:i:s"),
      'token' => "Bearer {$token}",
    ];

    // Returning message in json format
    echo json_encode($message);
  } else {
    // Generating the token
    $token = $jwt->generateToken($result['username']);

    // Preparing return message
    $message = [
      'username' => $result['username'],
      'logged_in_at' => date("Y-m-d H:i:s"),
      'token' => "Bearer {$token}",
    ];

    // Returning message in json format
    echo json_encode($message);
  }

} else {
  // Throwing error if user already exists
  errorHandler(
    409,
    'Invalid Username or Password',
    new Exception('Username does not exists in the database')
  );
}

?>