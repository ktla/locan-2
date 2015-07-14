<?php

class trimestreModel extends Model{
    protected  $_table = "trimestres";
    protected $_key = "IDTRIMESTRE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
