<?php

function echoErr($e){
	http_response_code($e->code);
	die(json_encode($e));
}

?>