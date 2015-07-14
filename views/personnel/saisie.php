<div id="entete">
<div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisiepersonnel.png"; ?>" /></div>
</div>
<script>
   $(document).ready(function(){
       calendrier = getCalendar("date");
   });
</script>
<div class="titre">
    Saisie d'un nouvel Personnel
</div>
<form action="<?php echo url("personnel", "saisie"); ?>" method="post" >
    <div class="page">
        <fieldset style="width: 700px;float: none; margin: auto;"><legend> Identit&eacute;</legend>
            <span class="select" style="width: 150px;">
                <label>Civilit&eacute;</label>
                <?php echo $civilite; ?>
            </span>
            <span class="text" style="width: 182px;">
                <label> Nom </label>
                <input type="text" name="nom" maxlength="30"  />
            </span>
            <span class="text" style="width: 150px">
                <label> Pr&eacute;nom</label>
                <input type="text" name="prenom" maxlength="30" />
            </span>
            <span class="text" style="width: 150px">
                <label>Autre noms</label>
                <input type="text" name="autrenom" maxlength="30" />
            </span>
            <span class="select" style="width: 150px;">
                <label>Fonction</label>
                <?php echo $fonctions; ?>
            </span>
            <span class="text" style=" width: 350px;">
                <label>Grade</label>
                <input type="text" class="grade" name="grade" maxlength="15" />
            </span>
            <span class="text" style="width: 150px;">
                <label>Date de naissance</label>
                <div id="date" style="margin-top: 10px;"></div>
                <input type="hidden" id="datenaiss" name="datenaiss" value="" />
            </span>
            <span class="text" style="width: 145px;margin-right: 22px">
                <label>Portable</label>
                <input type="text" name="portable" maxlength="15" />
            </span>
            <span class="text" style="width: 182px;">
                <label>T&eacute;l&eacute;phone</label>
                <input type="text" name="telephone"  maxlength="15"/>
            </span>
            <span class="text" style="width: 150px">
                <label>Email</label>
                <input type="text" name="email" maxlength="15"/>
            </span>
        </fieldset>
    </div>

    <div class="recapitulatif">
        <?php
        if ($errors) {
            echo "<div class='error'>$message</div>";
        }
        ?>

    </div>
    <div class="navigation">
        <?php 
         if (isAuth(502)) {
             echo btn_ok("submitForm();");
         }
         if(isAuth(203)){
            echo btn_cancel("document.location=\"" . Router::url("personnel") . "\"");
        }else{
            echo btn_cancel_disabled();
        } 
        ?>
    </div>

</form>
<div class="status"></div>
