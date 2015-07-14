<?php

class noteModel extends Model {

    protected $_table = "notes";
    protected $_key = "IDNOTE";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "NOTE";
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT n.*, el.*, en.*, tn.*, s.*, nt.* "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN notations nt ON nt.IDNOTATION = n.NOTATION "
                . "LEFT JOIN eleves el ON el.IDELEVE = n.ELEVE "
                . "LEFT JOIN enseignements en ON en.IDENSEIGNEMENT = nt.ENSEIGNEMENT "
                . "LEFT JOIN type_notes tn ON tn.IDTYPENOTE = nt.TYPENOTE "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = nt.SEQUENCE "
                . "WHERE $str "
                . "ORDER BY el.NOM";

        return $this->query($query, $params);
    }

    
    /**
     * 
     * @param type $idenseignement
     * @param type $idperiode
     * @param type $ideleve
     */
    public function getNoteByEnseignementByPeriodeByEleve($idenseignement, $idperiode, $ideleve){
        $query = "SELECT n.*, no.* "
                . "FROM notes n "
                . "INNER JOIN notations no ON no.IDNOTATION = n.NOTATION "
                    . " AND no.ENSEIGNEMENT = :idenseignement AND no.SEQUENCE = :sequence "
                . "WHERE n.ELEVE = :ideleve "
                . "ORDER BY no.TYPENOTE";
        $params = ["idenseignement" => $idenseignement, "sequence" => $idperiode, "ideleve" => $ideleve];
        return $this->query($query, $params);
    }
}
