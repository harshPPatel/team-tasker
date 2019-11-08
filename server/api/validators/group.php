<?php

function validateGroup($imageFieldName) {
  // Throwing the error if enough data is not provided
  if (!isset($_POST['name']) || !isset($_FILES["{$imageFieldName}"])) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('Insuffecient data is supplied')
    );
  }

  // Trowing error if the file is not uploaded successfully
  if ($_FILES["{$imageFieldName}"]['error'] !== 0) {
    errorHandler(
      422,
      'Image upload is unsuccessful',
      new Exception("Group Image uplaoded with error {$_FILES["{$imageFieldName}"]['error']}")
    );
  }

  // Getting values from $data
  $name = $_POST['name'];

  // Validating all properties
  $isValidUser = preg_match('/^[a-zA-Z0-9]{2,20}$/', $name);

  // Throwing the error if one them property is not valid
  if (!$isValidUser) {
    errorHandler(
      422,
      'Invalid Information',
      new Exception('Group name does not satisfy provided data to the guidelines')
    );
  }

  // Returning true if data is valid
  return true;
}

?>