<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
</div>
<script>
    $(document).ready(function () {
        $("#dataTable").DataTable({
            "columns": [
                {"width": "10%"},
                null,
                {"width": "5%"},
                {"width": "15%"},
                {"width": "5%"}
            ],
            "bInfo": false
        });
    });

</script>
<form action="<?php echo Router::url("eleve", "saisie"); ?>" method="post">
    <div class="page">
        <?php
        echo $eleves;
        ?>

    </div>
    <!-- div class="recapitulatif">
        <?php //echo $total . " &eacute;l&egrave;ves"; ?>
    </div !-->
    <div class="navigation">
        <input type="hidden" value="true" name="saisie" />
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" onclick="document.forms[0].submit();" />
    </div>
</form>
<div class="status"></div>
<?php
