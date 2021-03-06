<?php

// requiring the JsonWebToken class
require_once('../helpers/Token.php');

/**
 * Verifies the token in request
 *
 * @return stdClass decoded token payload
 */
function verifyToken() {
// echo 'Hello' . $data . 'Hello';
  // Throwing the error if `token` value does not exists
  // if (!property_exists($data, 'token')) {
  //   errorHandler(
  //     400,
  //     'Bad Request',
  //     new Exception('No token found in the request')
  //   );
  // }

  // echo json_encode(getallheaders());
  
  if (!array_key_exists('Authorization', getallheaders())) {
    errorHandler(
      400,
      'Bad Request',
      new Exception('No token found in the request')
    );
  }

  // Getting token from header
  $token = explode(' ', getallheaders()['Authorization'])[1];

  // Creating instance of JsonWebToken
  $jwt = new JsonWebToken();

  try {
    // Verifing the token and getting payload
    $result = $jwt->verifyToken($token);
    // Returning the payload
    return $result;
  } catch (Exception $e) {
    // Handling the error
    errorHandler(400, 'Bad Request', $e);
  }

}

?>