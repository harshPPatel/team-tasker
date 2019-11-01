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
  $confirmPassword = $data->confirmPassword ? $data->confirmPassword : null;

  if (!preg_match('/^[a-zA-Z0-9]{2,20}$/', $username)) {
    errorHandler(
      422,
      'Invalid Username or Password',
      new Exception('Invalid Username or Password')
    );
  }

  if (!preg_match('/^[a-zA-Z0-9@_&]{6,30}$/', $password)) {
    errorHandler(
      422,
      'Invalid Username or Password',
      new Exception('Invalid Username or Password')
    );
  }


}

?>