<?php

  require __DIR__ . '\vendor\autoload.php';

  // Loading Environment Variables using Dotenv
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();

  header('Content-type: application/json');

?>