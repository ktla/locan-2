<?php

$pdf->SetPrintHeader(false);
//$pdf->SetPrintFooter(false);

//Titre du PDF
$titre = '<p style = "text-decoration:underline">LISTE DES ELEVES DE L\'ETABLISSEMENT</p>';
$pdf->WriteHTMLCell(0, 50, 65, 30, $titre);

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width ="10%">Matricule</th><th width ="55%">Noms & Pr&eacute;noms</th>
        <th width ="15%">Date de Naiss.</th><th width ="20%">Classe</th></tr></thead><tbody>
EOD;
foreach ($eleves as $el) {
    $d = new DateFR($el['DATENAISS']);
    $corps .= '<tr><td width ="10%" style = "border-bottom:1px solid #000">' . $el['MATRICULE'] . '</td>'
            . '<td width ="55%" style = "border-bottom:1px solid #000">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>'
            . '<td width ="15%"  style = "border-bottom:1px solid #000">' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . '</td>'
            . '<td width ="20%"  style = "border-bottom:1px solid #000">' . $el['NIVEAUHTML'].' '.$el['CLASSECOURANTE'] . '</td></tr>';
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 10);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '');

$pdf->WriteHTMLCell(0, 5, 10, 50, $corps);

$pdf->Output();