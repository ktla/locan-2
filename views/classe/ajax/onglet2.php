<table class="dataTable" id="tableEnseignants">
    <thead><tr><th>Civ.</th><th>Noms & Pr&eacute;noms</th><th>E-mail</th><th>Mati&egrave;res</th>
            <th>Coeff.</th></tr></thead>
    <tbody>
        <?php
        foreach($enseignants as $ens){
            echo "<tr><td>".$ens['CIVILITE']."</td><td>".$ens['NOM']." ".$ens['PRENOM']."</td><td>".$ens['EMAIL']."</td>";
            echo "<td>".$ens['MATIERELIBELLE']."</td><td>".$ens['COEFF']."</tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableEnseignants")) {
           $("#tableEnseignants").DataTable({
               bInfo: false,
               paging: false,
              "columns": [
                  {"width" : "5%"},
                  null,
                  {"width" : "20%"},
                  null,
                  {"width" : "5%"}
              ]
           });
       } 
    });
</script>