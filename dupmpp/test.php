<?php
    $tst = json_encode( 
    "{
        'path':   '".print_r($path,true)."',
        'input':  '$input',
        'method': '$method'
    }");

    print_r(json_decode($tst));

    // echo 'Path = ';
    // print_r($path);
    // echo '\n\r';

    // echo 'Input = ';
    // print_r($input);
    // echo '/n/t';

    // echo 'Method =  ';
    // print($method);

    file_put_contents('testTST.txt',print_r($tst,true));

    var_dump($_SERVER);
 ?>