<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once "conn.php";

$headers = apache_request_headers();
file_put_contents('headers.txt', print_r($headers,true));

class heroj {
    public $id;
    public $name;
}

//print_r( $_SERVER );
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
//print_r($request);
switch ($method) {
case 'PUT':
    //file_put_contents('put.txt',file_get_contents("php://input"));
    $b = json_decode(file_get_contents("php://input"));
    try {
      $sql = "UPDATE set SET `id`=$b->id,`latinicno_ime`='$b->latinicno_ime' WHERE `id`=$b->id;";
      //file_put_contents('insert.sql', $sql);
      $conn->exec($sql);
      //$conn->commit();
    }
    catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
    }
break;
case 'POST':
    $b = json_decode(file_get_contents("php://input"));
    try{
       $sql = "INSERT INTO heroi(name) VALUES ('$b->name');";
       $conn->exec($sql);
       $junak = new heroj();
       $junak->id = $conn->lastInsertId();
       $junak->name = $b->name;
       echo json_encode($junak);
       //file_put_contents('post.txt',print_r($junak,true));
    }
    catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
    }
    //do_something_with_post($request);
break;
case 'GET':
      if (isset($_SERVER['PATH_INFO'])) {
        $id = $request[0];
        if($id == 'top' ){
          $sql = "SELECT `id`, `name`, `rejting`, `stamina` FROM heroi order by stamina DESC limit ".$request[1];
          try {
            		$sth = $conn->prepare($sql);
            		$sth->execute();
            		$result = $sth->fetchAll(PDO::FETCH_CLASS, "heroj");
            		echo json_encode($result);
          }
          catch(PDOException $e){
              echo "Connection failed: " . $e->getMessage();
          }
        }else
        {
            $sql = "SELECT `id`, `name`, `rejting`, `stamina` FROM heroi WHERE `id`=$id";
            try {
            		$sth = $conn->prepare($sql);
            		$sth->execute();
            		$result = $sth->fetchObject();
            		echo json_encode($result);
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }
        }
      }
      else
      {
        $sql = "SELECT `id`, `name`,  `rejting`, `stamina` FROM heroi WHERE 1";
        try {
          		$sth = $conn->prepare($sql);
          		$sth->execute();
          		$result = $sth->fetchAll(PDO::FETCH_CLASS, "heroj");
          		echo json_encode($result);
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
      }
break;
case 'HEAD':
    //do_something_with_head($request);
break;
case 'DELETE':
    $sql = "DELETE FROM `heroi` WHERE `id`=".$request[0].";";
    $sth = $conn->prepare($sql);
    $sth->execute();
    //do_something_with_delete($request);
break;
  case 'OPTIONS':
    //do_something_with_options($request);
    break;
  default:
    //handle_error($request);
    break;
}

// print_r($result);
// echo json_encode($data);
?>
