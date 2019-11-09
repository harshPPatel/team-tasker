<?php

/**
 * Validates the user data provided in the request
 *
 * @param array $data
 * @return bool returns only true if the data is valid
 */
function validateUser($data) {
  // Throwing the error if enough data is not provided
  if (!$data || !$data->username || !$data->password) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('Insuffecient data is supplied')
    );
  }

  // Getting values from $data
  $username = $data->username;
  $password = $data->password;
  $confirmPassword = property_exists($data, 'confirmPassword')
    ? $data->confirmPassword
    : null;

  // Validating all properties
  $isValidUser = preg_match('/^[a-zA-Z0-9]{2,20}$/', $username);
  $isValidPassword = preg_match('/^[a-zA-Z0-9@_&]{6,30}$/', $password);
  $isValidConfirmPassword = $confirmPassword ? ($confirmPassword === $password) : true;

  // Throwing the error if one them property is not valid
  if (!$isValidUser || !$isValidPassword || !$isValidConfirmPassword) {
    errorHandler(
      422,
      'Invalid Username or Password',
      new Exception('Values does not satisfy provided data guidelines')
    );
  }

  // Returning true if data is valid
  return true;
}

?>