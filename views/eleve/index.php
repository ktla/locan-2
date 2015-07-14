<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
    <div style="margin-left: 120px"><span class="select" style="width: 250px">
            <label>Liste des élèves : </label>
            <?php echo $eleves; ?></span>
    </div>
</div>
<div class="titre">
    Elève
</div>
<form action="<?php echo url('eleve', 'saisie'); ?>" method="post">
    <div class="page" style="">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        El&egrave;ve
                    </a>
                </li>
                <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/responsable.png"; ?>" />
                        Responsables
                    </a>
                </li>
                <li id="tab3" class="noncourant">
                    <a onclick="onglets(1, 3, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/emploistemps.png"; ?>" />
                        Emploi du temps
                    </a>
                </li>
                <li id="tab4" class="noncourant">
                    <a onclick="onglets(1, 4, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/viescolaire.png"; ?>" />
                        Vie scolaire
                    </a>
                </li>
                <li id="tab5" class="noncourant">
                    <a onclick="onglets(1, 5, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/note.png"; ?>" />
                        Notes
                    </a>
                </li>
                <li id="tab6" class="noncourant">
                    <a onclick="onglets(1, 6, 6);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/suivi.png"; ?>" />
                        Suivi
                    </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;height: 500px">
            <div class="fiche">
                <fieldset style="width: 80%;float: none; margin: auto;margin-top: 20px"><legend>Identité</legend>
                    <table cellpadding = "5">
                        <tr><td width = "20%" style="font-weight: bold">Nom : </td><td><?php //echo //$nom;    ?></td></tr>
                        <tr><td style="font-weight: bold">Pr&eacute;nom : </td><td><?php //echo// $prenom;    ?></td></tr>
                        <tr><td style="font-weight: bold">Sexe : </td><td><?php //echo //$sexe;    ?></td></tr>
                        <tr><td style="font-weight: bold">Date de naissance : </td><td><?php //echo $datenaiss;    ?></td></tr>
                        <tr><td style="font-weight: bold">Lieu de naissance : </td><td><?php //echo $lieunaiss;    ?></td></tr>
                        <tr><td style="font-weight: bold">Pays de nationalité : </td><td><?php // echo $nationalite;    ?></td></tr>
                    </table>
                </fieldset>
                <fieldset style="width: 80%;float: none; margin: auto;margin-top: 20px;"><legend>Scolarité actuelle</legend>
                    <table  cellpadding = "5">
                        <tr><td  width = "20%" style="font-weight: bold">Classe : </td><td><?php //echo $classe;     ?></td></tr>
                        <tr><td style="font-weight: bold">Redoublant : </td><td><?php //echo $redoublant;     ?></td></tr>
                        <tr><td style="font-weight: bold">Date d'entr&eacute;e : </td><td><?php // echo $dateentree;    ?></td></tr>
                        <tr><td style="font-weight: bold">Provenance : </td><td><?php //echo //$provenance;    ?></td></tr>
                        <tr><td style="font-weight: bold">Date de sortie : </td><td><?php //echo// $datesortie;    ?></td></tr>
                        <tr><td style="font-weight: bold">Motif sortie : </td><td><?php //echo// $motifsortie;    ?></td></tr>
                    </table>

                </fieldset>
            </div>
        </div>
        <div id="onglet2" class="onglet" style="display: none;height: 500px">
            <?php //echo $responsables; ?>
        </div>
        <div id="onglet3" class="onglet" style="display: none;height: 500px">
            <?php //echo $emplois; ?>
        </div>
        <div id="onglet4" class="onglet" style="display: none;height: 500px">
            <?php //echo $viescolaire; ?>
        </div>
        <div id="onglet5" class="onglet" style="display: none;height: 500px"></div>
        <div id="onglet6" class="onglet" style="display: none;height: 500px"></div>
    </div>
    
    <div class="navigation">
        <div class="editions">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0001">Fiche de l'&eacute;l&egrave;ve</option>
                <option value="0003">Sa vie scolaire</option>
                <option value="0004">Liste de ses responsables</option>
                <option value="0005">Tableau des notes</option>
                <option value="0006">Son emploi du temps</option>
            </select>
        </div>
    </div>

</form>
<div class="status">
</div>
