<div id="entete">
    <div style="margin-left: 50px"><span class="select" style="width: 250px;margin: 0"><label>El&egrave;ves : </label>
        <?php echo $comboEleves; ?></span>
        <span class="text" style="width: 100px; margin-left: 10px">Classe : .........</span>
        <span class="text" style="width: 200px; margin: 0">Payement effectu&eacute; : 000 000 FCFA</span><br/><br/>
        
        <span class="text" style="width: 200px; margin: 0">Total &agrave; payer : 000 000 FCFA</span>
    </div>
</div>
<div class="titre">Payement des frais scolaires</div>
<form action="<?php echo Router::url("scolarite", "payement"); ?>" method="post">
    <div class="page">
        <p style="text-align: right;margin: 0"><img id="img-ajout-scolarite" style="cursor: pointer;" src="<?php echo img_add(); ?>" /></p>
        <div id="scolarite-content">
        <table class="dataTable" id="scolariteTable">
            <thead><th>Date</th><th>Description du frais</th><th>Montant du frais</th><th>Montant pay&eacute;</th><th>Reste</th><th></th></thead>
        <tbody></tbody>
        </table>
        </div>
        <div id="scolarite-dialog-form" class="dialog" title="Payement d'une scolarité">
            <span style="width: 100%"><label>Description du frais et son montant:</label><select style="width: 100%" name="comboFrais"><option></option></select></span>
            <span style="width: 100%"><label>R&eacute;f&eacute;rence caisse autorisant cette op&eacute;ration:</label>
                <select style="width: 100%" name="comboCaisses"><option></option></select>
            </span>
            <!-- span style="width: 100%"><label>Montant vers&eacute;: </label><input style="width: 98%" type="text" name="montant" /></span -->
        </div>
    </div>
    <p>Faire des payements de la scolarite, et laisser la possibilite a la caisse de faire une apercu 
        des payement non enregistrer, d'efectuer lùoperation de debit, et de noter cette operation de payement 
        comme enregistrer..</p>
    <div class="recapitulatif"></div>
    <div class="navigation"></div>
</form>
<div class="status"></div>