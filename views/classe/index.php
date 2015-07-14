<div id="entete"> <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_classe.png"; ?>" /></div>
    <div style="margin-left: 100px; width: 750px">
        <span class="select" style="width: 200px;margin-top: 0"><label>Classe : </label><?php echo $comboClasses; ?></span>
        <span class="text" style="margin-left: 10px;margin: 0; width: 300px;font-weight: bold">Prof. Principal :
            <span id="prof-principal"></span></span> 
        <span  style="margin: 0; font-weight: bold;">CPE. Principal: <span id="cpe-principal"></span></span>
        <span class="text" style="margin-top:0;margin-left: 2px; clear: both; width: 197px;font-weight: bold">Effectif: 
            <span id="effectif">00</span></span>
        <span class="text" style="width: 300px;margin-top: 0;font-weight: bold">Responsable Administratif : 
            <span id="resp-admin"></span></span>
    </div>
</div>
<br style="clear: all" />
<form action="<?php echo url('classe', 'saisie'); ?>" method="post">
    <div class="page" style="">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 4);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Elèves
                    </a>
                </li>
                <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 4);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/enseignant.png"; ?>" />
                        Enseignants
                    </a>
                </li>
                <li id="tab3" class="noncourant">
                    <a onclick="onglets(1, 3, 4);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/emploistemps.png"; ?>" />
                        Emploi du temps
                    </a>
                </li>
                <li id="tab4" class="noncourant"><a onclick="onglets(1, 4, 4);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/caisse.png"; ?>" />
                        Situation financi&egrave;re</a></li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;height: 90%"></div>
        <div id="onglet2" class="onglet" style="display: none;height: 90%"></div>
        <div id="onglet3" class="onglet" style="display: none;height: 90%"></div>
        <div id="onglet4" class="onglet" style="display: none;height: 90%"></div>
    </div>
    
    <div class="navigation">  
        <div class="editions">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0001">Liste simplfi&eacute;e des &eacute;l&egrave;ves</option>
                <option value="0002">Liste d&eacute;taill&eacute;e des &eacute;l&egrave;ves</option>
                <option value="0003">Emploi du temps</option>
            </select>
        </div>
    </div>
</form>
<div class="status">
</div>
