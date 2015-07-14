<?php

class etablissementModel extends Model{
    protected  $_table = "etablissements";
    protected $_key = "IDETABLISSEMENT";


    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "ETABLISSEMENT";
    }
}
