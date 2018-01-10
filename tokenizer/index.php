<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
$skey = "AiSFMyNTYiLCJ0eXAi234123";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$cn = require "../conn.php";

try { 
	$sql = "select id,name,email,password from users where name='".$_POST['name']."'";
	$sth = $cn->prepare($sql);
  $sth->execute();
	$result = $sth->fetch(PDO::FETCH_OBJ);
// hashenbashen na passwordot
	if($_POST['password']==$result->password){
		$token = array(
			"id" => $result->id,
			"name" => $result->name,
			"email" => $result->email,
			"role" => $result->role,
			'jti' => 'deca-meca-4bc0-'.$result->id.'jade-423e34-nogu'
		);
		$jwt = JWT::encode($token, $skey);
		echo $jwt;
		// print_r( JWT::decode($jwt, $skey, array('HS256')) );
	 	die();
	}
	else{
		require_once "../echoErr.php";
		echoErr(  (object)[ 'error' => 'inifile', 'code' => 401, 'message' => 'Unauthorized'  ] );
	}
} 
catch (PDOException $e) { 
	echoErr( $e ); 
} 

?>