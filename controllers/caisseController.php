<?php

class caisseController extends Controller{
    public function __construct() {
        parent::__construct();
    }
    /**
     * Code droit 512: Saisie d'une operation caise
     */
    public function saisie(){
        $this->view->clientsJS("caisse" . DS . "caisse");
        $view = new View();
        $content = $view->Render("caisse" . DS . "saisie", false);
        $this->Assign("content", $content);
    }
}
