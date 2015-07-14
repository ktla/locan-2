<?php
$y = FIRST_TITLE;
$pdf->SetPrintHeader(false);
# Titre du PDF

$titre = '<p style = "text-decoration:underline"><b>LISTE D\'APPEL DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, 60, $y , $titre);

$titre = '<span style = "text-decoration:underline"><b>CLASSE</b></span><b> : ' . $classe['NIVEAUHTML'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 10, $y + 10 , $titre);

$pdf->SetFont("helvetica", "B", 10);
$d1 = new DateFR($datedebut);
$d2 = new DateFR($datefin);

$semaine = '<span>Semaine du <b style="text-decoration:underline">' . $d1->getDate() . " " . $d1->getMois() . " " . $d1->getYear()
        . '</b> au <b style="text-decoration:underline">'
        . $d2->getDate() . " " . $d2->getMois() . " " . $d2->getYear() . '</b></span>';
$pdf->WriteHTMLCell(0, 50, 70, $y + 10, $semaine);

$pdf->SetFont("Times", '', 8);

# Nombre de colonnes, pour les 1eres et Tle, 9 colonnes
$l = getNbHoraire($classe['GROUPE']);

$absent = "<b>A</b>";
$retard = "<b>R</b>";
$exclu = "<b>E</b>";
$justifier = "<b>J</b>";

$corps = '<table cellpadding="2">
    <thead><tr border ="0.5" style = "font-weight:bold"><th border ="0.5" width ="3%">N°</th>
            <th border ="0.5" align="center" width ="20%">Noms  Pr&eacute;noms</th>
            <th border ="0.5" align="center" width ="15%" style="border-right:2px solid #000000" colspan="' . $l . '">Lundi</th>
            <th border ="0.5" align="center" width ="15%" style="border-right:2px solid #000000" colspan="' . $l . '">Mardi</th>
            <th border ="0.5" align="center" width ="15%" style="border-right:2px solid #000000" colspan="' . $l . '">Mercredi</th>
            <th border ="0.5" align="center" width ="15%" style="border-right:2px solid #000000" colspan="' . $l . '">Jeudi</th>
            <th border ="0.5" align="center" width ="15%" style="border-right:2px solid #000000" colspan="' . $l . '">Vendredi</th>
            <th border ="0.5" align="center" width ="5%">Total</th></tr></thead><tbody><tr>';
$corps .= '<td border ="0.5" align="center" colspan="2" width ="23%"><b>HEURES</b></td>';
$j = 1;
for ($i = 1; $i <= $l * 5; $i++) {
    if ($i % $l == 0) {
        $corps .= '<td border ="0.5"  style="border-right:2px solid #000000" '
                . 'width ="' . (15 / $l) . '%">'.$j.'<sup>h</sup></td>';
    } else {
        $corps .= '<td border ="0.5"  width ="' . (15 / $l) . '%">'.$j.'<sup>h</sup></td>';
    }
    $j++;
     if($i % $l == 0){
        $j = 1;
    }
}
$corps .= '<td border ="0.5"  width ="5%"></td></tr>';
$i = 1;
foreach ($eleves as $el) {
    $corps .= '<tr>';
    if ($i < 10) {
        $corps .= '<td border ="0.5"  width ="3%">0' . $i . '</td>';
    } else {
        $corps .= '<td border ="0.5"  width ="3%">' . $i . '</td>';
    }
    $corps .= '<td border ="0.5"  width ="20%">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>';
    $total = 0;
    for ($j = 1; $j <= $l * 5; $j++) {
        $abs = estAbsent($el['IDELEVE'], $absences, $j);
        $etat = "";
        $fond = "";
        if(!empty($abs['JUSTIFIER'])){
            $etat = $justifier;
            $fond = "background-color:#ffff66";
        }elseif(!is_null($abs) && $abs['ETAT'] === "A"){
            $etat = $absent;
            $total++;
            $fond = "background-color:#ff9999";
        }elseif(!is_null($abs) && $abs['ETAT'] === "R"){
            $etat = $retard;
            $fond = "background-color:#99ffff";
        }elseif(!is_null($abs) && $abs['ETAT'] === "E"){
            $etat = $exclu;
            $fond = "background-color:#ccccff";
        }
        
        if ($j % $l == 0) {
            $corps .= '<td border ="0.5"  style="border-right:2px solid #000000; '.$fond.'" '
                    . 'width ="' . (15 / $l) . '%">'.$etat.'</td>';
        } else {
            $corps .= '<td border ="0.5" style="'.$fond.'" width ="' . (15 / $l) . '%">'.$etat.'</td>';
        }
    }
    $corps .= '<td border ="0.5" > '.$total.' hrs</td></tr>';
    $i++;
}
$corps .= '</tbody></table>';


$pdf->WriteHTMLCell(0, 5, 10, $y + 20, $corps);
$pdf->output();
