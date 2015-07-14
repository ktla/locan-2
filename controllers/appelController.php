<?php
/***
 * Suppression d'appel : droit 324
 */
class appelController extends Controller {

    private $comboClasse;

    public function __construct() {
        parent::__construct();
        $this->loadModel("eleve");
        $this->loadModel("classe");
        $this->loadModel("inscription");
        $this->loadModel("emplois");
        $this->loadModel("enseignement");
        $this->loadModel("absence");
        $this->loadModel("justification");
        $this->loadModel("sequence");
        $this->loadModel("trimestre");
        $this->loadModel("anneeacademique");
        $this->loadModel("personnel");

        $classes = $this->Classe->selectAll();
        $this->comboClasse = new Combobox($classes, "comboClasses", $this->Classe->getKey(), $this->Classe->getLibelle());
        $this->comboClasse->first = " ";
    }
    public function delete($id){
        $this->Appel->delete($id);
        header("Location:".Router::url("appel", "semaine"));
    }
    public function index() {
        if (!isAuth(213)) {
            return;
        }
        $this->view->clientsJS("appel" . DS . "index");
        $view = new View();
        $view->Assign("comboClasses", $this->comboClasse->view());
        $view->Assign("legendes", $view->Render("appel" . DS . "legendes", false));
        $content = $view->Render("appel" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function ajaxindex() {
        $action = $this->request->action;
        $json = array();
        $view = new View();

        switch ($action) {
            case "chargerDistributions":
                $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
                $view->Assign("periode", $this->request->periode);
                $view->Assign("sequences", $sequences);
                $view->Assign("anneeacademique", $this->session->anneeacademique);

                $trimestres = $this->Trimestre->findBy(["PERIODE" => $this->session->anneeacademique]);
                $view->Assign("trimestres", $trimestres);

                $annee = $this->Anneeacademique->selectAll();
                $view->Assign("annee", $annee);

                $json[0] = $view->Render("appel" . DS . "ajax" . DS . "comboDistribution", false);
                break;
            case "chargerDonnees":
                $distribution = $this->request->distribution;
                $periode = $this->request->periode;

                $tab = $this->getDateIntervals($periode, $distribution);
                $view->Assign("datedebut", $tab[0]);
                $view->Assign("datefin", $tab[1]);

                $absences = $this->Absence->getAbsencesByPeriode($tab[0], $tab[1], $this->request->idclasse);
                $view->Assign("absences", $absences);

                # Eleve inscrit dans cette classe
                $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                $view->Assign("eleves", $eleves);

                $json[0] = $view->Render("appel" . DS . "ajax" . DS . "index", false);
                break;
        }
        echo json_encode($json);
    }

    public function ajaxjustification() {
        $view = new View();
        $json = array();

        # Liste des eleves inscrits dans cette classe
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);

        $action = $this->request->action;
        switch ($action) {
            case "chargerAbsences":
                $json[1] = $view->Render("appel" . DS . "ajax" . DS . "comboEleves", false);
                break;

            case "justifier":
                $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);
                $params = ["motif" => $this->request->motif,
                    "description" => $this->request->description,
                    "datejour" => date("Y-m-d", time()),
                    "realiserpar" => $personnel['IDPERSONNEL']];

                $this->Justification->insert($params);
                $idjustification = $this->Justification->lastInsertId();

                # Mettre a jour l'absence correspondant
                $this->Absence->update(["JUSTIFIER" => $idjustification], ["IDABSENCE" => $this->request->idabsence]);
                break;
            case "supprimerjustification":
                $this->Absence->update(["JUSTIFIER" => null], ["IDABSENCE" => $this->request->idabsence]);
                $this->Justification->delete($this->request->idjustification);
                break;
        }
        $absences = $this->Appel->getAppels($this->request->idclasse, $this->request->datejour);
        $view->Assign("absences", $absences);

        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
        $view->Assign("classe", $classe);
        $json[0] = $view->Render("appel" . DS . "ajax" . DS . "justification", false);

        echo json_encode($json);
    }

    public function justification() {
        $this->view->clientsJS("appel" . DS . "justification");
        $view = new View();
        $legendes = $view->Render("appel" . DS . "legendes", false);
        $view->Assign("legendes", $legendes);
        $view->Assign("comboClasses", $this->comboClasse->view());

        $content = $view->Render("appel" . DS . "justification", false);
        $this->Assign("content", $content);
    }

    /**
     * 
     * @return int l'identifiant de l'appel inserer
     */
    private function insererAppel() {
        $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);

        $param = ["classe" => $this->request->idclasse,
            "datejour" => $this->request->datedujour,
            "realiserpar" => $personnel['IDPERSONNEL']
        ];
        $this->Appel->insert($param);
        return $this->Appel->lastInsertId();
    }

    public function saisie() {
        if (!empty($this->request->idclasse) && !empty($this->request->datejour)) {
            # Inserer les infos de l'appel
            $idappel = $this->insererAppel();

            # Inserer les infos des absences pour cet appel
            $this->insererAbsences($idappel);

            header("Location:" . Router::url("appel"));
        }
        $this->view->clientsJS("appel" . DS . "appel");
        $view = new View();
        $view->Assign("comboClasses", $this->comboClasse->view());
        $content = $view->Render("appel" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function validerEdit() {
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);
        
        # Mettre a jour la date de modification de l'appel et l'auteur
        $params = ["datemodif" => date("Y-m-d", time()),
            "modifierpar" => $personnel['IDPERSONNEL']];
        $this->Appel->update($params, ["IDAPPEL" => $this->request->idappel]);

        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
        $horaire = getNbHoraire($classe['GROUPE']);

        # Supprimer tous les absences afin de reinserer 
        $this->Absence->deleteBy(["APPEL" => $this->request->idappel]);

        # Inserer les absences modifier
        foreach ($eleves as $el) {
            $mat = $el['MATRICULE'];

            # Parcourir les horaires de la journee et inserer s'il n'est pas present
            for ($i = 1; $i <= $horaire; $i++) {
                $etat = $this->request->{$mat . "_" . $i};

                #Proceder a l'insertion que s'il est absent, exclu ou en retard
                if (!empty($etat)) {
                    $param = ["appel" => $this->request->idappel,
                        "eleve" => $el['IDELEVE'],
                        "etat" => $etat,
                        "horaire" => $i];
                    $this->Absence->insert($param);
                }
            }
        }
    }

    public function edit($id) {
         if(!isAuth(320)){
             return;
         }
        if (!empty($this->request->idappel)) {
            $this->validerEdit();
            header("Location:" . Router::url("appel", "liste"));
        }
        $this->view->clientsJS("appel" . DS . "edit");
        $view = new View();
        $appel = $this->Appel->findSingleRowBy(["IDAPPEL" => $id]);
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $appel['CLASSE']]);
        $view->Assign("classe", $classe);

        $this->comboClasse->disabled = true;
        $this->comboClasse->selectedid = $appel['CLASSE'];
        $view->Assign("comboClasses", $this->comboClasse->view());
        $view->Assign("appel", $appel);

        $absences = $this->Absence->getAbsences($appel['IDAPPEL']);
        $view->Assign("absences", $absences);

        $eleves = $this->Inscription->getInscrits($appel['CLASSE'], $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);

        $content = $view->Render("appel" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function suivi() {
        $this->view->clientsJS("appel" . DS . "suivi");
        $view = new View();
        $legendes = $view->Render("appel" . DS . "legendes", false);
        $view->Assign('legendes', $legendes);
        $eleves = $this->Eleve->selectAll();
        $comboEleves = new Combobox($eleves, "comboEleves", "IDELEVE", ["NOM", "PRENOM"]);
        $comboEleves->first = " ";
        $view->Assign("comboEleves", $comboEleves->view());
        $content = $view->Render("appel" . DS . "suivi", false);
        $this->Assign("content", $content);
    }

    private function getDateIntervals($periode, $distribution, &$libelle = "") {
        $tab = array();
        if ($periode == 1) {
            $libelle = getMonthOfTheYear($this->session->anneeacademique)[$distribution];
        }
        # Mensuelle
        if ($periode == 1) {
            return getIntervaleOfMonth($distribution);
        }
        # Sequence
        elseif ($periode == 2) {
            $sequence = $this->Sequence->findSingleRowBy(["IDSEQUENCE" => $distribution]);
            $tab[0] = $sequence['DATEDEBUT'];
            $tab[1] = $sequence['DATEFIN'];
            $libelle = $sequence['LIBELLE'];
        }
        # Trimestre 
        elseif ($periode == 3) {
            $trimestre = $this->Trimestre->findSingleRowBy(["IDTRIMESTRE" => $distribution]);
            $tab[0] = $trimestre['DATEDEBUT'];
            $tab[1] = $trimestre['DATEFIN'];
            $libelle = $trimestre['LIBELLE'];
        }
        #Annee
        elseif ($periode == 4) {
            $annee = $this->Anneeacademique->findSingleRowBy(["ANNEEACADEMIQUE" => $distribution]);
            $tab[0] = $annee['DATEDEBUT'];
            $tab[1] = $annee['DATEFIN'];
            $libelle = $annee['ANNEEACADEMIQUE'];
        }
        return $tab;
    }

    public function ajaxsuivi() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "chargerDistribution":
                $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
                $view->Assign("periode", $this->request->periode);
                $view->Assign("sequences", $sequences);
                $view->Assign("anneeacademique", $this->session->anneeacademique);

                $trimestres = $this->Trimestre->findBy(["PERIODE" => $this->session->anneeacademique]);
                $view->Assign("trimestres", $trimestres);

                $annee = $this->Anneeacademique->selectAll();
                $view->Assign("annee", $annee);

                $json[0] = $view->Render("appel" . DS . "ajax" . DS . "comboDistribution", false);
                break;
            case "chargerAbsences":
                $distribution = $this->request->distribution;
                $periode = $this->request->periode;

                $tab = $this->getDateIntervals($periode, $distribution);
                $view->Assign("datedebut", $tab[0]);
                $view->Assign("datefin", $tab[1]);

                # Selectionner tous les absences de cet eleve dont la date du jour de l'appel est compris entre date debut et date fin
                $absences = $this->Absence->getAbsencesEleveByPeriode($tab[0], $tab[1], $this->request->ideleve);
                $view->Assign("absences", $absences);

                #Envoyer le calendrier academique dans lequel il ya les jours ferier, et les jours de fermetures
                $calendrier = $this->getFreeDays();
                $view->Assign("calendrier", $calendrier);
                $view->Assign("ideleve", $this->request->ideleve);
                $json[0] = $view->Render("appel" . DS . "ajax" . DS . "suivi", false);
                break;
        }
        echo json_encode($json);
    }

    /**
     * Imprime la liste d'appel pour une tranche de semaine
     */
    public function liste() {
        $this->view->clientsJS("appel" . DS . "liste");
        $view = new View();
        $this->comboClasse->first = " ";
        $view->Assign("comboClasses", $this->comboClasse->view());
        $content = $view->Render("appel" . DS . "liste", false);
        $this->Assign("content", $content);
    }

    public function ajaxliste() {
        $json = array();
        $view = new View();
        # Obtenir la liste des eleves inscrite dans cette classe
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
        $view->Assign("classe", $classe);

        # Verifier si un appel a deja eu lieu ces jours
        $appel = $this->Appel->findSingleRowBy(["CLASSE" => $this->request->idclasse,
            "DATEJOUR" => $this->request->datedebut]);

        if (!empty($appel)) {
            $absences = $this->Absence->getAbsencesByPeriode($this->request->datedebut, $this->request->datefin, $this->request->idclasse);
            $view->Assign("appel", $appel);
            $view->Assign("absences", $absences);
            $json[0] = $view->Render("appel" . DS . "ajax" . DS . "listedeja", false);
        } else {
            $json[0] = $view->Render("appel" . DS . "ajax" . DS . "listeappel", false);
        }
        echo json_encode($json);
    }

    public function imprimer() {
        parent::printable();

        $view = new View();
        $view->Assign("pdf", $this->pdf);
        $action = $this->request->code;
        $view->Assign("anneescolaire", $this->session->anneeacademique);
        if ($action == "0001" || $action === "0002") {
            $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
            $view->Assign("eleves", $eleves);
            $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
            $view->Assign("classe", $classe);
            $view->Assign("datedebut", $this->request->datedebut);
            $view->Assign("datefin", $this->request->datefin);
        }
        switch ($action) {
            case "0001":
                # Liste d'appel vierge dans appel/liste
                echo $view->Render("appel" . DS . "impression" . DS . "listeappelvierge", false);
                break;
            case "0002":
                $absences = $this->Absence->getAbsencesByPeriode($this->request->datedebut, $this->request->datefin, $this->request->idclasse);
                $view->Assign("absences", $absences);
                echo $view->Render("appel" . DS . "impression" . DS . "ficheappel", false);
                break;
            # Fiche appel/suivi
            case "0003":
                $libelle = "";
                $tab = $this->getDateIntervals($this->request->periode, $this->request->distribution, $libelle);
                $view->Assign("libelle", $libelle);
                $view->Assign("datedebut", $tab[0]);
                $view->Assign("datefin", $tab[1]);
                $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $this->request->ideleve]);
                $view->Assign("eleve", $eleve);

                # Selectionner tous les absences de cet eleve dont la date du jour de l'appel est compris entre date debut et date fin
                $absences = $this->Absence->getAbsencesEleveByPeriode($tab[0], $tab[1], $this->request->ideleve);
                $view->Assign("absences", $absences);
                //var_dump($absences);die();
                #Envoyer le calendrier academique dans lequel il ya les jours ferier, et les jours de fermetures
                $calendrier = $this->getFreeDays();
                $view->Assign("calendrier", $calendrier);

                echo $view->Render("appel" . DS . "impression" . DS . "suivi", false);
                break;
            # Impression d'une justification appel/justification
            case "0004":
                $justification = $this->Justification->findSingleRowBy(["IDJUSTIFICATION" => $this->request->idjustification]);
                $absence = $this->Absence->findSingleRowBy(["IDABSENCE" => $this->request->idabsence]);
                $view->Assign("justification", $justification);
                $view->Assign("absence", $absence);
                $appel = $this->Appel->findSingleRowBy(["IDAPPEL" => $absence['APPEL']]);
                $view->Assign("appel", $appel);
                echo $view->Render("appel" . DS . "impression" . DS . "justification", false);
                break;

            # Impression d'un resume d'absence par classe appel/index
            case "0005":
                $distribution = $this->request->distribution;
                $periode = $this->request->periode;
                $libelle = "";
                $tab = $this->getDateIntervals($periode, $distribution, $libelle);
                $view->Assign("datedebut", $tab[0]);
                $view->Assign("datefin", $tab[1]);
                $view->Assign("libelle", $libelle);
                
                $absences = $this->Absence->getAbsencesByPeriode($tab[0], $tab[1], $this->request->idclasse);
                $view->Assign("absences", $absences);

                # Eleve inscrit dans cette classe
                $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                $view->Assign("eleves", $eleves);
                $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
                $view->Assign("classe", $classe);
                echo $view->Render("appel" . DS . "impression" . DS . "resumeabsence", false);
                break;
        }
    }

    public function semaine() {
        # http://all-free-download.com/free-icon/number-icons-16x16.html

        $this->view->clientsJS("appel" . DS . "semaine");
        $view = new View();
        $view->Assign("comboClasses", $this->comboClasse->view());
        $content = $view->Render("appel" . DS . "semaine", false);
        $this->Assign("content", $content);
    }

    /**
     * Utiliser dans la fonction ajaxemaine
     * @param type $jour 1 = Lundi ... 5 = Vendredi
     */
    public function getFormAppel($jour) {
        $view = new View();
        $classe = $this->Classe->findSingleRowBy(["IDCLASSE" => $this->request->idclasse]);
        $view->Assign("classe", $classe);
        $view->Assign("jour", $jour);
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);

        $j = $jour - 1;
        $datedujour = date("Y-m-d", strtotime('+' . $j . ' day', strtotime($this->request->datedebut)));

        # Verifier si un appel a deja eu lieu ce jour
        $appel = $this->Appel->findSingleRowBy(["CLASSE" => $this->request->idclasse, "DATEJOUR" => $datedujour]);

        if (!empty($appel)) {
            $absences = $this->Absence->getAbsences($appel['IDAPPEL']);
            $view->Assign("appel", $appel);
            $view->Assign("absences", $absences);
            return $view->Render("appel" . DS . "ajax" . DS . "semainedeja", false);
        }
        # verifier si c'est un jour ferier, ou un jour ferme
        $calendrier = $this->getFreeDays();

        if (array_key_exists($datedujour, $calendrier)) {
            $view->Assign("calendrier", $calendrier);
            return $view->Render("appel" . DS . "ajax" . DS . "freedays", false);
        }
        $view->Assign("datedujour", $datedujour);
        return $view->Render("appel" . DS . "ajax" . DS . "semaine", false);
    }

    /**
     * Effectue l'insertion des absences pour cet appel
     * @param type $idappel
     */
    private function insererAbsences($idappel) {
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
        $classe = $this->Classe->findSingleRowBy(['IDCLASSE' => $this->request->idclasse]);
        # 8 heure pour les classes different de 1ere et Tle
        $horaire = getNbHoraire($classe['GROUPE']);
        # Permet d'obtenir 1 = Lun ... 5 = Vendredi, Utiliser pour obtenir le champ select 
        # Qui est sous la forme de matricule_horaire_jour
        $jour = $this->request->jour;
        foreach ($eleves as $el) {
            $mat = $el['MATRICULE'];

            # Parcourir les horaires de la journee et inserer s'il n'est pas present
            for ($i = 1; $i <= $horaire; $i++) {
                $etat = $this->request->{$mat . "_" . $i . "_" . $jour};

                #Proceder a l'insertion que s'il est absent, exclu ou en retard
                if (!empty($etat)) {
                    $param = ["appel" => $idappel,
                        "eleve" => $el['IDELEVE'],
                        "etat" => $etat,
                        "horaire" => $i];
                    $this->Absence->insert($param);
                }
            }
        }
    }

    public function ajaxsemaine() {
        $json = array();
        $action = $this->request->action;

        switch ($action) {
            case "chargerEleves":
                # Lundi
                $json[0] = $this->getFormAppel(1);
                # Mardi
                $json[1] = $this->getFormAppel(2);
                # Mercredi
                $json[2] = $this->getFormAppel(3);
                # Jeudi
                $json[3] = $this->getFormAppel(4);
                #Vendredi
                $json[4] = $this->getFormAppel(5);
                break;
            case "validerForm":
                $idappel = $this->insererAppel();
                $this->insererAbsences($idappel);
                $json[0] = $this->getFormAppel($this->request->jour);
                break;
        }
        echo json_encode($json);
    }

    public function justifierparperiode() {
        //var_dump($this->request);die();
        if (!empty($this->request->comboEleves) && !empty($this->request->idclasse)) {
            #Supprimer toutes les anciennes justifications
            $this->Justification->deleteByPeriode($this->request->datedu, $this->request->dateau, $this->request->idclasse, $this->request->comboEleves);

            $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);
            #Inserer la justification et obtenir son nouvel Id
            $params = ["motif" => $this->request->motif2,
                "description" => $this->request->description2,
                "datejour" => date("Y-m-d", time()),
                "realiserpar" => $personnel['IDPERSONNEL']];
            $this->Justification->insert($params);
            $idjustification = $this->Justification->lastInsertId();

            #Mettre a jour les absences
            $this->Absence->updateJustifierByPeriode($this->request->datedu, $this->request->dateau, $this->request->idclasse, $this->request->comboEleves, $idjustification);
        }
        header("Location:" . Router::url("appel", "liste"));
    }

}
