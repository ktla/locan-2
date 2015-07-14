<?php
# Affiche un resumer des absences par eleve appartement a une meme classe
# les colonnes sont les jours d'absences
# et les lignes les eleves de classe
?>
<table class="dataTable" id="tableAbsences">
    <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th>Abs. Non Just.</th><th>Abs. Just.</th><th>Retard</th>
            <th>Exclu</th><th>Total</th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($eleves as $el) {
            $tab = getNbAbsencesResumees($el['IDELEVE'], $absences);
            echo "<tr><td>" . $i . "</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            echo "<td class='absent' style='text-align:center'>" . $tab[0] . " hrs</td>";
            echo "<td class='justifier' style='text-align:center'>" . $tab[1] . " hrs</td>";
            echo "<td class='retard' style='text-align:center'>" . $tab[2] . " hrs</td>";
            echo "<td class='exclu' style='text-align:center'>" . $tab[3] . " hrs</td>";
            echo "<td style='text-align:center;font-weight:bold'>" . (array_sum($tab)) . "</td></tr>";
            $i++;
        }
        ?>

    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableAbsences")) {
            $("#tableAbsences").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    {"width": "5%"},
                    null,
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "7%"}
                ]
            });
        }
    });
</script>
