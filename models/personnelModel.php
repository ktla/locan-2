<?php

class personnelModel extends Model {

    protected $_table = "personnels";
    protected $_key = "IDPERSONNEL";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT p.*, CONCAT(p.NOM,' ', p.PRENOM) AS CNOM, f.LIBELLE as LIBELLE FROM personnels p "
                . "LEFT JOIN fonctions f ON f.IDFONCTION = p.FONCTION";
        return $this->query($query);
    }

    /* public function insert($params = array()){
      $query = "INSERT INTO personnels(IDPERSONNEL, CIVILITE, NOM, PRENOM, AUTRENOM, FONCTION, "
      . "GRADE, DATENAISS, PORTABLE, TELEPHONE) "
      . "VALUE(:id, :civilite, :nom, :prenom, :autrenom, :fonction, :grade, :datenaiss, :portable, :telephone)";

      return $this->query($query, $params);
      } */

    public function getLibelle() {
        return "CNOM";
    }

    public function findBy($condition = array()) {
        $str = "";
        $params = array();
        foreach ($condition as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT p.*, f.LIBELLE AS LIBELLE "
                . "FROM `" . $this->_table . "` p "
                . "LEFT JOIN fonctions f ON p.FONCTION = f.IDFONCTION "
                . "WHERE $str ";
        return $this->query($query, $params);
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT  p.*, CONCAT(p.NOM,' ', p.PRENOM) AS CNOM, f.LIBELLE as LIBELLE "
                . "FROM personnels p "
                . "LEFT JOIN fonctions f ON f.IDFONCTION = p.FONCTION "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    /**
     * Obetenir la liste des enseignements de ce personnel
     * Utilise dans enseignant/index onglet 2
     * Si anneeacad est non vide, alors renvoye tous ses enseignement aucours de toutes les annees
     * @param type $idpersonnel
     */
    public function getEnseignements($idpersonnel, $anneeacad = "") {
        if (!empty($anneeacad)) {
            $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, p.*, c.*, c.LIBELLE AS CLASSELIBELLE, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                    . "WHERE e.PROFESSEUR = :idpersonnel";
            return $this->query($query, ["idpersonnel" => $idpersonnel, "anneeacad" => $anneeacad]);
        } else {
            $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, p.*, c.*, c.LIBELLE AS CLASSELIBELLE, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                    . "WHERE e.PROFESSEUR = :idpersonnel";
            return $this->query($query, ["idpersonnel" => $idpersonnel]);
        }
    }

}
