<?php

class bulletinModel extends Model{
    protected $_table = "";
   
    public function __construct() {
        parent::__construct();
    }
    /**
     * Retourne des enregistrements correspondant aux ligne des bulletin 
     * pour cette classe, cet eleve a cette sequence
     * @param type $idclasse
     * @param type $ideleve
     * @param type $idsequence
     * @param int $idgroupe filtrer par groupe, $idgroupe est le groupe auxquel apartient la matiere
     */
    public function getSequenceNotes($idclasse, $ideleve, $idsequence, $idgroupe){
        /*$query = "SELECT ens.*, mat.*, prof.*, g.DESCRIPTION AS GROUPELIBELLE "
                . "FROM enseignements ens "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "INNER JOIN personnels prof ON prof.IDPERSONNEL = ens.PROFESSEUR "
                . "INNER JOIN groupe g ON g.IDGROUPE = ens.GROUPE "
                . "WHERE ens.CLASSE = :idclasse AND ens.GROUPE = :idgroupe";
        */
        
        $query = "SELECT n.*";
        $params = ["idclasse" => $idclasse, "idgroupe" => $idgroupe];
        return $this->query($query, $params);
    }
    
    public function getTrimestreNotes($idclasse, $ideleve, $idtrimestre){
        
    }
}

