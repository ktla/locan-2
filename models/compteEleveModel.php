<?php

class compteEleveModel extends Model{
    protected  $_table = "comptes_eleves";
    protected  $_key = "IDCOMPTE";
    
    public function __construct() {
        parent::__construct();
    }
}
