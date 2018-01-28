<?php
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;
//$skey = md5("FMyNTYiLCJ0eX5180112");
$skey = md5("FMyNTYiLCJ0eX5".date("ymd"));

if($_SERVER['REQUEST_METHOD']=='OPTIONS') die();

$head = getallheaders();
// file_put_contents('udaa.txt', print_r($head, true), FILE_APPEND );

if(isset($head['Authorization'])){
	$token = $head['Authorization'];
}
else{
	if(isset($_GET['au-token'])){
		$token = $_GET['au-token'];
	}
	else{
		if(isset($_POST['au-token'])){
			$token = $_POST['au-token'];
		}
		else{
			require_once "echoErr.php";
			echoErr(  (object)[ 'error' => 'tokenator', 'code' => 401, 'message' => 'Unauthorized nema go'  ] );
			die();
		}
	}	
}
try{
	$decoded = JWT::decode($token	,$skey, ['HS256']);
}
catch(Exception $err) {
	echoErr(  (object)[ 'error' => 'tokenator', 'code' => 401, 'message' => 'Unauthorized, bad token!'  ] );
	die();
}	
// print_r($decoded);
return $decoded;
?>