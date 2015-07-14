<?php

/**
 * PAGES AJAX : 800XX
 */
class EleveController extends Controller {

    private $comboCivilite;
    private $comboParente;

    public function __construct() {
        parent::__construct();
        /**
         * Chargement des libraries utilisees dans cette classes
         */
        $this->loadModel("pays");
        $this->loadModel('etablissement');
        $this->loadModel("civilite");
        $this->loadModel("responsable");
        $this->loadModel("charge");
        $this->loadModel("parente");
        $this->loadModel("motifsortie");
        $this->loadModel("responsableeleve");
        $this->loadModel("responsableEleve");
        $this->loadModel("anneeacademique");
        $this->loadModel("classe");

        $civ = $this->Civilite->selectAll();
        $this->comboCivilite = new Combobox($civ, "civilite", "CIVILITE", "CIVILITE");
        $this->comboCivilite->selectedid = "Mr";

        $par = $this->Parente->selectAll();
        $this->comboParente = new Combobox($par, "parente", "LIBELLE", "LIBELLE");
    }

    public function index() {
        if (!isAuth(204)) {
            return;
        }
        $view = new View();
        $this->view->clientsJS("eleve" . DS . "index");
        //Le model du dit controller est charger automatiquement
        //$this->Load_Model("eleve");

        $data = $this->Eleve->selectAll();
        $eleves = new Combobox($data, "listeeleve", "IDELEVE", "CNOM");
        $eleves->idname = "listeeleve";
        $eleves->first = " ";
        $view->Assign("eleves", $eleves->view());

        $content = $view->Render("eleve" . DS . "index", false);
        $this->Assign("content", $content);
    }

    private function showEleves() {
        $eleves = $this->Eleve->selectAll();
        $grid = new Grid($eleves, 0);
        $grid->addcolonne(0, "IDELEVE", "IDELEVE", false);
        $grid->addcolonne(1, "Matricule", "MATRICULE");
        $grid->addcolonne(2, "Nom et Pr&eacute;nom", "CNOM");
        $grid->addcolonne(3, "Sexe", "SEXE");
        $grid->addcolonne(4, "Date de Naiss.", "DATENAISS");
        $grid->setColDate(4);
        $grid->editbutton = true;
        $grid->deletebutton = true;

        $view = new View();
        $view->Assign("eleves", $grid->display());
        $view->Assign("errors", false);
        $view->Assign("total", count($eleves));
        $content = $view->Render("eleve" . DS . "showEleves", false);
        $this->Assign("content", $content);
    }

    /**
     * Methode appellee dans la validation du formulaire validateSaisie
     * Fonction deleguer de la function validate saisie
     * cette fonction gere le volet sauvegarde des informations  concernant les responsables
     * @param type $responsables des responsables sous formes d'un object JSON, ces responsables sont a inserer dans la BD
     * @param type $ideleve l'eleve dont ils sont les responsables
     */
    private function saveResponsables($resp, $ideleve = 0) {
        $this->loadModel("responsable");
        $this->loadModel("responsableeleve");
        $params = [
            "civilite" => $resp->civilite,
            "nom" => $resp->nom,
            "prenom" => $resp->prenom,
            "adresse" => $resp->adresse,
            "telephone" => $resp->telephone,
            "portable" => $resp->portable,
            "email" => $resp->email,
            "profession" => $resp->profession,
            "bp" => $resp->bp,
            "acceptesms" => isset($resp->acceptesms) ? 1 : 0,
            "numsms" => $resp->numsms
        ];
        if ($this->Responsable->insert($params)) {
            $params = [
                "idresponsable" => $this->Responsable->lastInsertId(),
                "ideleve" => $ideleve,
                "parente" => $resp->parente,
                "charges" => json_encode($resp->charge)
            ];
            $this->Responsableeleve->insert($params);
        }
    }

    public function saisie() {
        //S'il n'est pas autoriser a saisir et afficher les informations
        if (!isAuth(503) && !isAuth(204)) {
            return;
        }
        if (!isAuth(503) && isAuth(204)) {
            $this->showEleves();
            return;
        }
        //Effectuer une derniere mise a jour en cas modification
        if (isset($this->request->ideleve)) {
            $redoublant = (strcasecmp($this->request->redoublant, "Oui") == 0);
            $provenance = empty($this->request->provenance) ? null : $this->request->provenance;
            $params = ["matricule" => $this->request->matricule, "nom" => $this->request->nomel,
                "prenom" => $this->request->prenomel, "autrenom" => $this->request->autrenom,
                "sexe" => $this->request->sexe, "photo" => $this->request->photoeleve,
                "cni" => $this->request->cni, "nationalite" => $this->request->nationalite,
                "datenaiss" => $this->request->datenaiss, "lieunaiss" => $this->request->lieunaiss,
                "paysnaiss" => $this->request->paysnaiss, "dateentree" => $this->request->dateentree,
                "provenance" => $provenance, "redoublant" => $redoublant
            ];
            if (!empty($this->request->ideleve)) {
                $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
            } else {
                $this->Eleve->insert($params);
            }
            header("Location:" . Router::url("eleve"));
        }
        //202 Consultation des informations sur les eleves
        if (!isset($this->request->saisie) && isAuth(204)) {
            $this->showEleves();
        } else {
            $this->view->clientsJS("eleve" . DS . "eleve");
            $view = new View();

            $data = $this->Pays->selectAll();
            $paysnaiss = new Combobox($data, "paysnaiss", "IDPAYS", "PAYS");
            $nationalite = new Combobox($data, "nationalite", "IDPAYS", "PAYS");
            $view->Assign("paysnaiss", $paysnaiss->view());
            $view->Assign("nationalite", $nationalite->view());

            $data = $this->Etablissement->selectAll();
            $provenance = new Combobox($data, "provenance", "IDETABLISSEMENT", "ETABLISSEMENT");
            $provenance->first = " ";
            $view->Assign("provenance", $provenance->view());

            $view->Assign("civilite", $this->comboCivilite->view());

            $view->Assign("parente", $this->comboParente->view());
            $this->comboParente->name = "parenteextra";
            $this->comboParente->idname = "parenteextra";
            $view->Assign("parenteextra", $this->comboParente->view());

            $charges = $this->Charge->selectAll();
            $view->Assign("charges", $charges);

            $resp = $this->Responsable->selectAll();
            $comboResponsables = new Combobox($resp, "listeresponsable", "IDRESPONSABLE", "CNOM");
            $view->Assign("comboResponsables", $comboResponsables->view());

            $content = $view->Render("eleve" . DS . "saisie", false);
            $this->Assign("content", $content);
        }
    }

    /**
     * code ajax utiliser lors de la saisie d'un nouvel eleve
     * @param type $action
     */
    public function ajaxsaisie($action) {

        $provenance = empty($this->request->provenance) ? null : $this->request->provenance;
        $params = [
            "matricule" => $this->request->matricule,
            "nom" => $this->request->nomel,
            "prenom" => $this->request->prenomel,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "photo" => $this->request->photoeleve,
            "cni" => $this->request->cni,
            "nationalite" => $this->request->nationalite,
            "datenaiss" => $this->request->datenaiss,
            "lieunaiss" => $this->request->lieunaiss,
            "paysnaiss" => $this->request->paysnaiss,
            "dateentree" => $this->request->dateentree,
            "provenance" => $provenance,
            "redoublant" => $this->request->redoublant,
        ];
        if (!empty($this->request->ideleve)) {
            $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
            $ideleve = $this->request->ideleve;
        } else {
            $this->Eleve->insert($params);
            $ideleve = $this->Eleve->lastInsertId();
        }

        $json = array();
        $json[0] = $ideleve;
        $view = new View();
        switch ($action) {
            case "responsable":
                $responsables = json_decode($_POST['responsable']);
                $this->saveResponsables($responsables, $ideleve);
                $data = $this->Eleve->getResponsables($ideleve);
                $view->Assign("responsables", $data);
                $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
                break;
            case "oldresponsable":
                $resp = json_decode($_POST['responsable']);
                $params = [
                    "idresponsable" => $resp->idresponsable,
                    "ideleve" => $ideleve,
                    "parente" => $resp->parente,
                    "charges" => json_encode($resp->charges)
                ];
                $this->Responsableeleve->insert($params);
                $data = $this->Eleve->getResponsables($ideleve);
                $view->Assign("responsables", $data);
                $nonresp = $this->Eleve->getNonResponsables($ideleve);
                $view->Assign("nonresponsable", $nonresp);
                $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
                $json[2] = $view->Render("eleve" . DS . "ajax" . DS . "nonresponsable", false);
                break;
        }

        echo json_encode($json);
    }

    public function delete($id) {
        $this->Eleve->delete($id);
        header("Location:" . Router::url("eleve", "saisie"));
    }

    public function ajax() {
        $arr = array();
        $data = $this->Eleve->findBy(["IDELEVE" => $this->request->ideleve]);
        $view = new View();
        $view->Assign("nom", $data["NOM"]);
        $view->Assign("prenom", $data["PRENOM"]);
        $view->Assign("sexe", $data["SEXE"]);
        $view->Assign("datenaiss", $data["DATENAISS"]);
        $view->Assign("lieunaiss", $data["LIEUNAISS"]);
        $view->Assign("nationalite", $data["FK_NATIONALITE"]);
        $view->Assign("paysnaiss", $data["FK_PAYSNAISS"]);
        $view->Assign("dateentree", $data["DATEENTREE"]);
        $view->Assign("provenance", $data["FK_PROVENANCE"]);
        $view->Assign("datesortie", $data["DATENAISS"]);
        $view->Assign("motifsortie", $data["FK_MOTIF"]);
        !empty($data['PHOTO']) ? $view->Assign("photo", SITE_ROOT . "public/photos/eleves/" . $data['PHOTO']) : 
            $view->Assign("photo", "");
        
        $classe = $this->Eleve->getClasse($this->request->ideleve, $this->session->anneeacademique);
        $view->Assign("niveau", isset($classe['NIVEAUHTML']) ? $classe['NIVEAUHTML'] : "");
        $view->Assign("classe", isset($classe['LIBELLE']) ? $classe['LIBELLE'] : "");
        $view->Assign("redoublant", $this->estRedoublant($data['IDELEVE'], isset($classe['IDCLASSE']) ? $classe['IDCLASSE'] : ""));
        /**
         * ONGLET 2
         */
        $view->Assign("dataOnglet2", $this->Eleve->getResponsables($this->request->ideleve));
        
        $arr[0] = $view->Render("eleve" . DS . "ajax" . DS . "onglet1", false);
        $arr[1] = $view->Render("eleve" . DS . "ajax" . DS . "onglet2", false);
        $arr[2] = $view->Render("eleve" . DS . "ajax" . DS . "onglet3", false);
        $arr[3] = $view->Render("eleve" . DS . "ajax" . DS . "onglet4", false);
        $arr[4] = $view->Render("eleve" . DS . "ajax" . DS . "onglet5", false);
        $arr[5] = $view->Render("eleve" . DS . "ajax" . DS . "onglet6", false);
        print json_encode($arr);
    }

    //Utiliser dans la page saisie eleve et permet
    //d'uploader la photo sur le server et concerver 
    //le chemin dans un input hidden qui sera ensuite envoyer par le formulaire generale de l'eleve
    //0 pour premiere submission dont l'aaction est ajout
    //1 pour seconde soumission dont l'action est effacer
    public function photo($action) {
        $json_array = array();
        if (!strcmp($action, "upload")) {
            $photo = "";
            $message = "";
            if (move_uploaded_file($_FILES['photo']['tmp_name'], ROOT . "/public/photos/eleves/" . $_FILES['photo']['name'])) {
                $photo = SITE_ROOT . "public/photos/eleves/" . $_FILES['photo']['name'];
            } else {
                $message = "Erreur lors de la sauvegarde du fichier photo : " . $_FILES['photo']['name'];
            }

            if (!empty($photo)) {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoEleve();");
            } else {
                $json_array[0] = btn_add("savePhotoEleve();") . " " . btn_effacer_disabled("");
            }
            $json_array[1] = $photo;
            $json_array[2] = $message;
            $json_array[3] = $_FILES['photo']['name'];
        } else {
            if (file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $action)) {
                unlink(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $action);
                $json_array[0] = btn_add("savePhotoEleve();") . " " . btn_effacer_disabled("");
                $json_array[1] = "";
                $json_array[2] = "";
                $json_array[3] = "";
            } else {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoEleve();");
                $json_array[1] = $action;
                $json_array[2] = "Erreur lors de la suppression de l'image";
                $json_array[3] = "";
            }
        }
        print json_encode($json_array);
    }

    public function deleteResponsable() {
        $this->Responsableeleve->delete($this->request->idresponsableeleve);
        $json = array();
        $data = $this->Eleve->getResponsables($this->request->ideleve);
        $view = new View();
        $view->Assign("responsables", $data);
        $json[0] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
        $nonresponsable = $this->Eleve->getNonResponsables($this->request->ideleve);
        $view->Assign("nonresponsable", $nonresponsable);
        $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "nonresponsable", false);
        echo json_encode($json);
    }

    /**
     * FUNCTION POUR L'EDITION D'UN ELEVE
     */
    public function edit($id) {
        if (!empty($this->request->ideleve)) {
            $this->validerEdit();
        }
        $this->view->clientsJS("eleve" . DS . "edit");
        $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $id]);
        $view = new View();
        /**
         * Information sur l'eleve
         */
        $view->Assign("eleve", $eleve);
        //Pays de nationalite
        $pays = $this->Pays->selectAll();
        $comboNationalite = new Combobox($pays, "nationalite", $this->Pays->getKey(), $this->Pays->getLibelle());
        $comboNationalite->selectedid = $eleve['NATIONALITE'];
        $view->Assign("comboNationalite", $comboNationalite->view());
        //Pays de naissance
        $comboNaiss = new Combobox($pays, "paysnaiss", $this->Pays->getKey(), $this->Pays->getLibelle());
        $comboNaiss->selectedid = $eleve['PAYSNAISS'];
        $view->Assign("comboNaiss", $comboNaiss->view());
        //Motif sortie
        $motif = $this->Motifsortie->selectAll();
        $comboMotifSortie = new Combobox($motif, "motifsortie", $this->Motifsortie->getKey(), $this->Motifsortie->getLibelle());
        $comboMotifSortie->first = " ";
        $comboMotifSortie->selectedid = $eleve['MOTIFSORTIE'];
        $view->Assign("comboMotifSortie", $comboMotifSortie->view());
        //Provenance
        $etablissements = $this->Etablissement->selectAll();
        $comboProvenance = new Combobox($etablissements, "provenance", $this->Etablissement->getKey(), $this->Etablissement->getLibelle());
        $comboProvenance->selectedid = $eleve['PROVENANCE'];
        $view->Assign("comboProvenance", $comboProvenance->view());
        //Liste des responsable
        $responsables = $this->Eleve->getResponsables($id);
        $view->Assign("responsables", $responsables);
        //Combo des non responsables
        $nonresponsables = $this->Eleve->getNonResponsables($id);
        $view->Assign("nonresponsables", $nonresponsables);
        //Parente
        $view->Assign("parente", $this->comboParente->view());
        $this->comboParente->name = "parenteextra";
        $this->comboParente->idname = "parenteextra";
        $view->Assign("parenteextra", $this->comboParente->view());
        //Charge
        $charges = $this->Charge->selectAll();
        $view->Assign("charges", $charges);
        //Civilite
        $view->Assign("civilite", $this->comboCivilite->view());
        $content = $view->Render("eleve" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    /**
     * Effectue l'edition d'un eleve et appeller dans la methode edit
     */
    private function validerEdit() {
        $provenance = empty($this->request->provenance) ? null : $this->request->provenance;

        $params = ["matricule" => $this->request->matricule,
            "nom" => $this->request->nomel,
            "prenom" => $this->request->prenomel,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "photo" => $this->request->photoeleve,
            "cni" => $this->request->cni,
            "nationalite" => $this->request->nationalite,
            "datenaiss" => $this->request->datenaiss,
            "paysnaiss" => $this->request->paysnaiss,
            "lieunaiss" => $this->request->lieunaiss,
            "dateentree" => $this->request->dateentree,
            "provenance" => $provenance,
            "redoublant" => $this->request->redoublant,
            "datesortie" => $this->request->datesortie,
            "motifsortie" => $this->request->motifsortie];
        $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
        /**
         * Si tout s'est bien passer, rediriger vers la page eleve
         */
        header("Location:" . Router::url("eleve"));
    }

    /**
     * FUNCTION D'IMPRESSION
     */
    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            case "0001":
                $ideleve = $this->request->ideleve;
                $eleve = $this->Eleve->findBy(["IDELEVE" => $ideleve]);
                $view->Assign("eleve", $eleve);
                $classe = $this->Eleve->getClasse($ideleve, $this->session->anneeacademique);
                $view->Assign("classe", $classe);
                $view->Assign("redoublant", $this->estRedoublant($ideleve, isset($classe['IDCLASSE']) ? $classe['IDCLASSE'] : ""));
                
                $responsables = $this->Eleve->getResponsables($this->request->ideleve);
                $view->Assign("responsables", $responsables);
                echo $view->Render("eleve" . DS . "impression" . DS . "fiche", false);
                break;
            case "0002":
                break;
        }
    }

    /**
     * Renvoi vrai ou fait si cet eleve est redoublant dans cette classe
     */
    public function estRedoublant($ideleve, $idclasse) {
        /**
         * Si c'est la premiere annee de l'eleve, alors verifier dans la colonne REDOUBLANT
         * de la table eleve, sinon, obtenir le nombre de fois où il s'est inscrit dans cette classe
         */
        $nbInscription = $this->Eleve->nbInscription($ideleve);
         //S'il est entree durant cette annee academique, alors nbre d'inscription est egale a 1 ou 0
        if($nbInscription[0] <= 1){
            $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $ideleve]);
            return $eleve['REDOUBLANT'] === 1;
        }
        //Sinon, rechercher le nombre de fois ou il est inscrit dans cette meme classe
        //a different annee academique
        else {
            $array_of_redoublant = $this->Classe->getRedoublants($idclasse, $this->session->anneeacademique, true);
            if(!$array_of_redoublant){
                $array_of_redoublant = array();
            }
            if(in_array($ideleve, $array_of_redoublant)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function ajaxResponsable(){
        $view = new View();
        $resp = $this->Responsableeleve->findSingleRowBy(["IDRESPONSABLEELEVE" => $this->request->idresponsableeleve]);
        $view->Assign("responsable", $resp);
        print $view->Render("eleve" . DS . "ajax" . DS . "detailsresponsable", false);
    }
}
