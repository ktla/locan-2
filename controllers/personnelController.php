<?php

class personnelController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("civilite");
        $this->loadModel("fonction");
    }

    function index() {
        if (!isAuth(203)) {
            return;
        }
        $this->view->clientsJS("personnel" . DS . "personnel");

        $data = $this->Fonction->selectAll();
        $fonctions = new Combobox($data, "fonction", "IDFONCTION", "LIBELLE");
        $fonctions->first = "Toutes";
        $fonctions->onchange = "showPersonnelByFunction();";


        $data = $this->Personnel->selectAll();

        $personnels = new Grid($data, 0);
        $personnels->addcolonne(0, "IDPERSONNEL", "IDPERSONNEL", false);
        $personnels->addcolonne(1, "Civ", "CIVILITE");
        $personnels->addcolonne(2, "Matricule", "MATRICULE");
        $personnels->addcolonne(3, "Nom", "NOM");
        $personnels->addcolonne(4, "Prénom", "PRENOM");
        $personnels->addcolonne(5, "Fonction", "LIBELLE");
        $personnels->addcolonne(6, "Portable", "PORTABLE");
        $personnels->droitdelete = 507;
        $personnels->droitedit = 513;
        $personnels->dataTable = "tablePersonnel";
        $personnels->actionbutton = true;
        $personnels->deletebutton = true;
        $personnels->editbutton = true;
        $total = count($data);

        $this->Assign("content", (new View())->output(["fonctions" => $fonctions->view("50%"),
                    "personnels" => $personnels->display(),
                    "total" => $total
                        ], false));
    }

    /** Function ajax appellee quand on choisi une function, confere showPersonnelByFunction()
     * dans la methode index. Permet l'affichage du personnel en fonction du onchange dans la fonction
     */
    public function ajax() {
        $view = new View();
        if ($this->request->fonction != 0) {
            $personnels = $this->Personnel->findBy(["FONCTION" => $this->request->fonction]);
        } else {
            $personnels = $this->Personnel->selectAll();
        }

        $view->Assign("personnels", $personnels);
        $json_array[0] = $view->Render("personnel" . DS . "ajax" . DS . "listepersonnels", false);
        //$json_array[1] = $view->Render("personnel" . DS . "ajax" . DS . "ajax2", false);

        echo json_encode($json_array);
    }

    /**
     * 
     * CODEDROIT : 502
     */
    public function saisie() {
        if (!isAuth(502)) {
            return;
        }
        $this->view->clientsJS("personnel" . DS . "personnel");
        $view = new View();
        $view->Assign('errors', false);
        if (!empty($this->request->nom) && !empty($this->request->fonction) && !empty($this->request->portable)) {
            $generer = substr($this->request->nom, 0, strlen($this->request->nom)) . rand(0, 500);
            $params = [
                "civilite" => $this->request->civilite,
                "nom" => $this->request->nom,
                "prenom" => $this->request->prenom,
                "autrenom" => $this->request->autrenom,
                "fonction" => $this->request->fonction,
                "grade" => $this->request->grade,
                "datenaiss" => $this->request->datenaiss,
                "telephone" => $this->request->telephone,
                "portable" => $this->request->portable,
                "email" => $this->request->email
            ];

            if ($this->Personnel->insert($params)) {
                header("Location:" . url('personnel'));
            } else {
                $view->Assign("errors", true);
            }
        }

        $data = $this->Civilite->selectAll();
        $civilite = new Combobox($data, "civilite", "CIVILITE", "CIVILITE", true, "Mr");
        $view->Assign("civilite", $civilite->view("150px"));

        $data = $this->Fonction->selectAll();
        $fonctions = new Combobox($data, "fonction", "IDFONCTION", "LIBELLE");
        $view->Assign("fonctions", $fonctions->view());
        $content = $view->Render("personnel" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    /**
     * CODEDROIT : 507
     * @param type $id
     */
    public function delete($id) {
        if (!isAuth(507)) {
            return;
        }

        if ($this->Personnel->delete($id)) {
            header("Location:" . url('personnel'));
        } else {
            $this->Assign("content", (new View())->output(array("errors" => true), false));
        }
    }

    public function edit($id) {
        if (!empty($this->request->idpersonnel)) {
            $params = [
                "civilite" => $this->request->civilite,
                "nom" => $this->request->nom,
                "prenom" => $this->request->prenom,
                "autrenom" => $this->request->autrenom,
                "fonction" => $this->request->fonction,
                "grade" => $this->request->grade,
                "datenaiss" => $this->request->datenaiss,
                "telephone" => $this->request->telephone,
                "portable" => $this->request->portable,
                "email" => $this->request->email
            ];
            $this->Personnel->update($params, ["IDPERSONNEL" => $this->request->idpersonnel]);
            header("Location:" . Router::url("personnel"));
        }
        $this->view->clientsJS("personnel" . DS . "edit");
        $view = new View();
        $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $id]);
        $view->Assign("personnel", $personnel);

        $data = $this->Civilite->selectAll();
        $civilite = new Combobox($data, "civilite", "CIVILITE", "CIVILITE", true, $personnel['CIVILITE']);
        $view->Assign("civilite", $civilite->view());

        $data = $this->Fonction->selectAll();
        $fonctions = new Combobox($data, "fonction", "IDFONCTION", "LIBELLE", true, $personnel['FONCTION']);
        $view->Assign("fonctions", $fonctions->view());
        $content = $view->Render("personnel" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function fiche($id) {
        $view = new View();
        $content = $view->Render("personnel" . DS . "fiche", false);
        $this->Assign("content", $content);
    }

}
