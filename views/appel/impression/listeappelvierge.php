<?php
$y = $pdf->GetY();
$pdf->SetPrintHeader(false);
//Titre du PDF

$titre = '<p style = "text-decoration:underline"><b>LISTE D\'APPEL DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, 60, $y + 35, $titre);

$titre = '<span style = "text-decoration:underline"><b>CLASSE</b></span><b> : ' . $classe['NIVEAUHTML'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 10, 50 + $y, $titre);

$pdf->SetFont("helvetica", "B", 10);
$d1 = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$semaine = '<span>Semaine du <b style="text-decoration:underline">' . $d1->getDate() . " " . $d1->getMois() . " " . $d1->getYear()
        . '</b> au <b style="text-decoration:underline">'
        . $d2->getDate() . " " . $d2->getMois() . " " . $d2->getYear() . '</b></span>';
$pdf->WriteHTMLCell(0, 50, 70, 50 +  $y, $semaine);

$pdf->SetFont("Times", '', 10);

# Nombre de colonnes, pour les 1eres et Tle, 9 colonnes
$l = getNbHoraire($classe['GROUPE']);

$corps = '<table cellpadding="2">
    <thead><tr border ="0.5" style = "font-weight:bold"><th border ="0.5" width ="3%">N°</th>
            <th border ="0.5" align="center" width ="20%">Noms  Pr&eacute;noms</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Lundi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Mardi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Mercredi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Jeudi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Vendredi</th>
            <th border ="0.5" align="center" width ="7%">Total</th></tr></thead><tbody><tr>';
$corps .= '<td border ="0.5" align="center" colspan="2" width ="23%"><b>HEURES</b></td>';
for ($i = 1; $i <= $l * 5; $i++) {
    if ($i % $l == 0) {
        $corps .= '<td border ="0.5"  style="border-right:2px solid #000000" width ="' . (14 / $l) . '%"></td>';
    } else {
        $corps .= '<td border ="0.5"  width ="' . (14 / $l) . '%"></td>';
    }
}
$corps .= '<td border ="0.5"  width ="7%"></td></tr>';
$i = 1;
foreach ($eleves as $el) {
    $corps .= '<tr>';
    if ($i < 10) {
        $corps .= '<td border ="0.5"  width ="3%">0' . $i . '</td>';
    } else {
        $corps .= '<td border ="0.5"  width ="3%">' . $i . '</td>';
    }
    $corps .= '<td border ="0.5"  width ="20%">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>';
    for ($j = 1; $j <= $l * 5; $j++) {
        if ($j % $l == 0) {
            $corps .= '<td border ="0.5"  style="border-right:2px solid #000000" width ="' . (14 / $l) . '%"></td>';
        } else {
            $corps .= '<td border ="0.5"  width ="' . (14 / $l) . '%"></td>';
        }
    }
    $corps .= '<td border ="0.5" width ="7%" ></td></tr>';
    $i++;
}
$corps .= '</tbody></table>';


$pdf->WriteHTMLCell(0, 5, 10, 60 + $y, $corps);
$pdf->output();
