<?php
// http://www.phpbuilder.com/articles/application-architecture/security/using-a-json-web-token-in-php.html

$secret_key = 'AiSFMyNTYiLCJ0eXAiOiAiSldpansoft20234123';
$header_payload =  base64_encode('{"alg": "HS256","typ": "JWT"}') . '.' . base64_encode('{"name": "Octavia Anghel","email": "octaviaanghel@gmail.com"}');
$signature = base64_encode(hash_hmac('sha3-256', $header_payload, $secret_key, true));
$jwt_token = $header_payload . '.' . $signature;

echo $jwt_token;
?> 
