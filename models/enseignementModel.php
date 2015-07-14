<?php

class enseignementModel extends Model {

    protected $_table = "enseignements";
    protected $_key = "IDENSEIGNEMENT";

    public function __construct() {
        parent::__construct();
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);

        $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, "
                . "p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.*, n.* "
                . "FROM `" . $this->_table . "` e "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    public function getEnseignements($idclasse, $idgroupe = "") {
        if (empty($idgroupe)) {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                    . "FROM enseignements e "
                    . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "WHERE e.CLASSE = :classe "
                    . "ORDER BY m.LIBELLE";

            $params = ["classe" => $idclasse];
        } else {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                    . "FROM enseignements e "
                    . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "WHERE e.CLASSE = :classe AND e.GROUPE = :groupe "
                    . "ORDER BY m.LIBELLE";

            $params = ["classe" => $idclasse, "groupe" => $idgroupe];
        }
        return $this->query($query, $params);
    }

    /**
     * Obtenir la liste des matieres non enseigner dans cette classe
     * @param type $idclasse
     */
    public function getNonEnseignements($idclasse) {
        $query = "SELECT m.* FROM matieres m "
                . "WHERE m.IDMATIERE NOT IN (SELECT e.MATIERE "
                . "FROM enseignements e WHERE e.CLASSE = :idclasse) "
                . "ORDER BY m.LIBELLE";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

    /**
     * Renvoie tous les enseignement qui passe dans cette annee academique
     * @param type $anneeacad
     */
    public function getAllEnseignements($anneeacad) {
        $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                . "FROM enseignements e "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                . "ORDER BY e.IDENSEIGNEMENT";

        $params = ["anneeacad" => $anneeacad];
        return $this->query($query, $params);
    }

}
