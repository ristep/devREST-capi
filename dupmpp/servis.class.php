<?php
class ServisIni{
    public $tableName;
    public $keyNames;
    public $keyVals;
    public $select;
    public $input;

    static function initFile($file){
        return (object) parse_ini_file($file);
    }        
}

    // function __construct($table,$keyns,$sel){
    //     $this->tableName = $table;
    //     $this->keyNames = $keyns;
    //     $this->select = $sel;
    // }

    //$slj = ServisIni::initFile( 'sql.ini/'.$path[0].'.ini' );
