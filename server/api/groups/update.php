<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  // respond to preflights
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && in_array($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'], ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'])) {
    // TODO: more validation:
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization');
  } else {
    header('Allow: GET, POST, OPTIONS, PUT, DELETE');
  }
  
  header('Vary: Origin');
  
  // 204 No Content
  http_response_code(200);
  
  exit;
}

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
$validatedData = validateUpdateGroup('image', 'id');

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

$groupResult = $group->getSingle($validatedData['id'], $authenticatedUser['userId']);

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
    $imageEncoded = urlencode(filter_var($groupImage, FILTER_SANITIZE_URL));
    $image->remove(urldecode($groupResult['image']));
  } else {
    $imageEncoded = $groupResult['image'];
  }

  // Creating group in database
  $result = $group->update($groupResult['groupId'], $validatedData['name'], $imageEncoded, $authenticatedUser['userId']);

  // Preparing return message
  $message = [
    'username' => $authenticatedUser['username'],
    'group' => [
      'name' => $result['name'],
      'image' => $result['image'],
    ],
    'message' => 'Group updated successfully',
    'modifiedAt' => date("Y-m-d H:i:s"),
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