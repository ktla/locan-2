<?php

class bulletinController extends Controller {

    private $comboClasses;
    private $comboPeriodes;

    public function __construct() {
        parent::__construct();
        $this->loadModel("sequence");
        $this->loadModel("trimestre");
        $this->loadModel("classe");
        $this->loadModel("anneeacademique");
        $this->loadModel("inscription");
        $this->loadModel("eleve");
        $this->loadModel("enseignement");
        $this->loadModel("note");

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), ['NIVEAUSELECT', 'LIBELLE']);

        $periodes = $this->Anneeacademique->getPeriodes($this->session->anneeacademique);
        $this->comboPeriodes = new Combobox($periodes, "comboPeriodes", "IDPERIODE", "LIBELLE");
    }

    public function index() {
        
    }

    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            case "0001":
                $idclasse = $this->request->comboClasses;
                $ideleve = $this->request->comboEleves;

                $array_of_redoublant = $this->Classe->getRedoublants($idclasse, $this->session->anneeacademique, true);
                $view->Assign("array_of_redoublants", $array_of_redoublant);

                $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $idclasse]);
                $view->Assign("classe", $classe);

                $inscrits = $this->Inscription->getInscrits($idclasse);
                $view->Assign("effectif", count($inscrits));
                $codeperiode = substr($this->request->comboPeriodes, 0, 1);
                $idperiode = substr($this->request->comboPeriodes, -1);

                if ($codeperiode == "S") {
                    $libelle = $this->Sequence->findSingleRowBy(["IDSEQUENCE" => $idperiode])["LIBELLEHTML"];
                } else {
                    $libelle = $this->Trimestre->findSingleRowBy(["IDTRIMESTRE" => $idperiode])["LIBELLEHTML"];
                }
                $view->Assign("libelle", $libelle);
                $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $ideleve]);

                $view->Assign("eleve", $eleve);
                $notes = new ArrayObject();
                # Obtenir les enseignements sous forme de groupe
                # $i represente le groupe, stocker ces groupe dans la variable $groupe
                $groupe = array();
                for ($i = 1; $i <= 3; $i++) {
                    $gp = $this->Enseignement->getEnseignements($idclasse, $i);
                    foreach ($gp as $g) {
                        $note = $this->Note->getNoteByEnseignementByPeriodeByEleve($g['IDENSEIGNEMENT'], $idperiode, $ideleve);
                        $notes->offsetSet($g['IDENSEIGNEMENT'], $note);
                    }
                    $groupe[] = $gp;
                }

                $view->Assign("notes", $notes);
                $view->Assign("groupe", $groupe);
                echo $view->Render("bulletin" . DS . "impression" . DS . "bulletin", false);
                break;
        }
    }

    public function impression() {
        $view = new View();
        if (!empty($this->request->comboClasses)) {
            $this->imprimer();
        }
        $this->view->clientsJS("bulletin" . DS . "impression");
        $this->comboClasses->first = " ";
        $this->comboPeriodes->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("bulletin" . DS . "impression", false);
        $this->Assign("content", $content);
    }

    public function ajaximpression() {
        $view = new View();
        $json = array();

        $action = $this->request->action;
        switch ($action) {
            case "chargerEleves":
                $eleves = $this->Inscription->getInscrits($this->request->idclasse);
                $view->Assign("eleves", $eleves);
                $json[0] = $view->Render("bulletin" . DS . "ajax" . DS . "comboEleves", false);
                break;
        }

        echo json_encode($json);
    }

}
