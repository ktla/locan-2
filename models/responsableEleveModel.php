<?php
class responsableEleveModel extends Model{
    protected  $_table = "responsable_eleve";
    protected  $_key = "IDRESPONSABLEELEVE";
    
    public function __construct() {
        parent::__construct();
    }
    public  function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        
        $query = "SELECT re.*, r.*, p.* "
                . "FROM `" . $this->_table . "` re "
                . "LEFT JOIN responsables r ON r.IDRESPONSABLE = re.IDRESPONSABLE "
                . "LEFT JOIN parente p ON p.LIBELLE = re.PARENTE "
                . "WHERE $str";
        return $this->row($query, $params);
    }
}
