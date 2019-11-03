<?php

// importing JWT
use \Firebase\JWT\JWT;

class JsonWebToken {
  private $key;
  private $token;

  function __construct() {
    $this->key = $_ENV['SECRET_KEY_JWT'];
    $this->token = array(
        'iss' => $_ENV['WEBSITE_DOMAIN'],
        'iat' => time(),
        'exp' => time() + (60*60*6),
    );
  }

  function generateToken($username) {
    $this->token['username'] = $username;
    $jwt = JWT::encode($this->token, $this->key);
    return $jwt;
  }
  
  function verifyToken($token) {
    $decoded = JWT::decode($token, $this->key, array('HS256'));
    return $decoded;
  }
}


?>