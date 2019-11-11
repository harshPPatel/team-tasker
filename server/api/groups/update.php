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
validateUpdateGroup('image', 'id');

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

$groupResult = $group->getSingle($_POST['id']);

if (!$groupResult || $groupResult == null) {
  errorHandler(404,
    'Group Does Not Exists',
    new Exception('Group ID does not exists in the database'));
}

if ($groupResult['userId'] !== $authenticatedUser['userId']) {
  errorHandler(401,
    'Unauthorized Request',
    new Exception('Group does not belongs to the logged in user'));
}

try {
  if (isset($_FILES['image'])) {
    $groupImage = $image->upload();
    $imageEncoded = filter_var($groupImage, FILTER_SANITIZE_ENCODED);
    $image->remove(urldecode($groupResult['image']));
  } else {
    $imageEncoded = $groupResult['image'];
  }

  // Creating group in database
  $result = $group->update($groupResult['groupId'], $_POST['name'], $imageEncoded);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'group' => [
      'name' => $result['name'],
      'image' => $result['image'],
    ],
    'message' => 'Group updated successfully',
    'modifiedAt' => time(),
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