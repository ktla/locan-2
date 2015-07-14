<?php

class emploisController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $data = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($data, "comboClasses", $this->Classe->getKey(), $this->Classe->getLibelle());
    }

    public function index() {
        
    }

    public function saisie() {
        $this->view->clientsJS("emplois" . DS . "emplois");

        $view = new View();

        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $content = $view->Render("emplois" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajax($action) {
        $json = array();
        $json[0] = "";
        $view = new View();
        $heure_de_cours = array(
            ["08:00", "08:55"],
            ["09:00", "09:55"],
            ["10:00", "11:05"],
            ["11:00", "12:00"],
            ["12:00", "12:55"],
            ["13:00", "13:55"],
            ["13:55", "14:50"],
            ["14:55", "15:50"],
            ["16:00", "16:55"],
            ["17:00", "17:55"]
        );
        $view->Assign("heure_de_cours", $heure_de_cours);
        $view->Assign("idselect", $this->comboClasses->idname);
        switch ($action) {
            case "charger":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("emplois" . DS . "ajax" . DS . "enseignement", FALSE);
                break;
            case "ajout":
                $params = ["jour" => $this->request->jour,
                    "idenseignement" => $this->request->idenseignement,
                    "heuredebut" => $this->request->heuredebut,
                    "heurefin" => $this->request->heurefin];
                $this->Emplois->insert($params);
                break;
            case "supprimer":
                $this->Emplois->delete($this->request->idemplois);
                break;
        }
        //dataTable de l'emploi du temps: Onglet 1
        $ens = $this->Emplois->getEmplois($this->request->idclasse);
        $view->Assign("enseignements", $ens);
        $json[1] = $view->Render("emplois" . DS . "ajax" . DS . "emplois", false);
        //apercu de l'emploi du temps: Onglet 2
        $json[2] = $view->Render("emplois" . DS . "ajax" . DS . "apercu", false);
        echo json_encode($json);
    }

}
