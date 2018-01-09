<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$decoded = JWT::decode("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImp0aSI6ImRjYWIxMGEyLWY2YjQtNGJjMC05NTM0LTRmMjIwOTkyMmJiZCIsImlhdCI6MTUxNTQ0NTczNSwiZXhwIjoxNTE1NDQ5MzM1fQ.snqWnxD9tmfSEc8dkzBsG9WtP4krfDnyOVDIZS2yO_o"
											,"AiSFMyNTYiLCJ0eXAiOiAiSldpansoft20234123", ['HS256']);
											
print_r($decoded);
?>