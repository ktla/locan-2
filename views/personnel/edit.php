<div id="entete">

</div>
<script>
   $(document).ready(function(){
       calendrier = getCalendar("date");
       calendrier.setDate(<?php echo $personnel['DATENAISS']; ?>);
   });
</script>
<div class="titre">
    Modification du personnel <?php echo $personnel['NOM']." ".$personnel['PRENOM']; ?>
</div>
<form action="<?php echo url("personnel", "edit", $personnel['IDPERSONNEL']); ?>" method="post" >
    <div class="page">
        <fieldset style="width: 700px;float: none; margin: auto;"><legend> Identit&eacute;</legend>
            <input type="hidden" name="idpersonnel" value="<?php echo $personnel['IDPERSONNEL']; ?>" />
            <span class="select" style="width: 150px;">
                <label>Civilit&eacute;</label>
                <?php echo $civilite; ?>
            </span>
            <span class="text" style="width: 182px;">
                <label> Nom </label>
                <input type="text" name="nom" maxlength="30" value="<?php echo $personnel['NOM']; ?>"  />
            </span>
            <span class="text" style="width: 150px">
                <label> Pr&eacute;nom</label>
                <input type="text" name="prenom" maxlength="30" value="<?php echo $personnel['PRENOM']; ?>" />
            </span>
            <span class="text" style="width: 150px">
                <label>Autre noms</label>
                <input type="text" name="autrenom" maxlength="30" value="<?php echo $personnel['AUTRENOM']; ?>" />
            </span>
            <span class="select" style="width: 150px;">
                <label>Fonction</label>
                <?php echo $fonctions; ?>
            </span>
            <span class="text" style=" width: 350px;">
                <label>Grade</label>
                <input type="text" class="grade" name="grade" value="<?php echo $personnel['GRADE']; ?>" maxlength="15" />
            </span>
            <span class="text" style="width: 150px;">
                <label>Date de naissance</label>
                <div id="date" style="margin-top: 10px;"></div>
                <input type="hidden" id="datenaiss" name="datenaiss" value="" />
            </span>
            <span class="text" style="width: 145px;margin-right: 22px">
                <label>Portable</label>
                <input type="text" name="portable" maxlength="15" value="<?php echo $personnel['PORTABLE']; ?>" />
            </span>
            <span class="text" style="width: 182px;">
                <label>T&eacute;l&eacute;phone</label>
                <input type="text" name="telephone" value="<?php echo $personnel['TELEPHONE']; ?>" maxlength="15"/>
            </span>
            <span class="text" style="width: 150px">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $personnel['EMAIL']; ?>" maxlength="15"/>
            </span>
        </fieldset>
    </div>

    <div class="recapitulatif">
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
