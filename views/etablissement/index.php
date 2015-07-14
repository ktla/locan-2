<style>
    .onglet fieldset{
        display: block;
        position: relative;
        margin: 15px 0 0 15%;
        width: 50%;
    }
    .onglet fieldset p a{
        color : #B63B00;
        text-decoration: none;
        cursor: pointer;
        font-size: 12px;      
    }
    .onglet fieldset p{
        font-weight: bold;
        font-size: 14px;
        padding-left: 50px;
    }
    .onglet fieldset p label{
        font-size: 12px;
    }
</style>
<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_etablissement.png";  ?>" /></div>
</div>
<div class="titre">
    Informations relatives &agrave; l'&eacute;tablissement
</div>
<div class="page">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant">
                <a onclick="onglets(1, 1, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/etablissement.png"; ?>" />
                    Etablissement
                </a>
            </li>
            <li id="tab2" class="noncourant">
                <a onclick="onglets(1, 2, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/personnel.png"; ?>" />
                    Personels
                </a>
            </li>
            <li id="tab3" class="noncourant">
                <a onclick="onglets(1, 3, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                    Elèves
                </a>
            </li>

        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block;">
        <fieldset style="margin-top: 5%;"><legend>Etablissement</legend>
            <img src="<?php echo SITE_ROOT . "public/img/ipw.png"; ?>" width="78" height="78" style="float:right;" >
            <p class="text"><?php echo $ets; ?></p>
            <p style=" position: relative; top: 15px; font-size: 12px;">Site Web : <a href="http://www.institutpolyvalentwague.com/">http://www.institutpolyvalentwague.com</a></p>
        </fieldset>
        <fieldset><legend>Responsable</legend>
            <p><?php echo $responsable; ?></p>
        </fieldset>
        <fieldset><legend>Adresse</legend>
            <p><?php echo $adresse; ?></p>
        </fieldset>
        <fieldset><legend>Coordonn&eacute;es</legend>
            <p><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel:&nbsp;</label><?php echo $tel1 . " / " . $tel2; ?></p>
            <p><label>Mobile:&nbsp;</label><?php echo $mobile; ?></p>
            <p style="margin-top: 20px;"><label>&nbsp;&nbsp;Email:&nbsp;</label><a href=""><?php echo $email; ?></a></p>
        </fieldset>
    </div>
    <div id="onglet2" class="onglet" style="display: none;">
        <?php echo $personnels; ?>
    </div>
    <div id="onglet3" class="onglet" style="display: none;">
        <?php echo $eleves; ?>
    </div>
</div>

<div class="navigation">
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Informations de l'&eacute;tablissement</option>
            <option value="0002">Liste simplifi&eacute;e des &eacute;l&egrave;ves</option>
            <option value="0003">Liste d&eacute;taill&eacute;e des &eacute;l&egrave;ves</option>
            <option value="0004">Liste simplifi&eacute;e du personnels</option>
            <option value="0005">Liste d&eacute;taill&eacute;e du personnels</option>
        </select>
    </div>
</div>
<div class="status"></div>