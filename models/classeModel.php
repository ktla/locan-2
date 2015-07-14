<?php

class classeModel extends Model {

    protected $_table = "classes";
    protected $_key = "IDCLASSE";

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

        $query = "SELECT c.*, n.* "
                . "FROM `" . $this->_table . "` c "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    public function selectAll() {
        /* $query = "SELECT c.*, d.LIBELLE AS FK_DECOUPAGE FROM classes c "
          . "LEFT JOIN decoupage d ON c.DECOUPAGE = d.IDDECOUPAGE"; */
        $query = "SELECT c.* , d.LIBELLE AS FK_DECOUPAGE, n.* "
                . "FROM classes c "
                . "LEFT JOIN decoupage d ON c.DECOUPAGE = d.IDDECOUPAGE "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "WHERE c.ANNEEACADEMIQUE = :anneeacad "
                . "ORDER BY c.NIVEAU DESC";
        return $this->query($query, ['anneeacad' => $_SESSION['anneeacademique']]);
    }

    /**
     * 
     * @param type $idclasse
     * @param type $matric
     * @return typeSELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION 
      FROM eleves e
      INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND
      i.IDCLASSE = 1
      WHERE e.MATRICULE LIKE '155%'
      ORDER BY e.MATRICULE DESC LIMIT 1
     */
    public function findLastEleve($idclasse, $matric) {
        $matric = $matric . "%";
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND "
                . "i.IDCLASSE = :idclasse "
                . "WHERE e.MATRICULE LIKE :matric "
                . "ORDER BY e.MATRICULE DESC LIMIT 1";
        $params = ["idclasse" => $idclasse, "matric" => $matric];
        return $this->row($query, $params);
    }

    public function getLibelle() {
        return "LIBELLE";
    }

    /**
     * Obtenir les redoublant de n'importe quel classe pour cette annee academique
     * @param type $anneeacademique
     * @param type $ids_only si vrai, renvoye seulement les ID des eleve,
     * default false  renvoye les infos concernant l'eleve
     */
    public function getRedoublantsByAnneeAcademique($anneeacademique, $ids_only = false) {
                
        if ($ids_only === true) {
            $query = "SELECT e.IDELEVE "
                    . "FROM eleves e "
                    . "INNER JOIN classes c ON c.ANNEEACADEMIQUE = :anneeacad  "
                    . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE "
                    . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "WHERE IF((SELECT COUNT(i3.ANNEEACADEMIQUE) AS NBRE FROM inscription i3 "
                                . "WHERE i3.IDELEVE = e.IDELEVE) > 1, "
                                    . "(SELECT COUNT(i2.IDINSCRIPTION) FROM inscription i2 "
                                    . "WHERE i2.IDELEVE = i.IDELEVE) > 1 "
                    . "AND c.IDCLASSE IN (SELECT c2.IDCLASSE FROM classes c2 "
                                        . "INNER JOIN niveau n2 ON n2.IDNIVEAU = c2.NIVEAU "
                                        . "WHERE n2.GROUPE = n.GROUPE), e.REDOUBLANT = 1)";
            return $this->column($query, ["anneeacad" => $anneeacademique]);
        }else{
            # Pas encore implemente
            return null;
        }
    }

    /**
     * Renvoi la liste des eleves redoublant une classe de meme niveau
     * @param string $idclasse si vide, alors renvoye la liste des eleve redoublant quelque soit la classe de meme niveau
     * @param string $anneeacademique
     * @params boolean $ids_only faut-il renvoyer seulements les id des 
     * @return array contenant les eleves redoublant
     *
     */
    public function getRedoublants($idclasse, $anneeacademique = "", $ids_only = false) {
        if ($ids_only === true) {

            $query = "SELECT e.IDELEVE "
                    . "FROM eleves e "
                    . "INNER JOIN classes c ON c.IDCLASSE = :idclasse  "
                    . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE "
                    . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "WHERE IF((SELECT COUNT(i3.ANNEEACADEMIQUE) AS NBRE FROM inscription i3 "
                            . "WHERE i3.IDELEVE = e.IDELEVE) > 1, "
                            . "(SELECT COUNT(i2.IDINSCRIPTION) FROM inscription i2 "
                                    . "WHERE i2.IDELEVE = i.IDELEVE) > 1 "
                    . "AND c.IDCLASSE IN (SELECT c2.IDCLASSE FROM classes c2 "
                                            . "INNER JOIN niveau n2 ON n2.IDNIVEAU = c2.NIVEAU "
                                            . "WHERE n2.GROUPE = n.GROUPE), e.REDOUBLANT = 1)";

            $params = ["idclasse" => $idclasse];

            return $this->column($query, $params);
        } else {
            $query = "SELECT e.*, c.* "
                    . "FROM eleves e "
                    . "INNER JOIN classes c ON c.IDCLASSE = :idclasse AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE AND i.ANNEEACADEMIQUE = c.ANNEEACADEMIQUE "
                    . "WHERE ("
                    . "SELECT COUNT(i2.IDINSCRIPTION) FROM inscription i2 "
                    . "WHERE i2.IDELEVE = i.IDELEVE) > 1";

            $params = ["idclasse" => $idclasse];

            return $this->query($query, $params);
        }
    }

}
