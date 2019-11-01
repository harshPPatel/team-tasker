<?php

function validateUser($data) {
  if (!$data || !$data->username || !$data->password) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('Insuffecient data is supplied')
    );
  }

  $username = $data->username;
  $password = $data->password;
  $confirmPassword = property_exists($data, 'confirmPassword') ? $data->confirmPassword : null;

  $isValidUser = preg_match('/^[a-zA-Z0-9]{2,20}$/', $username);
  $isValidPassword = preg_match('/^[a-zA-Z0-9@_&]{6,30}$/', $password);
  $isValidConfirmPassword = ($confirmPassword && $confirmPassword === $password);

  if (!$isValidUser || !$isValidPassword || !$isValidConfirmPassword) {
    errorHandler(
      422,
      'Invalid Username or Password',
      new Exception('Values does not satisfy provided data to the guidelines')
    );
  }

  return true;
}

?>