<?php

/**
 * Contient l'ensemble des fonctions 
 * utiliser a travers les view, controller ou model
 */

/**
 * Cette fonction permet de creer une URL MVC a partir
 * d'un controller, d'une action et d'un tableau d'arguments
 */
function url($controller = "index", $action = "", $query = "") {
    $str = SITE_ROOT . $controller;
    if (!empty($action)) {
        $str .= "/" . $action;
    }
    if (is_array($query)) {
        foreach ($query as $val) {
            $str .= "/" . $val;
        }
    } elseif (!empty($query)) {
        $str .= "/" . $query;
    }
    return $str;
}

/**
 * Verifie si l'utilisateur est autoriser a 
 * acceder a cette page en utilisant son tableau de droit
 * La liste des droits d'un utilisateur = liste des droit du profile + droit specifique (pas encore implemente)
 * @global type $DROITS est defini dans la classe Application et contien son tableau de droit
 * @param type $codedroit
 * @return boolean
 */
function isAuth($codedroit) {
    //var_dump($_SESSION['droits']);die();
    if (in_array($codedroit, $_SESSION['droits'])) {
        return true;
    }
    return false;
}

function btn_add($action) {
    return "\t<img style='cursor:pointer' src = '" . SITE_ROOT . "public/img/btn_add.png' onclick = \"" . $action . "\"/>";
}

function btn_print($action) {
    return "\t<img style='cursor:pointer' src = '" . SITE_ROOT . "public/img/btn_print.png' onclick = \"" . $action . "\"/>";
}

function btn_cancel($action) {
    return "\t<img style='cursor:pointer' src = '" . SITE_ROOT . "public/img/btn_cancel.png' onclick = \"" . $action . "\"/>";
}

function btn_ok($action) {
    return "\t<img style='cursor:pointer' src = \"" . SITE_ROOT . "public/img/btn_ok.png \" onclick = \"" . $action . "\"/>";
}

function btn_add_disabled($action = "") {
    return "\t<img src = \"" . SITE_ROOT . "public/img/btn_add_disabled.png \" onclick = \"" . $action . "\"/>";
}

function btn_effacer_disabled($action = "") {
    return "\t<img style = 'cursor: auto;' src = \"" . SITE_ROOT . "public/img/btn_effacer_disabled.png \" onclick = \"" . $action . "\"/>";
}

function btn_effacer($action) {
    return "\t<img src = \"" . SITE_ROOT . "public/img/btn_effacer.png \" onclick = \"" . $action . "\"/>";
}

function btn_cancel_disabled($action = "") {
    return "cancel disabled";
}

function btn_ok_disabled($action = "") {
    return "ok disabled";
}

function btn_save_appel($action = "") {
    return "<img src = \"" . SITE_ROOT . "public/img/btn_save_appel.png \" onclick = \"" . $action . "\"/>";
}

function jourSemaine() {
    $array = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    return $array;
}

function getJourSemaine($index) {
    return jourSemaine()[$index - 1];
}

function img_add() {
    return SITE_ROOT . "public/img/btn_add.png";
}

function img_cancel() {
    return SITE_ROOT . "public/img/btn_cancel.png";
}

/**
 * 
 * @return type
 */
function img_delete() {
    return SITE_ROOT . "public/img/delete.png";
}

function img_delete_disabled() {
    return SITE_ROOT . "public/img/delete_disabled.png";
}

/**
 * 
 * @return type
 */
function img_edit() {
    return SITE_ROOT . "public/img/edit.png";
}

function img_edit_disabled() {
    return SITE_ROOT . "public/img/edit_disabled.png";
}

/**
 * 
 * @return type
 */
function img_valider() {
    return SITE_ROOT . "public/img/valider.png";
}

function img_valider_disabled() {
    return SITE_ROOT . "public/img/valider_disabled.png";
}

/**
 * 
 */
function img_info() {
    return SITE_ROOT . "public/img/info.png";
}

function img_print() {
    return SITE_ROOT . "public/img/print.png";
}

function getAppreciations($note) {
    if ($note >= 0 && $note < 4) {
        return "Nul";
    } elseif ($note >= 4 && $note < 6) {
        return "Très faible";
    } elseif ($note >= 6 && $note < 8) {
        return "Faible";
    } elseif ($note >= 8 && $note < 9) {
        return "Insuffisant";
    } elseif ($note >= 9 && $note < 10) {
        return "Médiocre";
    } elseif ($note >= 0 && $note < 11) {
        return "Moyen";
    } elseif ($note >= 11 && $note < 12) {
        return "Passable";
    } elseif ($note >= 12 && $note < 14) {
        return "Assez bien";
    } elseif ($note >= 14 && $note < 16) {
        return "Bien";
    } elseif ($note >= 16 && $note < 18) {
        return "Très bien";
    } elseif ($note >= 18 && $note <= 20) {
        return "Excellent";
    }
}

function img_imprimer() {
    return SITE_ROOT . "public/img/imprimer.png";
}

function img_lock() {
    return SITE_ROOT . "public/img/lock.png";
}

function getHoraires($datedeb, $datefin) {
    $heure_de_cours = array(
        ["08:00", "08:55"], //1ere heure
        ["09:00", "09:55"], //seconde heure
        ["10:00", "11:55"], //3eme heure
        ["11:00", "12:55"], //4eme heure
        ["12:00", "12:55"], //5eme heure
        ["13:00", "13:55"], //6eme heure
        ["13:55", "14:50"], //7eme heure
        ["14:55", "15:50"], //8eme heure
        ["16:00", "16:55"], //9eme heure
        ["17:00", "17:55"] //10eme heure
    );
    $index = 0;
    $time = strtotime($datefin) - strtotime($datedeb);
    $datedeb = substr($datedeb, 0, 5);
    for ($i = 0; $i < count($heure_de_cours); $i++) {
        if ($heure_de_cours[$i][0] === $datedeb) {
            $index = $i;
        }
    }

    $durer = (date("h", $time) > 0) ? (date("i", $time) > 55) ? date("h", $time) : date("h", $time) : 1;
    $tab = array();
    for ($i = $index; $i < ($index + $durer); $i++) {
        $tab[] = $i + 1;
    }

    return $tab;
}

/**
 * Verifie si cet eleve etait absent durant cette horaire et ce jour
 * @param int $ideleve
 * @param array $absences tableau contenant les eleves absence
 * @param int $horaire
 * Cette fonction verifie jusque que cet eleve existe dans ce tableau a ce heure
 * $absences = obtenu par la methode getAbsences de absenceModel
 */
function estAbsent($ideleve, $absences, $horaire = 0, $datejour = "") {
    if (empty($horaire) && !empty($datejour)) {
        foreach ($absences as $abs) {
            if ($abs['ELEVE'] == $ideleve && $abs['DATEJOUR'] == $datejour) {
                return $abs;
            }
        }
    } elseif (empty($datejour)) {
        foreach ($absences as $abs) {
            if ($abs['ELEVE'] == $ideleve && $abs['HORAIRE'] == $horaire) {
                return $abs;
            }
        }
    } else {
        foreach ($absences as $abs) {
            if ($abs['ELEVE'] == $ideleve && $abs['HORAIRE'] == $horaire && $abs['DATEJOUR'] === $datejour) {
                return $abs;
            }
        }
    }
    return null;
}

/**
 * Obtenir le nombre d'horaire par jour, soit 8 
 * ou 9 pour les 1ere et Tle
 * @param type $groupe
 * @return type
 */
function getNbHoraire($groupe) {
    if ($groupe !== 0 && $groupe !== 1) {
        return MAX_HORAIRE;
    }
    return (MAX_HORAIRE + 1);
}

/**
 * Return un tableau associatif des mois de l'annee academique
 * @param string $anneeacademique sous la forme 2014-2015
 * @return array
 */
function getMonthOfTheYear($anneeacademique) {

    $debut = substr($anneeacademique, 0, 4);
    $fin = substr($anneeacademique, -4);

    $mois = [
        9 => "Septembre " . $debut,
        10 => "Octobre " . $debut,
        11 => "Novembre " . $debut,
        12 => "Decembre " . $debut,
        1 => "Janvier " . $fin,
        2 => "Fevrier " . $fin,
        3 => "Mars " . $fin,
        4 => "Avril " . $fin,
        5 => "Mai " . $fin,
        6 => "Juin " . $fin,
        7 => "Juillet " . $fin,
        8 => "Aout " . $fin];
    return $mois;
}

/**
 * 
 * @param int $periode 1 = Mensuelle, 2 = Sequentielle, 3 = Trimestrielle, 4 = Annuelle
 * @param int $distribution valeur relatif a la $periode 
 * <ol>
 *  <li>si $periode = 1, alors $distribution est une lvalue compris entre 1 a 11 où 1 = Septembre, 2 = Octobre ... 11 = Juillet</li>
 *  <li>si $periode = 2, alors $distribution est une IDSEQUENCE avec libelle, 1ere sequence, 2nde sequence ... Confere table sequences dans la BD</li>
 *  <li>si $periode = 3, alors $distribution est une IDTRIMESTRE avec libelle, 1er Trimestre, 2nd Trimestre... Confere table trimestres dans la BD</li>
 *  <li>si $periode = 4, alors $distribution est une ANNEEACADEMIQUE 2014-2015 avec libelle 2014-2015... Confere table anneeacademique dans la BD</li>
 * </ol> 
 * @return array Cette fonction renvoie un tableau contenant la date de debut et la date fin pour cette periode 
 * defini par $periode et $distribution
 */
function getIntervaleOfMonth($distribution) {
    $tab = array();

    # Mensuelle
    $month = $distribution;
    $year = intval(explode("-", $_SESSION['anneeacademique'])[0]);

    if ($month >= 1 && $month <= 8) {
        $year = $year + 1;
    }
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    # Date de debut du mois
    $tab[0] = date("Y-m-d", strtotime($year . "-" . $month . "-1"));

    # Date de debut de fin
    $tab[1] = date("Y-m-d", strtotime($year . "-" . $month . "-" . $days));

    return $tab;
}

/**
 * Renvoi une tableau contenan le resumer du nombre d'absences de l'eleve
 * le tableau contenant les absences des eleves est passee en parametre
 * @param type $ideleve l'eleve dont il faut chercher le resumee
 * @param type $absences le tableau contenant les absence
 * @return array tableau contenant 
 * tab[0] = nbre des absences non justifiee, tab[1] = absence justifiees 
 * tab[2] = nb retard et tab[3] = nb exclusion, 
 */
function getNbAbsencesResumees($ideleve, $absences) {
    $tab = array();
    $t0 = $t1 = $t2 = $t3 = 0;
    foreach ($absences as $abs) {
        if ($abs['ELEVE'] == $ideleve) {
            if (!empty($abs['JUSTIFIER'])) {
                $t1++;
            } elseif ($abs['ETAT'] == "A") {
                $t0++;
            } elseif ($abs['ETAT'] == "R") {
                $t2++;
            } elseif ($abs['ETAT'] == "E") {
                $t3++;
            }
        }
    }
    $tab[0] = $t0;
    $tab[1] = $t1;
    $tab[2] = $t2;
    $tab[3] = $t3;
    return $tab;
}
/**
 * Obtenir le nombre de personne ayant ete note,
 * @param type $notes
 * @return array
 */
function effectifEvalues($notes){
    $nbre = 0;
    foreach($notes as $n){
        if($n['ABSENT'] != 1){
            $nbre++;
        }
    }
    return $nbre;
}

function moyenneSup10($notes){
    $array = array();
    foreach($notes as $n){
        if($n['NOTE'] >= 10){
            $array[] = $n;
        }
    }
    return $array;
}

/**
 * tab[0] = taux de reussite des garcon
 * tab[1] = taux de reussite des filles
 * tab[2] = taux de reussite generales
 * 
 * @param type $notes
 * @return type
 */
function tauxReussites($notes){
    $nb = effectifEvalues($notes);
    
    $tab = array();
    $t0 = $t1 = $t2 = 0;
    foreach($notes as $n){
        if($n['NOTE'] >= 10 && $n['SEXE'] == "M"){
            $t0++;
        }elseif($n['NOTE'] >= 10 && $n['SEXE'] == "F"){
            $t1++;
        }
    }
    $t2 = $t1 + $t0;
    
    $tab[0] = ($t0 /$nb ) * 100;
    $tab[1] = ($t1 / $nb) * 100;
    $tab[2] = ($t2 / $nb) * 100;
    
    return $tab;
}