<?php

class EleveModel extends Model {

    protected $_table = "eleves";
    protected $_key = "IDELEVE";

    public function __construct() {
        parent::__construct();
    }

    public function select() {
        $query = "SELECT e.MATRICULE, CONCAT(e.NOM,' ',e.PRENOM) AS NOM "
                . "FROM eleves e ORDER BY NOM";
        return $this->query($query);
    }

    public function selectAll() {
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, "
                . "p.ETABLISSEMENT AS FK_PROVENANCE, m.LIBELLE AS FK_MOTIFSORTIE, p2.PAYS AS FK_NATIONALITE, "
                . "p3.PAYS AS FK_PAYSNAISS, "
                . "c.*, c.LIBELLE AS CLASSECOURANTE, "
                . "n.* "
                . "FROM eleves e "
                . "LEFT JOIN etablissements p ON p.IDETABLISSEMENT = e.PROVENANCE "
                . "LEFT JOIN motifsortie m ON m.IDMOTIF = e.MOTIFSORTIE "
                . "LEFT JOIN pays p2 ON p2.IDPAYS = e.NATIONALITE "
                . "LEFT JOIN pays p3 ON p3.IDPAYS = e.PAYSNAISS "
                . "LEFT JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacademique "
                . "LEFT JOIN  classes c "
                . "ON c.IDCLASSE = i.IDCLASSE AND i.IDELEVE = e.IDELEVE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "AND c.ANNEEACADEMIQUE = i.ANNEEACADEMIQUE "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "ORDER BY e.NOM";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], "anneeacademique" => $_SESSION['anneeacademique']]);
    }

    /**
     * @param type $params
     * @return type
     */
    public function insert($params = array()) {
        $query = "INSERT INTO eleves(MATRICULE, NOM, PRENOM, AUTRENOM, SEXE, PHOTO, CNI, NATIONALITE, "
                . "DATENAISS, LIEUNAISS, PAYSNAISS, DATEENTREE, PROVENANCE, REDOUBLANT) "
                . "VALUE(:matricule, :nom, :prenom, :autrenom, :sexe, :photo, :cni, :nationalite, :datenaiss, :lieunaiss, "
                . ":paysnaiss, :dateentree, :provenance, :redoublant)";

        return $this->query($query, $params);
    }

    public function findBy($condition = array()) {
        $str = "";
        $params = array();
        foreach ($condition as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT e.*, p.ETABLISSEMENT AS FK_PROVENANCE, m.LIBELLE AS FK_MOTIF, "
                . "p2.PAYS AS FK_NATIONALITE, p3.PAYS AS FK_PAYSNAISS "
                . "FROM eleves e "
                . "LEFT JOIN etablissements p ON p.IDETABLISSEMENT = e.PROVENANCE "
                . "LEFT JOIN motifsortie m ON m.IDMOTIF = e.MOTIFSORTIE "
                . "LEFT JOIN pays p2 ON p2.IDPAYS = e.NATIONALITE "
                . "LEFT JOIN pays p3 ON p3.IDPAYS = e.PAYSNAISS "
                . "WHERE $str "
                . "ORDER BY e.NOM";

        return $this->row($query, $params);
    }

    /**
     * Permet d'obtenir la liste des responsable de l'eleve passe en parametre
     * @param type $ideleve
     * @return type
     */
    public function getResponsables($ideleve) {
        $query = "SELECT r.*, re.* "
                . "FROM responsables r "
                . "LEFT JOIN responsable_eleve re ON re.IDRESPONSABLE = r.IDRESPONSABLE AND re.IDELEVE = :eleve "
                . "WHERE r.IDRESPONSABLE IN (SELECT e.IDRESPONSABLE "
                . "FROM responsable_eleve e "
                . "WHERE e.IDELEVE = :ideleve) ";
        return $this->query($query, ["eleve" => $ideleve, "ideleve" => $ideleve]);
    }

    /**
     * Permet d'obtenir la liste des responsable qui ne sont pas responsable de l'eleve passe en parametre
     * @param type $ideleve
     * @return type
     */
    public function getNonResponsables($ideleve) {
        $query = "SELECT r.* "
                . "FROM responsables r "
                . "WHERE r.IDRESPONSABLE NOT IN (SELECT e.IDRESPONSABLE "
                . "FROM responsable_eleve e WHERE e.IDELEVE = :ideleve)";
        return $this->query($query, ["ideleve" => $ideleve]);
    }

    /**
     * Renvoi le nombre des annee academique d'inscription d'une eleve pour cette meme classe
     * @param type $ideleve
     * @param type $idclasse si vide, alors renvoye le nbre de fois ou l'eleve s'est s'inscrit dans une classe
     * @return type colonne contenant les annee academique sous forme 2015-2016 dont le libelle est NBRE
     */
    public function nbInscription($ideleve, $idclasse = "") {
        if (empty($idclasse)) {
            $query = "SELECT i.ANNEEACADEMIQUE AS NBRE "
                    . "FROM inscription i "
                    . "WHERE i.IDELEVE = :ideleve "
                    . "ORDER BY i.ANNEEACADEMIQUE";
            $params = ["ideleve" => $ideleve];
        } else {
            $query = "SELECT i.ANNEEACADEMIQUE AS NBRE "
                    . "FROM inscription i "
                    . "INNER JOIN classes c ON c.IDCLASSE = i.IDCLASSE "
                    . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                    . "WHERE i.IDELEVE = :ideleve AND i.IDCLASSE = :idclasse "
                    . "AND c.IDCLASSE IN (SELECT c2.IDCLASSE FROM classes c2 "
                                          . "INNER JOIN niveau n2 ON c2.NIVEAU = n2.IDNIVEAU "
                                          . "WHERE n2.GROUPE = n.GROUPE)";
            $params = ["ideleve" => $ideleve, "idclasse" => $idclasse];
        }
        return $this->column($query, $params);
        
    }
    
    /*public function estRedoublant($ideleve, $idclasse = ""){
        $query = "SELECT COUNT(i.IDINSCRIPTION) AS NBRE "
                . "FROM inscription i "
                . "INNER JOIN classes c ON c.IDCLASSE = :idclasse AND c.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                . "WHERE i.IDELEVE = :ideleve AND c.IDCLASSE IN ("
                    . "SELECT c2.IDCLASSE FROM classes c2 "
                    . "INNER JOIN niveau n2 ON n2.IDNIVEAU = c2.NIVEAU "
                    . "WHERE n2.GROUPE = n.GROUPE) ";
        return $this->column($query, ["ideleve" => $ideleve, "idclasse" => $idclasse]);
    }*/

    /**
     * Renvoi les informations concernant la classe de l'eleve pour cette annee academique
     * Toute les informations
     * @param type $ideleve
     * @param type $anneeacademique
     */
    public function getClasse($ideleve, $anneeacademique) {
        $query = "SELECT c.*, n.* "
                . "FROM classes c "
                . "INNER JOIN inscription i ON i.IDCLASSE = c.IDCLASSE AND i.IDELEVE = :ideleve AND i.ANNEEACADEMIQUE = :anneeacad "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU ";
        return $this->row($query, ["ideleve" => $ideleve, "anneeacad" => $anneeacademique]);
    }
    
    /**
     * Obtenir la liste des eleves qui ont ete enseignee par idpersonnel 
     * aucours d'une periode donnees
     * quelque soir la classe,
     * Fonction utilise dans enseignant/index onglet 3
     * @param type $idpersonnel
     */
    public function getElevesEnseignesPar($idpersonnel, $anneeacad){
        $query = "SELECT e.*, c.*, n.* "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN classes c ON c.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "WHERE c.IDCLASSE IN (SELECT p.CLASSE FROM enseignements p WHERE p.PROFESSEUR = :idprof) "
                . "ORDER BY e.NOM";
        return $this->query($query, ["idprof" => $idpersonnel, "anneeacad" => $anneeacad]);
    }

}
