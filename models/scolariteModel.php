<?php

class scolariteModel extends Model{
    protected  $_table = "scolarites";
    protected  $_key = "IDSCOLARITE";
    
    public function __construct() {
       parent::__construct();
   }
   /**
    * Obtenir les scolarites payes de cet eleve
    * @param type $anneeacad
    */
   public function getScolarites($eleve, $anneeacad){
       $query = "SELECT s.*,s.MONTANT AS MONTANTPAYE, f.*, f.MONTANT as MONTANTFRAIS "
               . "FROM scolarites s "
               . "LEFT JOIN frais f ON f.IDFRAIS = s.FRAIS "
               . "WHERE s.ELEVE = :eleve AND s.ANNEEACADEMIQUE = :anneeacad "
               . "ORDER BY s.DATEPAYEMENT";
       return $this->query($query, ["eleve" => $eleve, "anneeacad" => $anneeacad]);
   }
   /**
    * Pour une operation caisse donnees, il retourne m
    * la somme des payement scolaire se basant sur cette operation caisse
    * @param type $idcaisse
    */
   public function getTotalByCaisse($idcaisse){
       $query = "SELECT SUM(s.MONTANT) AS TOTAL "
               . "FROM scolarites s "
               . "WHERE s.CAISSE = :caisse";
       return $this->row($query, ["caisse" => $idcaisse]);
   }
  
  
}
