<?php

class userModel extends Model{
  
    protected $_table = "users";
    protected  $_key = "LOGIN";
    public function __construct() {
        parent::__construct();
    }
    
    public function mesConnexions($compte){
        $query = "SELECT * FROM connexions WHERE COMPTE = :compte ORDER BY IDCONNEXION DESC";
        return $this->query($query, ["compte" => $compte]);
    }
       
}
