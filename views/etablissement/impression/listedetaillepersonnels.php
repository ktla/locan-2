<?php
$y = FIRST_TITLE;
//Titre du PDF
$titre = '<p style = "text-decoration:underline">LISTE DU PRESONNELS</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

//Corps du PDF
$corps = '<table border = "1" cellpadding = "2" width = "100%"><thead><tr align="center"><th width ="10%">Civilit&eacute;</th><th>Noms & Pr&eacute;noms</th>'
        . '<th>Fonction</th><th>Portable</th></tr></thead><tbody>';
foreach ($personnels as $p) {
    $corps .= '<tr><td width ="10%">' . $p['CIVILITE'] . '</td><td>' . $p['NOM'] . ' ' . $p['PRENOM'] . '</td><td>' . $p['LIBELLE']
            . '</td><td>' . $p['PORTABLE'] . '</td></tr>';
}
$corps .= "</tbody></table>";
$pdf->setFontSize(12);
//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $corps);

$pdf->Output();
