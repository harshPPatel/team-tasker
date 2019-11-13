<?php

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

  // Generating the token
  $token = $jwt->generateToken($result['username']);

  // Preparing return message
  $message = [
    'username' => $result['username'],
    'logged_in_at' => time(),
    'token' => "Bearer {$token}",
  ];

  // Returning message in json format
  echo json_encode($message);

} else {
  // Throwing error if user already exists
  errorHandler(
    409,
    'Invalid Username or Password',
    new Exception('Username does not exists in the database')
  );
}

?>