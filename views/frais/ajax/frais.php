<table class="dataTable" id="fraisTable">
    <thead><tr><th>Description du frais scolaire</th><th>Montant</th><th>Ech&eacute;ances</th><th></th></tr></thead>
    <tbody>
        <?php
        foreach ($frais as $f) {
            $d = new DateFR($f['ECHEANCES']);
            $echeance = $d->getJour(3) . " " . $d->getDate() . "-" . $d->getMois() . "-" . $d->getYear();
            echo "<tr><td>" . $f['DESCRIPTION'] . "</td><td>" . $f['MONTANT'] . "</td><td>" . $echeance . "</td>"
            . "<td align = 'center'>";
            if (isAuth(510)) {
                echo "<img style = 'cursor:pointer' src = \"" . SITE_ROOT . "public/img/delete.png\" "
                . "onclick = \"supprimerFrais('" . $f['IDFRAIS'] . "')\" />&nbsp;&nbsp;";
            }
            if (isAuth(511)) {
                echo "<img id = 'img-edit' style = 'cursor:pointer' src = '" . img_edit() . "'  "
                . "onclick = \"openEditForm('" . $f['IDFRAIS'] . "')\" />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
    if (!$.fn.DataTable.isDataTable("#fraisTable")) {
        $("#fraisTable").DataTable({
            "bInfo": false,
            "scrollY": 200,
            "searching": false,
            "paging": false,
            "columns": [
                {"width": "55%"},
                {"width": "18%"},
                {"width": "20%"},
                {"width": "7%"}
            ]
        });
    }
</script>
