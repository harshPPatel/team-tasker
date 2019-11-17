<?php

  define('CURRENT_DIR', __DIR__);

  // adding basic required files for all endpoints
  require(CURRENT_DIR . '\vendor\autoload.php');
  require_once(CURRENT_DIR . '\api\helpers\errorHandler.php'); 

  // Loading Environment Variables using Dotenv
  $dotenv = Dotenv\Dotenv::create(CURRENT_DIR);
  $dotenv->load();

  // setting header to json type
  header('Content-type: application/json');

  // Addind database file
  include(CURRENT_DIR . '\api\config\database.php');

  // creating instance of Database class
  $database = new Database();

?>