<?php
$y = FIRST_TITLE;
//$pdf->AddPage();
//Titre du PDF
$titre = '<p style = "text-decoration:underline">FICHE DE L\'ELEVE</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$pdf->SetFont("helvetica", "B", 10);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 15);
$pdf->Cell(60, 4, "I-IDENTITE", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 12);

if ($eleve['SEXE'] === "M") {
    $sexe = "Masculin";
} else {
    $sexe = "F&eacute;min";
}
$d = new DateFR($eleve['DATENAISS']);
$corps = '<table border = "0" cellpadding = "5" style = "width:350px">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Nom </td><td style = "border-bottom:1px solid #000000">' . $eleve['NOM'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Pr&eacute;nom</td><td style = "border-bottom:1px solid #000000">' . $eleve['PRENOM'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Sexe</td><td style = "border-bottom:1px solid #000000">' . $sexe . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Date de naissance</td><td  style = "border-bottom:1px solid #000000">' . $d->getDate() . " " . $d->getMois(0) . " " . $d->getYear() . "</td></tr>";
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Lieu de naissance</td><td  style = "border-bottom:1px solid #000000">' . $eleve['LIEUNAISS'] . "</td></tr>";
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Pays de naissance</td><td  style = "border-bottom:1px solid #000000">' . $eleve['FK_PAYSNAISS'] . "</td></tr>";
$corps .= '</table>';
//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 20, $y + 20, $corps);
//Matricule
$pdf->WriteHTMLCell(50, 10, 159, $y + 15, '<b>Matricule : ' . $eleve['MATRICULE'].'</b>', 0, 2);
if (!empty($eleve['PHOTO'])) {
    $photo = SITE_ROOT . "public/photos/eleves/" . $eleve['PHOTO'];
    $pdf->Image($photo, 160, $y + 30, 40, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
} else {
    $pdf->WriteHTMLCell(30, 25, 160, $y + 30, '<br/><br/><br/>PHOTO', 1, 2, false, true, 'C');
}
$pdf->SetFont("helvetica", "B", 10);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 80);
$pdf->Cell(60, 4, "II-SCOLARITE ACTUELLE", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 12);

$d->setSource($eleve['DATEENTREE']);
$classecourante = isset($classe['NIVEAUHTML']) ? $classe['NIVEAUHTML'] : "";
$classecourante .= " " . (isset($classe['LIBELLE']) ? $classe['LIBELLE'] : "");

$redo = isset($redoublant) && $redoublant === true ? "Oui" : "Non";

$corps = '<table border = "0" cellpadding = "5">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Classe </td><td style = "border-bottom:1px solid #000000">' . $classecourante . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Redoublant</td><td style = "border-bottom:1px solid #000000">' . $redo . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Provenance </td><td style = "border-bottom:1px solid #000000">' . $eleve['FK_PROVENANCE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Date d\' entr&eacute;e</td><td  style = "border-bottom:1px solid #000000">' . $d->getDate() . " " . $d->getMois(0) . " " . $d->getYear() . "</td></tr>";
$d->setSource($eleve['DATESORTIE']);
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Date de sortie</td><td  style = "border-bottom:1px solid #000000">' . $d->getDate() . " " . $d->getMois(0) . " " . $d->getYear() . "</td></tr>";
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Motif de sortie</td><td  style = "border-bottom:1px solid #000000">' . $eleve['FK_MOTIF'] . "</td></tr>";
$corps .= '</table>';

//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 20, $y + 85, $corps);


$pdf->SetFont("helvetica", "B", 10);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 140);
$pdf->Cell(60, 4, "III-RESPONSABLES - PARENTS", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 12);

$corps = '<table border = "0" cellpadding = "5"><tr style = "font-weight:bold"><td>Nom</td><td>Pr&eacute;nom</td><td>Parent&eacute;</td>'
        . '<td>Portable</td></tr>';
foreach ($responsables as $resp) {
    $corps .= '<tr><td style = "border-bottom:1px solid #000000">' . $resp['NOM'] . '</td>'
            . '<td style = "border-bottom:1px solid #000000">' . $resp['PRENOM'] . '</td>';
    $corps .= '<td style = "border-bottom:1px solid #000000">' . $resp['PARENTE'] . '</td>';
    $corps .= '<td style = "border-bottom:1px solid #000000">' . $resp['PORTABLE'] . '</td></tr>';
}
$corps .= '</table>';

//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 20, $y + 145, $corps);
$pdf->Output();
