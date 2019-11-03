<?php

  // adding basic required files for all endpoints
  require(__DIR__ . '\vendor\autoload.php');
  require_once(__DIR__ . '\api\helpers\errorHandler.php'); 

  // Loading Environment Variables using Dotenv
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();

  // setting header to json type
  header('Content-type: application/json');

  // Addind database file
  include(__DIR__ . './api/config/database.php');

  // creating instance of Database class
  $database = new Database();

?>