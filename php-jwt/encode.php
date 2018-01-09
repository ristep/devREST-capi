<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$token = array (
  'sub' => '1234567890',
  'name' => 'John Doe',
  'admin' => true,
  'jti' => 'dcab10a2-f6b4-4bc0-9534-4f2209922bbd',
  'iat' => 1515445735,
  'exp' => 1515449335,
);

$jwt = JWT::encode($token, "AiSFMyNTYiLCJ0eXAiOiAiSldpansoft20234123");

print_r( $jwt );
?>