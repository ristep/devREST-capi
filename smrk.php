<?php
header("Content-type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');

require "vendor/autoload.php";

$Parsedown = new Parsedown();

echo $Parsedown->text(file_get_contents('https://raw.githubusercontent.com/ristep/vue-cv/master/README.md'));

?>