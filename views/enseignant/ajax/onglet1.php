<style>
    .photo-prof{
        position: absolute;
        display: block;
        width: 100px;
        height: 120px;
        right: 0;
        margin-right: 20px;
        margin-top: 5px;
        border: 1px solid #CCC;
        background-color: #F7F7F7;
        border-radius: 5px;
        text-align: center;
        vertical-align: middle;
        line-height: 100px;
    }
</style>
<div class="fiche">
    <fieldset  style="width: 80%;float: none; margin: auto;margin-top: 20px"><legend>Identit&eacute;</legend>
        <img src="<?php echo $photo = ""; ?>" alt="Photo Prof" class="photo-prof">
        <table cellpadding = "5">
            <tr><td style="font-weight: bold">Civilit&eacute; : </td><td><?php echo $personnel['CIVILITE']; ?></td></tr>
            <tr><td width = "20%" style="font-weight: bold">Nom : </td><td><?php echo $personnel['NOM']; ?></td></tr>
            <tr><td style="font-weight: bold">Pr&eacute;nom : </td><td><?php echo $personnel['PRENOM']; ?></td></tr>
            <tr><td style="font-weight: bold">Autre Noms : </td><td><?php echo $personnel['AUTRENOM']; ?></td></tr>
            <tr><td  width = "20%" style="font-weight: bold">Fonction : </td><td>Enseignant</td></tr>
            <tr><td style="font-weight: bold">Grade : </td><td><?php echo $personnel['GRADE'] ?></td></tr>
        </table>
    </fieldset>
    <fieldset style="width: 80%;float: none; margin: auto;margin-top: 20px"><legend>Adresses</legend>
        <table cellpadding = "5">
            
            <tr><td style="font-weight: bold">Portable : </td><td><?php echo $personnel['PORTABLE']; ?></td></tr>
            <tr><td style="font-weight: bold">T&eacute;l&eacute;phone : </td><td><?php echo $personnel['TELEPHONE']; ?></td></tr>
            <tr><td style="font-weight: bold">E-Mail : </td><td><?php echo $personnel['EMAIL']; ?></td></tr>
        </table>

    </fieldset>
</div>