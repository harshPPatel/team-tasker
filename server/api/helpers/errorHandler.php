<?php

function errorHandler($error_code, $error_message, $e) {
  http_response_code($error_code || 500);
  $message = [
    "message" => $error_message ? $error_message : "Internal Server Error",
    "stack" => ($_ENV['APP_ENV'] === 'development') ? $e->getTrace() : [],
    "devMessage" => ($_ENV['APP_ENV'] === 'development') ? $e->getMessage() : "",
  ];

  echo json_encode($message);

  die();
}

?>