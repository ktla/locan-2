<?php

class notationModel extends Model {

    protected $_table = "notations";
    protected $_key = "IDNOTATION";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMOYENNE, "
                . "e.*, tn.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, m.LIBELLE AS MATIERELIBELLE "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "LEFT JOIN type_notes tn ON tn.IDTYPENOTE = n.TYPENOTE "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT n.*, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMOYENNE, "
                
                . " e.*, tn.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, m.LIBELLE AS MATIERELIBELLE "
                . "FROM `" . $this->_table . "` n "
                . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN type_notes tn ON tn.IDTYPENOTE = n.TYPENOTE "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE "
                . "WHERE $str";
        return $this->row($query, $params);
    }
    /**
     * Obtient les information concernant des notation 
     * en se basant sur la matieres enseignees, utilise pour la methode note/statistique par matiere
     * 
     */
    public function getNotationsByMatieresByPeriode($idmatiere, $periode){
        $query = "SELECT n.*, "
                 . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION) AS NOTEMOYENNE, "
                
                . "c.*, c.LIBELLE AS CLASSELIBELLE, ni.*, "
                . "s.LIBELLE AS SEQUENCELIBELLE, p.* "
                . "FROM notations n "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE AND n.SEQUENCE = :sequence "
                . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT AND e.MATIERE = :idmatiere "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN niveau ni ON ni.IDNIVEAU = c.NIVEAU ";
        
        return $this->query($query, ['idmatiere' => $idmatiere, "sequence" => $periode]);
    }

}
