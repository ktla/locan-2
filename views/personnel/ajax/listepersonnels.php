<table class="dataTable" id="tablePersonnel">
    <thead><th>Civ.</th><th>Matricule</th><th>Nom</th><th>Pr&eacute;nom</th><th>Fonction</th><th>Portable</th>
    <th></th></thead>
<tbody>
    <?php
    foreach($personnels as $p){
        echo "<tr><td>".$p['CIVILITE']."</td><td>".$p['MATRICULE']."</td>";
        echo "<td><a href = '".Router::url("personnel", "fiche", $p['IDPERSONNEL'])."' >".$p['NOM']."</a></td><td>".$p['PRENOM']."</td><td>".$p['LIBELLE']."</td><td>".$p['PORTABLE']."</td><td>";
        if(isAuth(513)){
            echo "<img style ='cursor:pointer' src = '".img_edit()."' onclick = \"document.location='".Router::url("personnel", "edit", $p['IDPERSONNEL'])."'\" />&nbsp;";
        }else{
            echo "<img style ='cursor:pointer' src = '".img_edit_disabled()."' />&nbsp;";
        }
        if(isAuth(507)){
            echo "<img style ='cursor:pointer' src = '".img_delete()."' onclick =\"deleteRow('".Router::url("personnel", "delete", $p['IDPERSONNEL']), $p['IDPERSONNEL']."')\" />";
        }else{
            echo "<img style ='cursor:pointer' src = '".img_delete_disabled()."' />";
        }
         echo "</td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#tablePersonnel').DataTable({
            "columnDefs": [
                {"width": "4%", "targets": 0},
                {"width": "10%", "targets": 1},
                {"width": "25%", "targets": 2},
                {"width": "25%", "targets": 3},
                {"width": "15%", "targets": 4},
                {"width": "15%", "targets": 5},
                {"width": "6%", "targets": 6}
            ]
        });

    });
</script>