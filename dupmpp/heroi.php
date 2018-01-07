<?php
$cn = require "conn.php";

$tbl ='heroi';
$b = $input;
$keys = array('id');
$sqlS = "SELECT * FROM $tbl";

$kk = array();
$i=0;
foreach($keys as $fk){
    if(isset($path[++$i]))
        array_push($kk,"`$fk`='".$path[$i]."'");
    else
        array_push($kk,"`$fk`='".$b->$fk."'");
}
$where ="WHERE ".implode(' and ',$kk);

var_dump($where);

switch ($method) {
    case 'PUT': // update
        try {
            $ss = array();
            foreach($b as $pl => $vl) array_push($ss, "`$pl`='$vl'");

            $sql = "UPDATE `$tbl` SET ".implode(',',$ss)." $where;";
            var_dump($sql);
            $cn->exec($sql);
//talambasiranje utre
            //$sql = "UPDATE $tbl SET `name`=':name',`rejting`=':rejting',`stamina`=':stamina' WHERE `id`=':id';";
            //$stm = $cn->prepare($sql);
            //print_r($b);
            // foreach( $b as $key => $val){
            //    $stm->bindParam($key, $val, PDO::PARAM_STR); 
            // }
            // $stm->execute();
            
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        break;
    case 'POST': // new record
        try { 
            $ss = array();
            $lkk = array();
            foreach($b as $pl => $vl){
                array_push($ss,"`$pl`");
                array_push($lkk,"'$vl'");
            } 
            $sql = "INSERT INTO $tbl(".implode(',',$ss).") VALUES (".implode(',',$lkk).");";
            $cn->exec($sql);

            // $junak = new heroj();
            // $junak->id = $cn->lastInsertId();
            // $junak->name = $b->ime;
            // echo json_encode($junak);
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        break;
    case 'GET':
        if (isset($path[1])) {
            $id = $path[1];
            if ($id == 'top') {
                $sql = $sqlS."order by stamina DESC limit ".$path[2];
            } else {
                $sql = $sqlS." $where;";
            }
        } else {
            $sql = $sqlS;
        }
        try { 
            $sth = $cn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_CLASS);
            echo json_encode($result);
        } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
        break;
    case 'DELETE':
        $id=$path[1];
        $sql = "DELETE FROM `$tbl` $where;";
        $sth = $cn->prepare($sql);

        var_dump($sql,$b);
     
        $sth->execute();
        break;
    default:
        try {
            throw new Exception('Undefined method '.$method);
        } catch (Exception $e) {
            echo $e->getMessage();
            ;
        }
        break;
}

// print_r($result);
// echo json_encode($data);
