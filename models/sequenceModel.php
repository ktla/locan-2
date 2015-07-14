<?php

class sequenceModel extends Model{
    protected $_table = "sequences";
    protected  $_key = "IDSEQUENCE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
    
    /**
     * Retourne la liste des sequences pour cette anneee academique
     * @param type $anneeacad
     */
    public function getSequences($anneeacad){
        $query = "SELECT s.* "
                . "FROM sequences s "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE AND t.PERIODE = :anneeacad";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }
}
