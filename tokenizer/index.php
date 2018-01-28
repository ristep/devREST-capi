<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
$skey = md5("FMyNTYiLCJ0eX5".date("ymd"));

if($_SERVER['REQUEST_METHOD']=='OPTIONS') die();

if( $_SERVER['REQUEST_METHOD'] != 'POST'){
	require_once "../echoErr.php";
	echoErr(  (object)[ 'error' => 'inifile', 'code' => 400, 'message' => 'Bad Request'  ] );
}

$cn = require "../conn.php";
if(isset($_POST['name']) && $_POST['password']){
	$username = $_POST['name'];
	$password = $_POST['password'];
}
else{
	$input = json_decode(file_get_contents("php://input"));
	$username = $input->name;
	$password = $input->password;
}

file_put_contents('inputDump.txt', $username . ' ' . $password . "\n", FILE_APPEND );

try { 
	$sql = "select id,name,email,password,role from users where name=:name";
	$sth = $cn->prepare($sql);
  $sth->bindParam(':name', $username, PDO::PARAM_STR);
	$sth->execute();
	if( $sth->rowCount() < 1 ) {
		require_once "../echoErr.php";
		echoErr(  (object)[ 'error' => 'inifile', 'code' => 401, 'message' => 'Unauthorized nema go'  ] );
	}
	$result = $sth->fetch(PDO::FETCH_OBJ);

	// hashenbashen na passwordot
	if($password==$result->password){
		$token = array(
			"id" => $result->id,
			"name" => $result->name,
			"email" => $result->email,
			"role" => $result->role,
			'time' => date("ymdhhmmss"),
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
		echoErr(  (object)[ 'error' => 'inifile', 'code' => 401, 'message' => 'Unauthorized, de be daa..'  ] );
	}
} 
catch (PDOException $e) { 
	echoErr( $e ); 
} 

?>