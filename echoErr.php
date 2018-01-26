<?php

function echoErr($e){
	//file_put_contents('sqlError.dump', print_r($e->errorInfo,true)."\n", FILE_APPEND );
	if(isset($e->code))
		http_response_code($e->code);
	else	
		http_response_code('406');
	die(json_encode($e));}
?>