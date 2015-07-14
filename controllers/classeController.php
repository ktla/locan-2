<?php

/**
 * http://uni-graz.at/~vollmanr/unicode/uni_letter_e.html
 * http://www.fileformat.info/info/unicode/char/1db0/index.htm
 * http://www.datatables.net/examples/api/tabs_and_scrolling.html
 */
class classeController extends Controller {

    public function __construct() {
        parent::__construct();
        /**
         * Charger les libraries utiliser dans cette classe
         */
        $this->loadModel("inscription");
        $this->loadModel("personnel");
        $this->loadModel("responsable");
        $this->loadModel("enseignement");
        $this->loadModel("classeparametre");
        $this->loadModel("matiere");
        $this->loadModel("groupe");
        $this->loadModel("niveau");
        $this->loadModel("eleve");
        $this->loadModel("frais");
    }

    public function index() {
        if (!isAuth(202)) {
            return;
        }
        $this->view->clientsJS("classe" . DS . "index");
        $view = new View();
        $data = $this->Classe->selectAll();
        $comboClasse = new Combobox($data, "comboClasses", "IDCLASSE", "LIBELLE");
        $comboClasse->first = " ";
        $view->Assign("comboClasses", $comboClasse->view());
        $content = $view->Render("classe" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function ajaxclasse() {
        $json = array();
        $view = new View();
        //Onglet 1
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);
        //Renvoyer un tableau contenant les id des eleve redoublant
        $array_of_redoublants = $this->Classe->getRedoublants($this->request->idclasse, $this->session->anneeacademique, true);
        $view->Assign("array_of_redoublants", $array_of_redoublants);

        $json[0] = $view->Render("classe" . DS . "ajax" . DS . "onglet1", false);
        //Onglet 2
        $enseignants = $this->Enseignement->getEnseignements($this->request->idclasse);
        $view->Assign("enseignants", $enseignants);
        $json[1] = $view->Render("classe" . DS . "ajax" . DS . "onglet2", false);
        //Onglet 3
        $json[2] = $view->Render("classe" . DS . "ajax" . DS . "onglet3", false);
        //Onglet 4, obtenir la liste de tous les frais
        $frais = $this->Frais->getClasseFrais($this->request->idclasse);
        $view->Assign("frais", $frais);


        $json[3] = $view->Render("classe" . DS . "ajax" . DS . "onglet4", false);
        $classe_parametre = $this->Classeparametre->findSingleRowBy(["CLASSE" => $this->request->idclasse]);
        $json[4] = $classe_parametre['NOMPERSONNEL'] . " " . $classe_parametre['PRENOMPERSONNEL'];
        $json[5] = $classe_parametre['NOMRESPONSABLE'] . " " . $classe_parametre['PRENOMRESPONSABLE'];
        $json[6] = $classe_parametre['NOMADMIN'] . " " . $classe_parametre['PRENOMADMIN'];
        $json[7] = count($eleves);
        echo json_encode($json);
    }

    private function showClasses() {
        $classes = $this->Classe->selectAll();
        $grid = new Grid($classes, 0);
        $grid->addcolonne(0, "ID", "IDCLASSE", false);
        $grid->addcolonne(1, "Code", "NIVEAUSELECT");
        $grid->addcolonne(2, "Libellé", "LIBELLE");
        $grid->addcolonne(3, "Découpage", "FK_DECOUPAGE");
        $grid->editbutton = true;
        $grid->deletebutton = true;
        $grid->droitedit = 517;
        $grid->droitdelete = 518;
        /* $this->Assign("content", (new View())->output(array("classes",
          $grid->display(),
          "errors", false), false)); */
        $view = new View();
        $view->Assign("classes", $grid->display());
        $view->Assign("errors", false);
        $view->Assign("total", count($classes));
        $content = $view->Render("classe" . DS . "showClasses", false);
        $this->Assign("content", $content);
    }

    public function saisie() {
        //505 Saisie des classes
        if (!isAuth(505)) {
            return;
        }
        $this->view->clientsJS("classe" . DS . "classe");
        if (isset($this->request->idclasse)) {
            //Faire un dernier update si on clique sur okay
            $params = ["LIBELLE" => $this->request->libelle, "DECOUPAGE" => $this->request->decoupage,
                "NIVEAU" => $this->request->niveau, "ANNEEACADEMIQUE" => $this->session->anneeacademique];
            if (!empty($this->request->idclasse)) {
                $this->Classe->update($params, ["IDCLASSE" => $this->request->idclasse]);
            } else {
                $this->Classe->insert($params);
            }
        }
        //202 Consultation des informations sur les classes
        if (!isset($this->request->saisie) && isAuth(202)) {
            $this->showClasses();
        } else {
            $view = new View();
            $view->Assign("errors", false);
            $this->loadModel("inscription");
            //Envoyer seulement la liste des eleves non inscrits pour cette periode academique
            $elevesnoninscrits = $this->Inscription->getNonInscrits($this->session->anneeacademique);
            $comboEleve = new Combobox($elevesnoninscrits, "listeeleve", "IDELEVE", "CNOM");
            $view->Assign("comboEleves", $comboEleve->view());

            $pers = $this->Personnel->selectAll();
            $comboEnseignants = new Combobox($pers, "listeenseignant", "IDPERSONNEL", "CNOM");
            $comboEnseignants->idname = "";
            $view->Assign("comboEnseignants", $comboEnseignants->view());

            $data = $this->Responsable->selectAll();
            $comboResponsables = new Combobox($data, "listeresponsable", "IDRESPONSABLE", "CNOM");
            $view->Assign("comboResponsables", $comboResponsables->view());

            $mat = $this->Matiere->selectAll();
            $comboMatieres = new Combobox($mat, "listematiere", "IDMATIERE", "LIBELLE");
            $view->Assign("comboMatieres", $comboMatieres->view());

            $niveau = $this->Niveau->selectAll();
            $comboNiveau = new Combobox($niveau, "niveau", "IDNIVEAU", "NIVEAUSELECT");
            $view->Assign("comboNiveau", $comboNiveau->view());

            $groupe = $this->Groupe->selectAll();
            $groupeCombo = new Combobox($groupe, "groupe", "IDGROUPE", "DESCRIPTION");
            $view->Assign("comboGroupe", $groupeCombo->view());

            $content = $view->Render("classe" . DS . "saisie", false);
            $this->Assign("content", $content);
        }
    }

    private function validateEdit() {
        //Faire un dernier update si on clique sur okay
        $params = ["LIBELLE" => $this->request->libelle, "DECOUPAGE" => $this->request->decoupage,
            "NIVEAU" => $this->request->niveau, "ANNEEACADEMIQUE" => $this->session->anneeacademique];
        $this->Classe->update($params, ["IDCLASSE" => $this->request->idclasse]);
        header("Location:" . Router::url("classe"));
    }

    public function edit($id) {
        $this->view->clientsJS("classe" . DS . "edit");
        if (!empty($this->request->idclasse)) {
            $this->validateEdit();
        }
        $view = new View();
        $view->Assign("errors", false);
        //Charger les model necessaire
        $this->loadModel("classeparametre");
        $this->loadModel("responsable");
        $this->loadModel("personnel");
        $this->loadModel("matiere");
        $this->loadModel("inscription");
        $this->loadModel("enseignement");
        $this->loadModel("decoupage");
        /**
         * Information sur la classe
         */
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $id]);
        $view->Assign("libelle", $classe['LIBELLE']);
        $this->loadModel("niveau");
        $niveau = $this->Niveau->selectAll();
        $comboNiveau = new Combobox($niveau, "niveau", "IDNIVEAU", "NIVEAUSELECT");
        $comboNiveau->selectedid = $classe['NIVEAU'];
        $view->Assign("comboNiveau", $comboNiveau->view());

        $data = $this->Decoupage->selectAll();
        $comboDecoupage = new Combobox($data, "decoupage", "IDDECOUPAGE", "LIBELLE", true, $classe["DECOUPAGE"]);
        $view->Assign("comboDecoupage", $comboDecoupage->view());
        $view->Assign("idclasse", $id);

        /**
         * Combo des eleves non encore inscrits
         */
        $elevesnoninscrits = $this->Inscription->getNonInscrits($this->session->anneeacademique);
        $comboEleve = new Combobox($elevesnoninscrits, "listeeleve", "IDELEVE", "CNOM");
        $view->Assign("comboElevesNonInscrits", $comboEleve->view());

        /**
         * Eleve deja inscrits dans cette classe a cette periode
         */
        $elevesInscrits = $this->Inscription->getInscrits($id, $this->session->anneeacademique);
        $view->Assign("elevesInscrits", $elevesInscrits);
        /**
         * Parametre de la classe, son prof principale, son administrateur principale
         * son cpe principale sous forme de variable dataTable if defined
         */
        $param = $this->Classeparametre->findSingleRowBy(["CLASSE" => $id]);
        //Prof Principale\
        $prof = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $param['PROFPRINCIPALE']]);
        $view->Assign("prof", $prof);
        //CPE principale
        $cpe = $this->Responsable->findSingleRowBy(["IDRESPONSABLE" => $param['CPEPRINCIPALE']]);
        $view->Assign("cpe", $cpe);
        //Administration principale
        $admin = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $param['RESPADMINISTRATIF']]);
        $view->Assign("admin", $admin);
        /**
         * Les des enseignants, personnels, et responsable pour les combobox
         */
        //Enseignant
        $pers = $this->Personnel->selectAll();
        $comboEnseignants = new Combobox($pers, "listeenseignant", "IDPERSONNEL", "CNOM");
        $view->Assign("comboEnseignants", $comboEnseignants->view());

        $pers2 = $this->Personnel->selectAll();
        $comboEnseignants2 = new Combobox($pers2, "listeenseignant2", "IDPERSONNEL", "CNOM");
        $view->Assign("comboEnseignants2", $comboEnseignants2->view());

        //Responsable
        $data = $this->Responsable->selectAll();
        $comboResponsables = new Combobox($data, "listeresponsable", "IDRESPONSABLE", "CNOM");
        $view->Assign("comboResponsables", $comboResponsables->view());

        //groupe
        $groupe = $this->Groupe->selectAll();
        $groupeCombo = new Combobox($groupe, "groupe", "IDGROUPE", "DESCRIPTION");
        $view->Assign("comboGroupe", $groupeCombo->view());

        //groupe2
        $groupe2 = $this->Groupe->selectAll();
        $groupeCombo2 = new Combobox($groupe2, "groupe2", "IDGROUPE", "DESCRIPTION");
        $view->Assign("comboGroupe2", $groupeCombo2->view());

        //Matiere
        $mat = $this->Matiere->selectAll();
        $comboMatieres = new Combobox($mat, "listematiere", "IDMATIERE", "LIBELLE");
        $view->Assign("comboMatieres", $comboMatieres->view());
        //Enseignements
        $ens = $this->Enseignement->getEnseignements($id);
        $view->Assign("enseignements", $ens);

        $view->Assign("message", "");
        $content = $view->Render("classe" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function ajax($zone) {
        $json = array();
        //Obtenir l'id de la classe lors du premier appel

        $params = ["LIBELLE" => $this->request->libelle,
            "DECOUPAGE" => $this->request->decoupage,
            "NIVEAU" => $this->request->niveau,
            "ANNEEACADEMIQUE" => $this->session->anneeacademique];

        if (empty($this->request->idclasse)) {
            $this->Classe->insert($params);
            $idclasse = $this->Classe->lastInsertId();

            $this->Classeparametre->insert(['CLASSE' => $idclasse]);
        } else {
            $this->Classe->update($params, ["IDCLASSE" => $this->request->idclasse]);
            $idclasse = $this->request->idclasse;
        }
        $json[0] = $idclasse;
        $view = new View();

        switch ($zone) {
            case "eleve":
                //Inscrire l'eleve dans  cette classe. Confere la methode inscrire de cette classe
                $elevesinscrits = $this->inscrire($idclasse);
                $view->Assign("eleves", $elevesinscrits);
                $json[1] = $view->Render("classe" . DS . "ajax" . DS . "eleve", false);

                //enlever de la liste les eleves deja inscrit
                $elevesnoninscripts = $this->Inscription->getNonInscrits($this->session->anneeacademique);
                $comboEleve = new Combobox($elevesnoninscripts, "listeeleve", "IDELEVE", "CNOM");
                $view->Assign("comboEleves", $comboEleve->view());
                $json[2] = $view->Render("classe" . DS . "ajax" . DS . "dialog-1", false);
                break;
            case "profprincipale":
                //Inserer le professeur principale
                $keys = ["CLASSE" => $idclasse];
                $this->Classeparametre->update(["PROFPRINCIPALE" => $this->request->identifiant], $keys);
                $prof = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->identifiant]);
                $view->Assign("prof", $prof);
                $json[1] = $view->Render("classe" . DS . "ajax" . DS . "profprincipale", false);
                $json[2] = SITE_ROOT . "public/img/btn_add_disabled.png";
                break;
            case "cpeprincipale":
                $keys = ["CLASSE" => $idclasse];
                $this->Classeparametre->update(["CPEPRINCIPALE" => $this->request->identifiant], $keys);
                $cpe = $this->Responsable->findSingleRowBy(["IDRESPONSABLE" => $this->request->identifiant]);
                $view->Assign("cpe", $cpe);
                $json[1] = $view->Render("classe" . DS . "ajax" . DS . "cpeprincipale", false);
                $json[2] = SITE_ROOT . "public/img/btn_add_disabled.png";
                break;
            case "adminprincipale":
                $keys = ["CLASSE" => $idclasse];
                $this->Classeparametre->update(["RESPADMINISTRATIF" => $this->request->identifiant], $keys);
                $admin = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->identifiant]);
                $view->Assign("admin", $admin);
                $json[1] = $view->Render("classe" . DS . "ajax" . DS . "adminprincipale", false);
                $json[2] = SITE_ROOT . "public/img/btn_add_disabled.png";
                break;
            case "ajoutmatiere":
                //Ajout enseignement
                $mat = json_decode($_POST['matiere']);
                $params = ["MATIERE" => $mat->matiere, "PROFESSEUR" => $mat->enseignant,
                    "CLASSE" => $idclasse, "GROUPE" => $mat->groupe, "COEFF" => $mat->coeff];
                $this->Enseignement->insert($params);
                $ens = $this->Enseignement->getEnseignements($idclasse);
                $view->Assign("enseignements", $ens);
                if ($_GET['url'] !== "classe/saisie") {
                    $json[1] = $view->Render("classe" . DS . "ajax" . DS . "editmatiere", false);
                } else {
                    $json[1] = $view->Render("classe" . DS . "ajax" . DS . "matiere", false);
                }
                $view->Assign("matieres", $this->Enseignement->getNonEnseignements($idclasse));
                $json[2] = $view->Render("classe" . DS . "ajax" . DS . "dialog-5", false);
                break;
            case "editenseignement":
                //edition enseignement
                $mat = json_decode($_POST['matiere']);

                $params = ["PROFESSEUR" => $mat->enseignant, "CLASSE" => $idclasse, "GROUPE" => $mat->groupe, "COEFF" => $mat->coeff];
                $this->Enseignement->update($params, ["IDENSEIGNEMENT" => $this->request->identifiant]);
                $ens = $this->Enseignement->getEnseignements($idclasse);
                $view->Assign("enseignements", $ens);
                if ($_GET['url'] !== "classe/saisie") {
                    $json[1] = $view->Render("classe" . DS . "ajax" . DS . "editmatiere", false);
                } else {
                    $json[1] = $view->Render("classe" . DS . "ajax" . DS . "matiere", false);
                }
                $view->Assign("matieres", $this->Enseignement->getNonEnseignements($idclasse));
                $json[2] = $view->Render("classe" . DS . "ajax" . DS . "dialog-5", false);
                break;
        }
        echo json_encode($json);
    }

    /**
     * 
     * @param type $idclasse l'identifiant de la classe dans laquelle il faut inscrire un eleve
     * les informations de l'eleve sont contenues dans la variable request de @type Request
     * @return type $eleves liste des eleves inscrit dans cette classe
     */
    private function inscrire($idclasse) {

        $params = ["IDELEVE" => $this->request->identifiant,
            "IDCLASSE" => $idclasse,
            "ANNEEACADEMIQUE" => $this->session->anneeacademique
        ];
        if ($this->Inscription->insert($params)) {
            $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $this->request->identifiant]);
            //Mettre a jour le matricule de l'eleve s'il n'avait pas de matricule
            if (empty($eleve['MATRICULE'])) {
                $matricule = $this->genererMatricule($idclasse);
                $this->Eleve->update(["MATRICULE" => $matricule], ['IDELEVE' => $this->request->identifiant]);
            }
        }
        //Retourne les eleves inscrits dans cette classe
        $eleves = $this->Inscription->getInscrits($idclasse, $this->session->anneeacademique);
        return $eleves;
    }

    /**
     * Implemente l'algorithme permettant de generer un matricule 
     * en fonction de la classe. 
     * @param type $idclasse
     * @return string
     */
    private function genererMatricule($idclasse) {
        //Retourne 15 dans le cas ou ANNEACADEMIQUE = 2014-2015
        $matric = substr($this->session->anneeacademique, -2);
        //Ajoute le niveau de la classe, Confere Table niveau et table classe
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $idclasse]);
        $this->loadModel("niveau");
        $niveau = $this->Niveau->findSingleRowBy(["IDNIVEAU" => $classe['NIVEAU']]);
        $matric .= $niveau['GROUPE'];
        //Ajoute le numero de l'eleve en faisant matricule du dernier eleve + 1

        $derniereleve = $this->Classe->findLastEleve($idclasse, $matric);
        //Si un dernier eleve existe alors concatener
        if ($derniereleve) {
            $matricule = intval($derniereleve['MATRICULE']) + 1;
        }
        //Si un dernier eleve n'existe, alors c'est le premier
        else {
            $matricule = intval($matric . "001");
        }
        return $matricule;
    }

    /**
     * Permet de supprimer le prof principale (action = 1), ou le 
     * cpe principale (action = 2) ou l'administrateur principale (action = 3)
     * Utilise avec ajax dans la page saisie classe
     * @param type $action
     */
    public function deletePrincipale() {
        $action = $this->request->action;

        $tableid = "";
        switch ($action) {
            case 1: $tableid = "tab_pp";
                break;
            case 2: $tableid = "tab_cpe";
                break;
            case 3: $tableid = "tab_ra";
                break;
        }
        $classparams = $this->Classeparametre->findSingleRowBy(["CLASSE" => $this->request->idclasse,
            "ANNEEACADEMIQUE" => $this->session->anneeacademique]);
        $this->Classeparametre->deletePrincipale($action, $classparams['IDPARAMETRE']);
        $view = new View();
        $view->Assign("tableid", $tableid);
        $json = array();
        $json[0] = $this->request->idclasse;
        $json[1] = $view->Render("classe" . DS . "ajax" . DS . "deleteprincipale", false);
        $json[2] = SITE_ROOT . "public/img/btn_add.png";
        echo json_encode($json);
    }

    //Supprime un enseignement de la page saisie enseignement via ajax
    public function deleteEnseignement() {
        $this->loadModel("enseignement");
        $this->Enseignement->delete($this->request->idenseignement);
        $view = new View();
        $json = array();
        $view->Assign("matieres", $this->Enseignement->getNonEnseignements($this->request->idclasse));
        $json[0] = $view->Render("classe" . DS . "ajax" . DS . "dialog-5", false);
        $ens = $this->Enseignement->getEnseignements($this->request->idclasse);
        $view->Assign("enseignements", $ens);
        if ($_GET['url'] !== "classe/saisie") {
            $json[1] = $view->Render("classe" . DS . "ajax" . DS . "editmatiere", false);
        } else {
            $json[1] = $view->Render("classe" . DS . "ajax" . DS . "matiere", false);
        }
        echo json_encode($json);
    }

    public function delete($id) {
        if ($this->Classe->delete($id)) {
            header("Location: " . Router::url("classe", "saisie"));
        } else {
            $this->Assign("content", (new View())->output(["errors" => true], false));
        }
    }

    public function imprimer() {
        parent::printable();
        $action = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);

        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $params = $this->Classeparametre->findSingleRowBy(["CLASSE" => $this->request->idclasse]);
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
        
        $view->Assign("params", $params);
        $view->Assign("eleves", $eleves);
        $view->Assign("classe", $classe);
        switch ($action) {
            case "0001":
                # Renvoyer un tableau contenant les id des eleve redoublant
                $array_of_redoublants = $this->Classe->getRedoublants($this->request->idclasse, $this->session->anneeacademique, true);
                $view->Assign("array_of_redoublants", $array_of_redoublants);
                echo $view->Render("classe" . DS . "impression" . DS . "listesimpleeleves", false);
                break;
        }
    }

}
