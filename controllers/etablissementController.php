<?php

class etablissementController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("locan");
        $this->loadModel("personnel");
        $this->loadModel("eleve");
    }

    public function index() {
        if (!isAuth(201)) {
            return;
        }
        $this->view->clientsJS("etablissement" . DS . "index");
        $view = new View();


        $ets = $this->Locan->selectAll()[0];
        $view->Assign("ets", $ets['NOM']);
        $view->Assign("responsable", $ets['RESPONSABLE']);
        $view->Assign("adresse", $ets['ADRESSE']);
        $view->Assign("tel1", $ets['TELEPHONE']);
        $view->Assign("tel2", $ets['TELEPHONE2']);
        $view->Assign("mobile", $ets['MOBILE']);
        $view->Assign("email", $ets['EMAIL']);


        $data = $this->Personnel->selectAll();
        $personnels = new Grid($data, 2);
        $personnels->dataTable = "persoTable";
        $personnels->addcolonne(1, "Civ", "CIVILITE");
        $personnels->addcolonne(2, "Matricule", "IDPERSONNEL", false);
        $personnels->addcolonne(3, "Nom", "NOM");
        $personnels->addcolonne(4, "Prénom", "PRENOM");
        $personnels->addcolonne(5, "Fonction", "LIBELLE");
        $personnels->addcolonne(6, "Téléphone", "TELEPHONE");
        $personnels->actionbutton = false;
        $view->Assign("personnels", $personnels->display());


        $data = $this->Eleve->selectAll();

        $eleves = new Grid($data, 0);
        $eleves->dataTable = "eleveTable";
        $eleves->addcolonne(0, "IDELEVE", "IDELEVE", false);
        $eleves->addcolonne(1, "Matricule", "MATRICULE");
        $eleves->addcolonne(2, "Nom", "NOM");
        $eleves->addcolonne(3, "Prenom", "PRENOM");
        $eleves->addcolonne(4, "Sexe", "SEXE");
        $eleves->addcolonne(5, "Classe", "NIVEAUHTML");
        $eleves->addcolonne(6, "Naissance", "DATENAISS");
        $eleves->actionbutton = false;
        $eleves->setColDate(6);
        $view->Assign("eleves", $eleves->display());

        $content = $view->Render("etablissement" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function saisie() {
        if (!isAuth(501)) {
            return;
        }
        $view = new View();
        $view->Assign("errors", false);
        $message = "";
        $logo = "";
        if (!empty($this->request->identifiant) && !empty($this->request->nom) && !empty($this->request->adresse)) {
            //validation du logo
            if (isset($this->request->logo) && !empty($this->request->logo['tmp_name'])) {
                if (move_uploaded_file($this->request->logo['tmp_name'], ROOT . "/photos/" . $this->request->logo['name'])) {
                    $logo = SITE_ROOT . "photos/" . $this->request->logo['name'];
                } else {
                    $message = "Erreur lors de la sauvegarde du logo : " . $this->request->logo['name'];
                    return false;
                }
            }
            $params = ["identifiant" => $this->request->identifiant,
                "nom" => $this->request->nom,
                "adresse" => $this->request->adresse,
                "bp" => $this->request->bp,
                "tel1" => $this->request->tel1,
                "tel2" => $this->request->tel2,
                "mobile" => $this->request->mobile,
                "fax" => $this->request->fax,
                "email" => $this->request->email,
                "siteweb" => $this->request->siteweb,
                "responsable" => $this->request->responsable,
                "logo" => $logo
            ];
            //Insertion dans la BD
            $this->loadModel("locan");
            if ($this->Locan->insert($params)) {
                header("Location: " . Router::url("etablissement"));
            } else {
                $message = "Erreur lors de l'insertion";
            }
        }
        //Affichage du formulaire
        if (!empty($message)) {
            $view->Assign("errors", true);
        }
        $content = $view->Render("etablissement" . DS . "saisie", false);

        $this->Assign("content", $content);
    }

    public function imprimer() {
        parent::printable();
        $action = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);

        $eleves = $this->Eleve->selectAll();
        $view->Assign("eleves", $eleves);
        $personnels = $this->Personnel->selectAll();
        $view->Assign("personnels", $personnels);
        
        switch ($action) {
            case "0001":
                echo $view->Render("etablissement" . DS . "impression" . DS . "info", false);
                break;
            case "0002":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listesimpleeleves", false);
                break;
            case "0003":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listedetailleeleves", false);
                break;
            case "0004":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listesimplepersonnels", false);
                break;
            case "0005": 
                echo $view->Render("etablissement" . DS . "impression" . DS . "listedetaillepersonnels", false);
                break;
        }
    }

}
