<table class="dataTable" id="tab_mat">
    <thead><tr><th>Matière</th><th>Enseignants</th><th>Groupe</th><th>Coefficient</th><th></th></tr></thead>
    <tbody>
        <?php
        foreach ($enseignements as $ens) {
            echo "<tr><td>" . $ens['CODE'] . " - " . $ens['MATIERELIBELLE'] . "</td><td>" . $ens['NOM'] . " " . $ens['PRENOM'] . "</td><td>" . $ens['DESCRIPTION'] . "</td>"
            . "<td>" . $ens['COEFF'] . "</td><td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
            . " onclick = \"deleteEnseignement('" . $ens['IDENSEIGNEMENT'] . "');\"  /></td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tab_mat")) {
        $('#tab_mat').DataTable({
            "paging": false,
            "bInfo": false,
            "scrollY": 300,
            "scrollCollapse": true,
            "columns": [
                {"width": "30%"},
                {"width": "30%"},
                {"width": "15%"},
                {"width": "5%"},
                {"width": "5%"}
            ]
        });
    }
</script>
