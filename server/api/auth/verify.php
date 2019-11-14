<?php 

// requiring all important files
require_once('../../index.php');
require_once('../validators/token.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

// Verifying the token
$decoded = verifyToken();

// Preparing response message
$message = [
  'message' => 'Token is verified succesfully. User is autorized to access the data.',
  'isLoggedIn' => true,
  'username' => $decoded->username,
  'response_time' => date("Y-m-d H:i:s"),
];

// Returning message in json format
echo json_encode($message);

?>