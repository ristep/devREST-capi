<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$path   = explode("/", $_GET['path']);
$method = $_SERVER['REQUEST_METHOD'];
$input  = json_decode(file_get_contents("php://input"));

try{
    include 'servon/'.$path[0].'.php';
} catch(Exception $err) {
    print_r($err);
}
// file_put_contents('postraw.txt',print_r($_POST));
// file_put_contents('test.txt',print_r(file_get_contents("php://input"),true));
//print_r($path);
?>