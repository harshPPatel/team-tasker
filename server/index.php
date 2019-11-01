<?php

  require(__DIR__ . '\vendor\autoload.php');
  require_once(__DIR__ . '\api\helpers\errorHandler.php'); 

  // Loading Environment Variables using Dotenv
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();

  header('Content-type: application/json');

  include(__DIR__ . './api/config/database.php');

  $database = new Database();

?>