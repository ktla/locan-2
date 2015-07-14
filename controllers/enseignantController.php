<?php

class enseignantController extends Controller{
    public function __construct() {
        parent::__construct();
        $this->loadModel("personnel");
        $this->loadModel("eleve");
        $this->loadModel("classe");
    }
    public function index(){
        if(!isAuth(207)){
            return;
        }
        $this->view->clientsJS("enseignant" . DS . "index");
        $view = new View();
        $enseignants = $this->Personnel->findBy(["FONCTION" => 1]);
        $comboEnseignants = new Combobox($enseignants, "comboEnseignants", $this->Personnel->getKey(), ["NOM", "PRENOM"]);
        $comboEnseignants->first = " ";
        $view->Assign("comboEnseignants", $comboEnseignants->view());
        
        $content = $view->Render("enseignant" . DS . "index", false);
        $this->Assign("content", $content);
        
    }
    public function ajax(){
        $json = array();
        $view = new View();
        $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->idpersonnel]);
        $view->Assign("personnel", $personnel);
        
        $ens = $this->Personnel->getEnseignements($this->request->idpersonnel, $this->session->anneeacademique);
        $view->Assign("enseignements", $ens);
        
        $eleves = $this->Eleve->getElevesEnseignesPar($this->request->idpersonnel, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);
        
        $array_of_redoublants = $this->Classe->getRedoublantsByAnneeAcademique($this->session->anneeacademique, true);
        $view->Assign("array_of_redoublants", $array_of_redoublants);
        
        $json[0] = $view->Render("enseignant" . DS . "ajax" .DS . "onglet1", false);
        $json[1] = $view->Render("enseignant" . DS . "ajax" .DS . "onglet2", false);
        $json[2] = $view->Render("enseignant" . DS . "ajax" .DS . "onglet3", false);
        $json[3] = $view->Render("enseignant" . DS . "ajax" .DS . "onglet4", false);
        
        echo json_encode($json);
    }
    public function imprimer(){
         parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            case "0001":
                $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->idpersonnel]);
                $view->Assign("personnel", $personnel);
                
                $ens = $this->Personnel->getEnseignements($this->request->idpersonnel);
                $view->Assign("enseignements", $ens);
                echo $view->Render("enseignant" . DS . "impression" . DS . "fiche", false);
                break;
            case "0002":
                break;
        }
    }
    
    
}
