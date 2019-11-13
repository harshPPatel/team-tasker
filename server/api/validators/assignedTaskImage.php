<?php

function validateAssigendTaskImage($imageFieldName) {
  // Throwing the error if enough data is not provided
  if (!isset($_FILES["{$imageFieldName}"])) {
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

  // Returning true if data is valid
  return true;
}

function validateUpdateAssignedTaskImage($imageFieldName, $idFieldName) {
  // Throwing the error if enough data is not provided
  if (!isset($_POST["{$idFieldName}"])) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('Insuffecient data is supplied')
    );
  }

  if (!is_numeric($_POST["{$idFieldName}"])) {
    errorHandler(
      405,
      'Invalid Data',
      new Exception('AssignedTaskImageId is not valid integer')
    );
  }

  if (isset($_FILES["{$imageFieldName}"]) && $_FILES["{$imageFieldName}"]['error'] !== 0) {
    errorHandler(
      422,
      'Image upload is unsuccessful',
      new Exception("Group Image uplaoded with error {$_FILES["{$imageFieldName}"]['error']}")
    );
  }

  // Sanitize data here and return it in array!

  // Returning true if data is valid
  return [
    "{$idFieldName}" => filter_var($_POST["{$idFieldName}"], FILTER_SANITIZE_NUMBER_INT),
  ];
}

function validateDeleteAssignedTaskImage($idFieldName) {
  // Throwing the error if enough data is not provided
  if (!isset($_POST["{$idFieldName}"])) {
    errorHandler(
      405,
      'Insuffecient data is supplied',
      new Exception('Insuffecient data is supplied')
    );
  }

  if (!is_numeric($_POST["{$idFieldName}"])) {
    errorHandler(
      405,
      'Invalid Data',
      new Exception('AssignedTaskImageId is not valid integer')
    );
  }

  // Returning true if data is valid
  return [
    "{$idFieldName}" => filter_var($_POST["{$idFieldName}"], FILTER_SANITIZE_NUMBER_INT),
  ];
}

?>