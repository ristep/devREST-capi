<?php
	header("Content-type: application/json; charset=utf-8");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET,OPTIONS");
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');

	if(isset($_GET['cord'])) {
		$cord = $_GET['cord'];
	}
	else{
		$cord = "41.43306,22.01194";
	}
	
	$BASE_URL = "https://api.darksky.net/forecast/df1ef7c18a584d6aa345e7dafbc7a783/";
	$url = $BASE_URL . $cord;

  // Make call with cURL
  $session = curl_init($url);
  curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
  $json = curl_exec($session);
	
	echo '{ "darkurl": "' . $url . '", '; 
	echo '"darksky":' . $json;
	echo '}';
?>