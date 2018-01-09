<?php
require "vendor/autoload.php";
use \Firebase\JWT\JWT;

$decoded = JWT::decode("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImp0aSI6ImRjYWIxMGEyLWY2YjQtNGJjMC05NTM0LTRmMjIwOTkyMmJiZCIsImlhdCI6MTUxNTQ0NTczNSwiZXhwIjoxNTE1NDQ5MzM1fQ.cJeFx3EZ1LMPOpK8cw_earBt2EIuL4leZkJZBBiaqwI","secret", ['HS256']);

print_r($decoded);

?>