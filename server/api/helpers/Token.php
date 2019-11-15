<?php

// importing JWT
use \Firebase\JWT\JWT;

/**
 * Represents JSON Web Token in the website
 */
class JsonWebToken {
  
  // Key for signing JWT
  private $key;
  // Represents token payload
  private $token;

  /**
   * Creates the instance of JosnWebToken class and sets values of variables.
   */
  function __construct() {
    $this->key = $_ENV['SECRET_KEY_JWT'];
    $this->token = array(
        'iss' => $_ENV['WEBSITE_DOMAIN'],
        'iat' => time(),
        'exp' => time() + (60*60*6),
    );
  }

  /**
   * Generates the token for the provided user
   *
   * @param string $username username of the user
   * @return string Json Web Token for the user
   */
  function generateToken($username) {
    // Adding username to payload
    $this->token['username'] = $username;
    // Generating the token
    $jwt = JWT::encode($this->token, $this->key);
    // Returning the token
    return $jwt;
  }

  /**
   * Generates the token for the admin user
   *
   * @param string $username username of the admin user
   * @return string Json Web Token for the admin user
   */
  function generateAdminToken($username) {
    // Adding username to payload
    $this->token['username'] = $username;
    $this->token['isAdmin'] = true;
    // Generating the token
    $jwt = JWT::encode($this->token, $this->key);
    // Returning the token
    return $jwt;
  }
  
  /**
   * Verifies the provided token and returns teh decoded data
   *
   * @param string $token - token to verify
   * @return array decoded payload of the jwt
   */
  function verifyToken($token) {
    // Decoding the token
    $decoded = JWT::decode($token, $this->key, array('HS256'));
    // Returing the decoded data
    return $decoded;
  }
  
  /**
   * Verifies the provided admin token and returns the decoded data
   *
   * @param string $token - token to verify
   * @return array decoded payload of the jwt
   */
  function verifyAdminToken($token) {
    // Decoding the token
    $decoded = JWT::decode($token, $this->key, array('HS256'));
    if ($decoded->isAdmin == true) {
      // Returing the decoded data
      return $decoded;
    } else {
      return false;
    }
  }
}


?>