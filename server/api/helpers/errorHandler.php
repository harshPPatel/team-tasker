<?php

/**
 * Handles error and returns error in json format and die the application
 *
 * @param int $error_code
 * @param string $error_message
 * @param Exception $e
 */
function errorHandler($error_code, $error_message, $e) {
  // Setting the response code
  http_response_code($error_code || 500);

  // Creating returning message
  $message = [
    "message" => $error_message ? $error_message : "Internal Server Error",
    "stack" => ($_ENV['APP_ENV'] === 'development') ? $e->getTrace() : [],
    "devMessage" => ($_ENV['APP_ENV'] === 'development') ? $e->getMessage() : "",
  ];

  // Returning message in json format
  echo json_encode($message);

  // Dieing the application
  die();
}

?>