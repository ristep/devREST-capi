<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$key = "AiSFMyNTYiLCJ0eXAiOiAiSldpansoft20234123";
$token = array(
    "name" => "rispan",
		"email" => "ristepan@gmail.com",
		"mesto" => "kavadarci",
		"admin" => true,
		'sub' => '1234567890',
		'jti' => 'dcab10a2-f6b4-4bc0-9534-4f2209922bbd'
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key);
$decoded = JWT::decode($jwt, $key, array('HS256'));

print($jwt);

echo '\r\n';

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));

?>