<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
$skey = md5("FMyNTYiLCJ0eX5".date("ymd"));

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if( $_SERVER['REQUEST_METHOD'] != 'POST'){
	require_once "../echoErr.php";
	echoErr(  (object)[ 'error' => 'inifile', 'code' => 400, 'message' => 'Bad Request'  ] );
}

$cn = require "../conn.php";

try { 
	$sql = "select id,name,email,password,role from users where name=:name";
	$sth = $cn->prepare($sql);
  $sth->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
	$sth->execute();
	if( $sth->rowCount() < 1 ) {
		require_once "../echoErr.php";
		echoErr(  (object)[ 'error' => 'inifile', 'code' => 401, 'message' => 'Unauthorized nema go'  ] );
	}
	$result = $sth->fetch(PDO::FETCH_OBJ);
// hashenbashen na passwordot
	if($_POST['password']==$result->password){
		$token = array(
			"id" => $result->id,
			"name" => $result->name,
			"email" => $result->email,
			"role" => $result->role,
			'jti' => 'deca-meca-'.date("ymdhhmm").'-jade-'.mt_rand().'-nogu'
		);
		$jwt = JWT::encode($token, $skey);
		// sleep(2);
		echo $jwt;
	  // sleep(2);	
		// print_r( JWT::decode($jwt, md5("FMyNTYiLCJ0eX5".date("Y-m-d")), array('HS256')) );
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