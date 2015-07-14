<?php

class emploisModel extends Model{
    protected $_table = "emplois";
    protected  $_key = "IDEMPLOIS";
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Renvoi les information concernant 
     * l'emploi du temps de cette classe
     * @param type $idclasse
     */
    public function getEmplois($idclasse){
        $query = "SELECT e.*, m.*, p.* "
                . "FROM emplois e "
                . "INNER JOIN enseignements ee ON ee.CLASSE = :idclasse AND ee.IDENSEIGNEMENT = e.IDENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = ee.MATIERE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = ee.PROFESSEUR "
                . "ORDER BY e.HEUREDEBUT";
        return $this->query($query, ["idclasse" => $idclasse]);
    }
    /**
     * Recherche les enseignements prevu par l'emploi du temps pour ce jour
     * et le classe donnees
     * @param type $jour
     * @param type $classe
     */
    public function getEnseignements($jour, $classe){
        $query = "SELECT e.*, m.* "
                . "FROM emplois e "
                . "INNER JOIN enseignements ee ON ee.CLASSE = :classe AND ee.IDENSEIGNEMENT = e.IDENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = ee.MATIERE "
                . "WHERE e.JOUR = :jour";
        return $this->query($query, ["jour" => $jour, "classe" => $classe]);
    }
}
