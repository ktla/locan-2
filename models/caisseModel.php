<?php

class caisseModel extends Model{
    protected $_table = "caisses";
    protected  $_key = "IDCAISSE";
    
    public function __construct() {
        parent::__construct();
    }

}
