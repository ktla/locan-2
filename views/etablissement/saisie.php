<div id="entete">

</div>
<div class="titre">
    Saisie des param&egrave;tres de l'&eacute;tablissement
</div>
<form action="<?php echo Router::url("etablissement", "saisie"); ?>" method="post" enctype="multipart/form-data" >
    <div class="page">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 2);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/etablissement.png"; ?>" />
                        Identit&eacute;
                    </a>
                </li>
                <li id="tab2" class="noncourant" >
                    <a onclick="onglets(1, 2, 2)">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/photo.png"; ?>" />
                        Logo
                    </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;">

            <fieldset style="display: block; position: relative; width: 95%; left: 7px; margin-top: 10px;"><legend>Identit&eacute;</legend>
                <span class="text" style="position: relative; display: inline-block; width: 95%"><label>Identifiant</label><input type="text" name="identifiant" /></span>
                <span class="text" style="position: relative; display: inline-block; width: 95%"><label>Nom</label><input type="text" name="nom" /></span>

            </fieldset>
            <fieldset style="display: block; position: relative;width: 95%;left: 7px; margin-top: 15px; "><legend>Coordonn&eacute;es</legend>
                <div style="float: left; width: 45%; padding: 15px;">
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Adresse</label><input type="text" name="adresse" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Boite Postal</label><input type="text" name="bp" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Email</label><input type="text" name="email" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Site web</label><input type="text" name="siteweb" /></span>
                </div>
                <div style=" float: left; width: 45%; padding: 15px; margin-left: 15px; ">
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Tel. 1</label><input type="text" name="tel1" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Tel. 2</label><input type="text" name="tel2" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Mobile</label><input type="text" name="mobile" /></span>
                    <span class="text" style="position: relative; display: block;width: 100%;"><label>Fax</label><input type="text" name="fax" /></span>
                </div>
            </fieldset>
            <fieldset style="display: block; position: relative;width: 95%;left: 7px; margin-top: 15px;"><legend>Chef d'&eacute;tablissement</legend>
                <span class="text"  style="position: relative; display: inline-block; width: 95%; "><label>Responsable</label><input type="text" name="responsable" /></span>
            </fieldset>
        </div>
        <div id="onglet2" class="onglet" style="display: none; height: 80%">
            <span class="text" style="position: relative; display: inline-block; width: 95%" > <label>Logo</label><input type="file" name="logo" /></span>
        </div>
    </div>
    <div class="recapitulatif">
        <?php
        if ($errors) {
            echo $message;
        }
        ?>
    </div>
    <div class="navigation">
        <img src="<?php echo SITE_ROOT . "public/img/btn_ok.png"; ?>" onclick="document.forms[0].submit();" />
        <?php if (isAuth(201)) { ?>
            <img src="<?php echo SITE_ROOT . "public/img/btn_cancel.png"; ?>" onclick="document.location = '<?php echo Router::url("etablissement"); ?>'" />
        <?php } ?>

    </div>
</form>
<div class="status">

</div>