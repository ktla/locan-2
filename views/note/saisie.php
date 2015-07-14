<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_classe.png"; ?>" /></div>
    <div style="margin-left: 90px; width: 650px; height: 80px">
        <span class="select" style="width: 200px; margin: 0 10px 0;"><label>Classes : </label><?php echo $comboClasses; ?></span>
        <span class="select" style="width: 200px; margin: 0 10px 0"><label>Enseignements - Mati&egrave;res :</label>
            <select name="comboEnseignements"><option></option></select></span>
        <span class="text" style="width: 150px; margin-top: 0"><label>Date du devoir</label><div style="margin-top: 10px" id="datedevoir"></div></span>
        
        <span class="select" style="width: 200px; margin: 0 10px 0"><label>Libell&eacute; du devoir : </label>
            <?php echo $comboTypes ?></span>
        
        <span class="select" style="width: 200px; margin: 0 10px 0"><label>P&eacute;riode : </label><?php echo $comboPeriodes; ?></span>
        <span class="text" style="width: 50px; margin: 0"><label>Note sur : </label>
            <input type="text" value="20" name="notesur" style="text-align: right" /></span>
        <span class="text" style="width: 50px; margin: 0 20px 0"><label>Coef.</label>
            <input style="text-align: right" type="text" value="00" name="coeff" disabled="disabled" /></span>
    </div>
</div>
<form action="<?php echo Router::url("note", "saisie"); ?>" method="post" name="saisienotes" >
    <div class="page">
        <div id="preciser-libelle-dialog-form" class="dialog" title="Pr&eacute;ciser le libell&eacute; du devoir">
             <span><label>Libell&eacute; du devoir</label>
                 <input style="width: 100%" type="text" name="libelle" /></span>
        </div>
        <input type="hidden" name="description" value="" />
        <input type="hidden" name="datedevoir" value="" />
        <div id="eleve-content">
            <table class="dataTable" id="eleveTable">
                <thead><th>Matricule</th><th>Noms & Pr&eacute;noms</th><th>Note</th><th>Absent</th><th>Non not&eacute;</th><th>Observations</th></thead>
                <tbody>
                </tbody></table>
        </div>
    </div>
    <div class="navigation">
        <div class="editions" style="float: left">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0001">Imprimer une fiche de report de note vierge</option>

            </select>
        </div>
        <?php
        //Droit recapitulatif des notes
        if (isAuth(401)) {
            echo btn_ok("soumettreNotes();");
        }
        ?>
    </div>
</form>
<div class="status"></div>