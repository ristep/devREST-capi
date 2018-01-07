<?php
// aj za proba
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once "echoErr.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// header('Access-Control-Allow-Headers: X-PINGARUNER');
// header('Access-Control-Max-Age: 1728000');
// header("Content-Length: 0");

$qArr = array(); 
$where = "";

$path  = explode("/", $_GET['path']);
$method = $_SERVER['REQUEST_METHOD'];
parse_str($_SERVER['QUERY_STRING'], $qArr);

$ruti = parse_ini_file('routes.ini');

if( isset($ruti[$path[0]])){
    $pth = $ruti[$path[0]];
}else
    $pth = 'sql.ini/'.$path[0].'.ini';

try{
    if(file_exists($pth)){
        $slj = (object) parse_ini_file($pth);
    }else{
        echoErr(  (object)[ 'error' => 'inifile', 'code' => 404, 'message' => 'Not Found'  ] );
    }
} catch(Exception $err) {
    echoErr($err);
}

//var_dump($slj);

$input  = json_decode(file_get_contents("php://input"));

$cn = require "conn.php";

if(isset($path[1]))
{
    $kk = array();
    $i=0;
    foreach($slj->keyColumns as $fk){
        if(isset($path[++$i]))
            array_push($kk,"`$fk`='".$path[$i]."'");
        else
            array_push($kk,"`$fk`='".$input->$fk."'");
    }
    $where ="WHERE ".implode(' and ',$kk);
}

switch ($method) {
    case 'PUT': // update
        try {
            $ss = array();
            foreach($input as $pl => $vl) array_push($ss, "`$pl`='$vl'");

            $sql = "UPDATE `$slj->tableName` SET ".implode(',',$ss)." $where;";
            var_dump($sql);
            $cn->exec($sql);
        } catch (PDOException $e) { echoErr( $e ); }
    break;
    case 'POST': // new record
        try { 
            $ss = array();
            $lkk = array();
            foreach($input as $pl => $vl){
                array_push($ss,"`$pl`");
                array_push($lkk,"'$vl'");
            } 
            $sql = "INSERT INTO $slj->tableName(".implode(',',$ss).") VALUES (".implode(',',$lkk).");";
            $cn->exec($sql);
        } catch (PDOException $e) { echoErr( $e ); } 
    break;
    case 'GET':
				
				if( isset($slj->likeColumns) && isset($qArr["like"]) ) { 
					$zapata = " like '%".$qArr["like"]."%' or ";
					$lklString = str_replace( ',',$zapata,$slj->likeColumns ) . " like '%".$qArr["like"]."%' ";
					// print($lklString);		
				}

        if(isset($qArr["filter"])) 
            $filt = $qArr["filter"];
        if(isset($qArr["where"])) 
            $filt = $qArr["where"];
        if(isset($qArr["uslov"])) 
            $filt = $qArr["uslov"];
            
        if(isset($filt)){
            if($where!=""){
                $where .= " and $filt";
            }else{
                $where = " WHERE $filt";
            }
        }

				if(isset($lklString)){
					if($where!=""){
						$where .= " and ($lklString)";
					}else{
						$where = " WHERE $lklString";
					}
				}

        $order = "";
        if(isset($qArr["order"]))   $order = " order by ".$qArr["order"];
   
        $limit = "";
        if(isset($qArr["limit"]))   $limit = " limit ".$qArr["limit"];
		
				$sql = $slj->select." $where $order $limit";
				$count = "";
				if(isset($qArr["count"])){
					$sql = preg_replace("/(?<=select )(.*)(?= from )/i", "count(1) count", $sql);
				}					

				// echo $sql;die();
			
        try { 
            $sth = $cn->prepare($sql);
            $sth->execute();
						$result = $sth->fetchAll(PDO::FETCH_CLASS);
						//$result[$sth->rowCount()] = ["count" => $sth->rowCount(), "cuci" => 'Reserved']; 
            echo json_encode($result);
        } catch (PDOException $e) { echoErr( $e ); } 
    break;
    case 'DELETE':
        $sql = "DELETE FROM `$slj->tableName` $where;";
        $sth = $cn->prepare($sql);
        $sth->execute();
    break;
    default:
        try {
            throw new Exception('Undefined method '.$method);
        } catch (Exception $e) { echoErr( $e ); } 
    break;
}

// print_r($result);
// echo json_encode($data);