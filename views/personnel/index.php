<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_personnel.png"; ?>" /></div>
    <div style="margin-left: 70px;">
        <span class="select" style="width: 300px; margin-left: 120px;"><label>Fonction : </label><?php echo $fonctions; ?></span>
    </div>
</div>
<form action="<?php echo Router::url("personnel", "saisie"); ?>" name="frmpersonnel">
    <div class="page">

        <!-- div class="breadcrumb"><a href ="">Document</a><a  href ="">Document</a><a href ="">Document</a></div -->

        <?php
        if (!$personnels) {
            echo "Aucune donnée à afficher";
        } else {

            echo $personnels;
        }
        ?>
    </div>
    
    <div class="navigation">
        <?php if(isAuth(502)){ ?>
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" onclick="document.forms[0].submit();" />
        <?php } ?>
    </div>
</form>
<div class="status"></div>