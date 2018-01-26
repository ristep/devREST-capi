<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

// print_r($_SERVER);

$skey = md5("FMyNTYiLCJ0eX5".date("ymd"));

if(isset($_SERVER['HTTP_AUTOKEN'])){
	$token = $_SERVER['HTTP_AUTOKEN'];
}		
else
if(isset($_GET['autoken'])){
	$token = $_GET['autoken'];
}
else
if(isset($_POST['autiken'])){
	$token = $_POST['autiken'];
}

$decoded = JWT::decode(	$token 	,$skey, ['HS256']);
											
print_r($decoded);
?>