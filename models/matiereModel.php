<?php

class matiereModel extends Model {

    protected $_table = "matieres";
    protected $_key = "IDMATIERE";

    public function __construct() {
        parent::__construct();
    }
    
    public function insert($params = array()){
        $query = "INSERT INTO matieres(CODE, LIBELLE) "
                . "VALUE (:code, :libelle)"; 
       return $this->query($query, $params);
    }

    public function getLibelle(){
        return "LIBELLE";
    }
   
}
