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
require_once('../validators/token.php');

// // Thorwing error if Request Method is other than POST
// if ($_SERVER['REQUEST_METHOD'] != 'POST')
// {
//   // echo $_SERVER['REQUEST_METHOD'];
//   errorHandler(400, 'Bad Request', new Exception('Request is not a POST Request'));
// }

// Decoding json data returned from request
$data = json_decode(file_get_contents("php://input"));

// Verifying the token
$decoded = verifyToken();
// $decoded = verifyToken($data);
// die(property_exists($decoded, 'isAdmin'));
// exit();
// echo print_r($decoded);
if ($decoded->username == 'admin') {
  // Preparing response message
  $message = [
    'message' => 'Token is verified succesfully. User is autorized to access the data.',
    'isLoggedIn' => true,
    'username' => $decoded->username,
    'response_time' => date("Y-m-d H:i:s"),
    'isAdmin' => true,
  ];
} else {
  // Preparing response message
  $message = [
    'message' => 'Token is verified succesfully. User is autorized to access the data.',
    'isLoggedIn' => true,
    'username' => $decoded->username,
    'response_time' => date("Y-m-d H:i:s"),
  ];
}

// Returning message in json format
echo json_encode($message);

?>