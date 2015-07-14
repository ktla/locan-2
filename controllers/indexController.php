<?php

class IndexController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $view = new View();

        $str = "Utilisateur connect&eacute; : " . $_SESSION['user'] . 
                "/".$_SESSION['profile']."/IPW ".$_SESSION['anneeacademique'];
        $view->Assign("infos", $str);
        
        
        $content = $view->Render("index" . DS . "index", false);

        
        $this->Assign("content", $content);
    }

    /**
      Methode a argument variable
     */
    public function methode($query1 = "", $query2 = "") {
        echo $query1 . " " . $query2;
    }

}
