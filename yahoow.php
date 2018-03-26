<?php
	header("Content-type: application/json; charset=utf-8");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET,OPTIONS");
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');

	if(isset($_GET['grad'])) {
		$grad = $_GET['grad'];
	}
	else{
		$grad = "kavadarci, mk";
	}
	
	$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
	$yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="' . $grad . '")';
  $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
  // Make call with cURL
  $session = curl_init($yql_query_url);
  curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
  $json = curl_exec($session);
  // Convert JSON to PHP object
  // $phpObj =  json_decode($json);
	// var_dump($phpObj);
	echo '{ "qurl": "' . $yql_query_url . '", '; 
	echo '"yahoow":' . $json;
	echo '}';
?>