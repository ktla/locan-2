<?php
class fraisController  extends Controller{
    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
    }
    
   
    public function index() {
        if(!isAuth(211)){
            return;
        }
        $this->view->clientsJS("frais" . DS . "frais");
        $view = new View();
        $frais = $this->Frais->getFrais($this->session->anneeacademique);
        $grid = new Grid($frais, 0);
        $grid->addcolonne(0, "IDFRAIS", "IDFRAIS", false);
        $grid->addcolonne(1, "CLASSE", "LIBELLE");
        $grid->addcolonne(2, "Description du frais", "DESCRIPTION");
        $grid->addcolonne(3, "MONTANT", "MONTANT");
        $grid->addcolonne(4, "ECHEANCES", "ECHEANCES");
        //510: Droit de suppression des frais scolaires
        if(isAuth(510)){
            $grid->actionbutton = true;
            $grid->deletebutton = true;
        }
        
        $view->Assign("frais", $grid->display());
        $content = $view->Render("frais" . DS . "index", false);
        $this->Assign("content", $content);
    }
    
    public function delete($id){
        $this->Frais->delete($id);
        header("Location:".Router::url("frais"));
    }

    function saisie() {
        if(!isAuth(509)){
            return;
        }
        $this->view->clientsJS("frais" . DS . "frais");
        $view = new View();
        
        $data = $this->Classe->findBy(["ANNEEACADEMIQUE" => $this->session->anneeacademique]);
        $comboClasses = new Combobox($data, "comboClasses", "IDCLASSE", "LIBELLE");
        $comboClasses->first = " ";
        $view->Assign("comboClasses", $comboClasses->view());
        $content = $view->Render("frais" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    function ajax($action) {
        $view = new View();
        $json = array();
        switch ($action) {
            case "ajouter":
                $params = ["DESCRIPTION" => $this->request->description, "MONTANT" => $this->request->montant,
                    "ECHEANCES" => $this->request->echeances, "CLASSE" => $this->request->idclasse];
                $this->Frais->insert($params);
                break;
            case "supprimer":
                $this->Frais->delete($this->request->idfrais);
                break;
            case "load":
                break;
            case "edit":
                $params = ["DESCRIPTION" => $this->request->description, "CLASSE" => $this->request->idclasse,
                    "ECHEANCES" => $this->request->echeances, "MONTANT" => $this->request->montant];
                $this->Frais->update($params, ["IDFRAIS" => $this->request->idfrais]);
                break;
        }
        $frais = $this->Frais->findBy(["CLASSE" => $this->request->idclasse]);
        $view->Assign("frais", $frais);
        $json[0] = $view->Render("frais" . DS . "ajax" . DS . "frais", false);
        echo json_encode($json);
    }
}
