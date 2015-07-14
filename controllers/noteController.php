<?php

/**
 * 407: Modification des notes
 * 401: Saisie des notes
 * 409: Suppression des notes d'eleves
 * 212: Affichage des note
 * 408: Verrouillage et deverouillage des notes
 */
class noteController extends Controller {

    private $comboClasses;
    private $comboPeriodes;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("typenote");
        $this->loadModel("sequence");
        $this->loadModel("enseignement");
        $this->loadModel("inscription");
        $this->loadModel("notation");
        $this->loadModel("personnel");
        $this->loadModel("matiere");

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), $this->Classe->getLibelle());

        $periode = $this->Sequence->getSequences($this->session->anneeacademique);
        $this->comboPeriodes = new Combobox($periode, "comboPeriodes", $this->Sequence->getKey(), $this->Sequence->getLibelle());
        $this->comboPeriodes->first = " ";
    }

    public function index() {
        $this->view->clientsJS("note" . DS . "index");
        $view = new View();
        $this->comboPeriodes->first = "Ann&eacute;e acad&eacute;mique";
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $enseignements = $this->Enseignement->getAllEnseignements($this->session->anneeacademique);
        $comboEnseignements = new Combobox($enseignements, "comboEnseignements", $this->Enseignement->getKey(), ["MATIERELIBELLE", "CLASSELIBELLE"]);
        $comboEnseignements->first = "Toutes";
        $view->Assign("comboEnseignements", $comboEnseignements->view());

        $notations = $this->Notation->selectAll();
        $view->Assign("notations", $notations);

        $tableNotes = $view->Render("note" . DS . "ajax" . DS . "tableNotes", false);

        $view->Assign("tableNotes", $tableNotes);
        $content = $view->Render("note" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function validerSaisie() {
        if (isset($this->request->deja)) {
            header("Location:" . Router::url("note"));
        }
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);

        $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);

        $datedevoir = empty($this->request->datedevoir) ? date("Y-m-d", time()) : $this->request->datedevoir;
        $params = ["enseignement" => $this->request->idenseignement,
            "typenote" => $this->request->typenote,
            "description" => $this->request->description,
            "notesur" => $this->request->notesur,
            "sequence" => $this->request->sequence,
            "datejour" => date("Y-m-d", time()),
            "datedevoir" => $datedevoir,
            "realiserpar" => $personnel['IDPERSONNEL']
        ];

        $this->Notation->insert($params);
        $idnotation = $this->Notation->lastInsertId();
        foreach ($eleves as $el) {
            $note = $this->request->{"note_" . $el['MATRICULE']};
            $ideleve = $el['IDELEVE'];
            //1 = absent, 0 = present
            $absent = 0;
            if (isset($this->request->{"absent_" . $el['MATRICULE']}) && $this->request->{"absent_" . $el['MATRICULE']} === "on") {
                $absent = 1;
            }
            $observation = $this->request->{"observation_" . $el['MATRICULE']};

            $params = ["note" => $note,
                "notation" => $idnotation,
                "eleve" => $ideleve,
                "absent" => $absent,
                "observation" => $observation];
            $this->Note->insert($params);
        }
        header("Location:" . Router::url("note", "report"));
    }

    public function saisie() {
        if (!isAuth(401)) {
            return;
        }
        if (!empty($this->request->idenseignement)) {
            $this->validerSaisie();
        }
        $this->view->clientsJS("note" . DS . "note");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $types = $this->Typenote->selectAll();
        $comboTypes = new Combobox($types, "comboTypes", $this->Typenote->getKey(), $this->Typenote->getLibelle());
        $comboTypes->first = " ";
        $view->Assign("comboTypes", $comboTypes->view());
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("note" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajax() {
        $view = new View();
        $json = array();
        $action = $this->request->action;
        switch ($action) {
            case "chargerMatieres":
                $matieres = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("matieres", $matieres);
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "comboMatieres", false);
                break;
            case "chargerCoeff":
                $ens = $this->Enseignement->findSingleRowBy(["IDENSEIGNEMENT" => $this->request->idenseignement]);
                $json[0] = $ens['COEFF'];
                break;
            case "chargerEleves":
                # Verifier si une saisie avait ete effectue, si oui, proposer la modification des notes
                $notes = $this->Note->findBy(["ENSEIGNEMENT" => $this->request->idenseignement,
                    "TYPENOTE" => $this->request->typenote,
                    "sequence" => $this->request->sequence]);
                # echo $this->request->typenote;
                if (count($notes) > 0 && $this->request->typenote != 3) {
                    $view->Assign("notes", $notes);
                    $view->Assign("deja", true);
                    $view->Assign("notation", $notes[0]['NOTATION']);
                } else {
                    $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                    $view->Assign("eleves", $eleves);
                    $view->Assign("deja", false);
                }
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "listeeleves", false);

                break;
        }
        echo json_encode($json);
    }

    public function recapitulatif() {
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());
        
        $content = $view->Render("note" . DS . "recapitulatif", false);
        $this->Assign("content", $content);
    }


    public function edit($id) {
        if (!isAuth(407)) {
            return;
        }
        if (!empty($this->request->notation)) {
            $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
            foreach ($eleves as $el) {
                $note = $this->request->{"note_" . $el['MATRICULE']};
                $idnote = $this->request->{"id_" . $el['MATRICULE']};
                //1 = absent, 0 = present
                $absent = 0;
                if (isset($this->request->{"absent_" . $el['MATRICULE']}) && $this->request->{"absent_" . $el['MATRICULE']} === "on") {
                    $absent = 1;
                }
                $observation = $this->request->{"observation_" . $el['MATRICULE']};

                $params = ["note" => $note,
                    "absent" => $absent,
                    "observation" => $observation];
                $this->Note->update($params, ["IDNOTE" => $idnote]);
            }
            header("Location:" . Router::url("note"));
        }
        $this->view->clientsJS("note" . DS . "edit");
        $view = new View();
        $notes = $this->Note->findBy(["NOTATION" => $id]);
        $notation = $this->Notation->findSingleRowBy(["IDNOTATION" => $id]);
        $view->Assign("notation", $notation);
        $view->Assign("notes", $notes);
        $content = $view->Render("note" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function verrouillage() {
        $view = new View();
        $content = $view->Render("note" . DS . "verrouillage", FALSE);
        $this->Assign("content", $content);
    }

    public function statistique() {
        $view = new View();


        $this->view->clientsJS("note" . DS . "statistique");
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $matieres = $this->Matiere->selectAll();
        $comboMatieres = new Combobox($matieres, "comboMatieres", $this->Matiere->getKey(), $this->Matiere->getLibelle());
        $comboMatieres->first = " ";
        $view->Assign("comboMatieres", $comboMatieres->view());
        
        $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
        $comboPeriode = new Combobox($sequences, "comboPeriodes", $this->Sequence->getKey(), $this->Sequence->getLibelle());
        $view->Assign("comboPeriodes", $comboPeriode->view());
        
        $content = $view->Render("note" . DS . "statistique", false);


        $this->Assign("content", $content);
    }

    public function report() {
        $view = new View();
        $content = $view->Render("note" . DS . "report", false);
        $this->Assign("content", $content);
    }

    public function imprimer() {
        parent::printable();

        $view = new View();
        $view->Assign("pdf", $this->pdf);
        $view->Assign("anneescolaire", $this->session->anneeacademique);

        $action = $this->request->code;
        switch ($action) {
            case "0001":
                # Fiche de report de note vierge accessible dans note/saisie
                $ens = $this->Enseignement->get($this->request->idenseignement);
                $view->Assign("enseignement", $ens);

                $view->Assign("classe", $this->Classe->get($this->request->idclasse));

                # Liste des eleves inscrit
                $eleves = $this->Inscription->getInscrits($this->request->idclasse);
                $view->Assign("eleves", $eleves);

                echo $view->Render("note" . DS . "impression" . DS . "reportnotevierge", false);
                break;

            # Impression pour les statistiques par matieres accessible dans note/statistique/matiere
            case "0002":
                $notations = $this->Notation->getNotationsByMatieresByPeriode($this->request->idmatiere, 
                $this->request->periode);
                $view->Assign("notations", $notations);
                
                # Construire un tableau ayant pour chaque notation, sa liste de note correspondante
                $array_notes = new ArrayObject();
                foreach($notations as $n){
                    $notes = $this->Note->findBy(["NOTATION" => $n['IDNOTATION']]);
                    $array_notes->offsetSet($n['IDNOTATION'], $notes);
                }
                $view->Assign("array_notes", $array_notes);
                
                $matiere = $this->Matiere->findSingleRowBy(["IDMATIERE" => $this->request->idmatiere]);
                $view->Assign("matiere", $matiere);
                echo $view->Render("note" . DS . "impression" . DS . "statistiqueparmatiere", false);
                break;


            # Impression pour les statistiques par classes Accessible par note/statistique
            case "0003":
                echo $view->Render("note" . DS . "impression" . DS . "statistiqueparclasse", false);
                break;

            # Impression de la fiche de note deja remplis Accessible par note/index
            case "0004":
                $notation = $this->Notation->findSingleRowBy(["IDNOTATION" => $this->request->idnotation]);
                $ens = $this->Enseignement->findSingleRowBy(["IDENSEIGNEMENT" => $notation['ENSEIGNEMENT']]);

                $notes = $this->Note->findBy(["NOTATION" => $this->request->idnotation]);
                $view->Assign("notation", $notation);
                $view->Assign("enseignement", $ens);
                $view->Assign("notes", $notes);
                echo $view->Render("note" . DS . "impression" . DS . "reportnote", false);
                break;
        }
    }

}
