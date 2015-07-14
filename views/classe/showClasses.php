<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_classe.png"; ?>" /></div>
</div>
<script>
    $(document).ready(function () {
        $("#dataTable").DataTable({
            "columns": [
                {"width": "10%"},
                null,
                {"width": "10%"},
                {"width": "5%"}
            ],
            "bInfo": false
        });
    });

</script>
<div class="titre">Liste des classes</div>
<form action="<?php echo Router::url("classe", "saisie"); ?>" method="post">
    <div class="page">
        <?php
        echo $classes;
        ?>

    </div>
    <div class="recapitulatif">
        <?php echo $total . " classes"; ?>
    </div>
    <div class="navigation">
        <input type="hidden" value="true" name="saisie" />
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" onclick="document.forms[0].submit();" />
    </div>
</form>
<div class="status"></div>
<?php
if ($errors) {
    echo "<div style = 'color:red; text-align:center'>Une erreur s'est produite</div>";
}
