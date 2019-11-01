<?php

require_once('../../index.php');
require_once('../models/User.php');
require_once('../validators/user.php');

$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$data = json_decode(file_get_contents("php://input"));

validateUser($data);

$user = new User($db);

$result = $user->getSingleWithPassword($data->username);

if ($result == null) {
  $user->create($data->username, $data->password);
  $message = [
    'username' => $data->username,
    'created_at' => time(),
  ];
  
  echo json_encode($message);
} else {
  errorHandler(409, 'Username already exists', new Exception('Username Already exists in the database'));
}

?>