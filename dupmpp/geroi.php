<?php
class Reto{
    public $tableName;
    public $keyNames;
    public $keyVals;
    public $select;
    public $input;

    function __construct($table,$keyns,$sel){
        $this->tableName = $table;
        $this->keyNames = $keyns;
        $this->select = $sel;
    }

    static function loadFile($file){
        $instance = new self();
        $ini = parse_ini_file($file);
        
        $instance->fill( $row );
        return $instance;
    }        
}

return new Reto(
    'heroi',
    array('id'),
    "SELECT * FROM `heroi`"
);
