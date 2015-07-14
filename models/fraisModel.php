<?php

class fraisModel extends Model {

    protected $_table = "frais";
    protected $_key = "IDFRAIS";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir les frais scolaire pour cette annee academique
     * @param varchar $anneeacad l'annee academique en cours
     */
    public function getFrais($anneeacad) {
        $query = "SELECT f.*, c.* "
                . "FROM frais f "
                . "LEFT JOIN classes c ON c.IDCLASSE = f.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }

    /**
     * Obtenir la liste des frais de l'eleve pour cette annee academique
     * @param type $eleve
     * @param type $anneeacad
     */
    public function getEleveFrais($eleve, $anneeacad) {
        $query = "SELECT f.* "
                . "FROM frais f "
                . "INNER JOIN inscription i "
                . "ON i.IDELEVE = :ideleve AND i.IDCLASSE = f.CLASSE AND i.ANNEEACADEMIQUE = :anneeacad "
                . "ORDER BY f.ECHEANCES";
        return $this->query($query, ["ideleve" => $eleve, "anneeacad" => $anneeacad]);
    }

    /**
     * Obtenir la liste des frais pour cette classe
     * @param type $idclasse
     */
    public function getClasseFrais($idclasse) {
        $query = "SELECT f.*, c.* "
                . "FROM frais f "
                . "LEFT JOIN classes c ON c.IDCLASSE = f.CLASSE "
                . "WHERE f.CLASSE = :idclasse "
                . "ORDER BY f.ECHEANCES";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

}
