<?php

class scolariteController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("inscription");
        $this->loadModel("frais");
        $this->loadModel("compteeleve");
        $this->loadModel("caisse");
        $this->loadModel("personnel");
        
    }

    public function index() {
        
    }

    function payement() {
        $this->view->clientsJS("scolarite" . DS . "scolarite");
        $view = new View();
        $eleves = $this->Inscription->getAllInscrits($this->session->anneeacademique);
        $comboEleves = new Combobox($eleves, "comboEleves", "IDELEVE", "CNOM");
        $comboEleves->first = " ";
        $view->Assign("comboEleves", $comboEleves->view());
        $content = $view->Render("scolarite" . DS . "payement", false);
        $this->Assign("content", $content);
    }

    public function ajax($action) {
        $view = new View();
        $json = array();
        $compte = $this->Compteeleve->findSingleRowBy(["ELEVE" => $this->request->eleve]);
        switch ($action) {
            case "supprimer":
                $this->Scolarite->delete($this->request->idscolarite);
                break;
            case "charger":
                //Frais dont l'eleve doit payer
                $frais = $this->Frais->getEleveFrais($this->request->eleve, $this->session->anneeacademique);
                $view->Assign("frais", $frais);
                $json[1] = $view->Render("scolarite" . DS . "ajax" . DS . "comboFrais", false);
                $caisses = $this->Caisse->findBy(["COMPTE" => $compte['IDCOMPTE']]);
                $view->Assign("caisses", $caisses);
                $json[2] = $view->Render("scolarite" . DS . "ajax" . DS . "comboCaisses", false);
                break;
            case "ajout":
                $frais = $this->Frais->findSingleRowBy(["IDFRAIS" => $this->request->idfrais]);
                //Rechercher le montant lie a cette operation caisse
                $caisse = $this->Caisse->findSingleRowBy(['IDCAISSE' => $this->request->idcaisse]);
                /**
                 * Rechercher tous le total des payement se basant sur cette operation caisse
                 */
                $total = $this->Scolarite->getTotalByCaisse($this->request->idcaisse);
                /**
                 * definir le montant du payement = montant de l'operation caisse - montant total des scolarite se basant
                 * sur cette operation caisse
                 */
                
                $montantscolarite = intval($caisse['MONTANT']) - intval($total['TOTAL']);
                if ($montantscolarite == 0) {
                    $json[1] = $caisse['MONTANT'];
                } else {
                    $montant = $montantscolarite < $frais['MONTANT'] ? $montantscolarite : $frais['MONTANT'];
                    $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);
                    
                    $params = ["eleve" => $this->request->eleve, "frais" => $this->request->idfrais, 
                        "montant" => $montant,
                        "datepayement" => date("Y-m-d", time()), "anneeacademique" => $this->session->anneeacademique,
                        "realiserpar" => $personnel['IDPERSONNEL']];
                    $this->Scolarite->insert($params);
                    //Debiter le compte
                    $json[1] = '';
                }
                break;
        }
        $scolarites = $this->Scolarite->getScolarites($this->request->eleve, $this->session->anneeacademique);
        $view->Assign("scolarites", $scolarites);
        $json[0] = $view->Render("scolarite" . DS . "ajax" . DS . "scolarite", false);
        echo json_encode($json);
    }

}
