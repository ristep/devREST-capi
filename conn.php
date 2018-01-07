<?php
$servername = "localhost";
$username = "root";
$password = "90877";
$dbname = "apteka";

try {
    $conn = new PDO("mysql:host=$servername;charset=utf8;dbname=$dbname", $username, $password);
    // $conn->query("use apteka");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// echo "Connected successfully";
		//sleep(3);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

return $conn;
?>
