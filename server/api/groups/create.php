<?php

// requiring all important files
require_once('../../index.php');
require_once('../models/User.php');
require_once('../models/Group.php');
require_once('../helpers/Image.php');
require_once('../validators/token.php');
require_once('../validators/group.php');

// Thorwing error if Request Method is other than POST
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
  errorHandler(400, 'Bad Request', new Exception('Bad Request'));
}

$decoded = verifyToken();

// Verifying the data
validateGroup('image');

// Establishing the connection to the database
$db = $database->getConnection();

// Creating instance of User to manipulate group in database
$user = new User($db);

// Creating instance of Group to manipulate group in database
$group = new Group($db);

// Getting user from database
$authenticatedUser = $user->getSingle($decoded->username);

// die(print_r($authenticatedUser));

$image = new Image('image', $authenticatedUser['username']);

try {
  $groupImage = $image->upload();

  // $imageEncoded = filter_var($groupImage, FILTER_SANITIZE_ENCODED);

  // die($imageEncoded);

  // Creating group in database
  $result = $group->create($_POST['name'], $groupImage, $authenticatedUser['userId']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'group' => [
      'name' => $result['name'],
      'image' => $result['image'],
    ],
    'created_at' => time(),
  ];

  // Returning message in json format
  echo json_encode($message);

} catch (Exception $e) {
  errorHandler(
    null,
    'Error while creating the group',
    $e
  );
}

?>