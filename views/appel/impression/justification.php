<?php
$y = $pdf->GetY();

$pdf->SetPrintHeader(false);
# Titre du PDF

$pdf->SetFont("helvetica", "B", 9);
$titre = '<p style = "text-decoration:underline"><b>JUSTIFICATION D\'ABSENCE DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, 60, 35 + $y, $titre);

$titre = '<span style = "text-decoration:underline"><b>ELEVE</b></span><b> : ' . $absence['NOM']." ".$absence['PRENOM'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 10, 50 + $y, $titre);

$titre = '<span style = "text-decoration:underline"><b>CLASSE</b></span><b> : ' . $appel['NIVEAUHTML']." ".$appel['LIBELLE'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 100, 50 + $y, $titre);

$pdf->SetFont("helvetica", "", 10);
$d = new DateFR($appel['DATEJOUR']);
$corps = '<p style="font-weight:bold; text-decoration:underline;">ABSENCE</p>';
$pdf->WriteHTMLCell(0, 5, 10, 60 + $y, $corps);
$pdf->WriteHTMLCell(0, 5, 20, 65 + $y, "Date de l'absence : <i>".$d->getJour()." ".$d->getDate()." ".$d->getMois()." ".$d->getYear()."</i>");
$h = "";
if($absence['HORAIRE'] == 1){
    $h = "1<sup>&egrave;re</sup>";
}else{
    $h = $absence['HORAIRE']."<sup>&egrave;me</sup>";
}
$pdf->WriteHTMLCell(0, 5, 20, 70 + $y, "Horaire de l'absence : <i>".$h." Heure</i>");
$corps = "Appel r&eacute;alis&eacute; par : <i>".$appel['NOMREALISATEUR'].' '.$appel['PRENOMREALISATEUR']."</i>";
if(!empty($appel['MODIFIERPAR'])){
    $d->setSource($appel['DATEMODIF']);
    $corps .= " et modifi&eacute;e par : <i>".$appel['NOMMODIFICATEUR']." ".$appel['PRENOMMODIFICATEUR']."</i> le "
            .$d->getJour(3)." ".$d->getDate()." ".$d->getMois()." ".$d->getYear();
}
$pdf->WriteHTMLCell(0, 5, 20, 75 + $y, $corps);

$corps = '<p style="font-weight:bold; text-decoration:underline;">JUSTIFICATION</p>';
$pdf->WriteHTMLCell(0, 5, 10, 85 + $y, $corps);

$d->setSource($justification['DATEJOUR']);
$pdf->WriteHTMLCell(0, 5, 20, 90 + $y, "Date de la justification : <i>" . $d->getJour()." ".$d->getDate()." ".$d->getMois()." ".$d->getYear()."</i>");

$pdf->WriteHTMLCell(0, 5, 20, 95 + $y, "Justification r&eacute;alis&eacute;e par : <i>".$justification['NOM']." ".$justification['PRENOM']."</i>");

$pdf->WriteHTMLCell(0, 5, 20, 100 + $y, "Motif de la justification : <i>".$justification['MOTIF']."</i>");

$pdf->WriteHTMLCell(0, 5, 20, 110 + $y, "Description de la justification : <i>".$justification['DESCRIPTION']."</i>");
     
$pdf->output();
