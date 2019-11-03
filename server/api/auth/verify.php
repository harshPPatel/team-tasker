<?php 

// requiring all important files
require_once('../../index.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

echo print_r(getallheaders()['Authorization']);

?>