<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestion des activités académique</title>
        <link href = "<?php echo SITE_ROOT; ?>public/img/favicon.ico" rel = "shortcut icon" type = "image/vnd.microsoft.icon" />
        <link href = "<?php echo SITE_ROOT; ?>public/css/style.css" rel = 'stylesheet' type = 'text/css' />
        <link href = "<?php echo SITE_ROOT; ?>public/css/jquery.datetimepicker.css" rel = 'stylesheet' type = 'text/css' />
        <?php
        global $css;
        if (!empty($css)) {
        echo $css;
        }
        ?><script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/scripts.js"></script>
        <?php echo $clientsjs; ?>
        <?php
        global $_JS;
        if (!empty($_JS)) {
            echo "<script>$_JS</script>";
        }
        ?>
      </head>
    <body>
        <div id="container">
           <?php
            echo $header;
            if ($authentified) {
                echo '<div id = "page-content">' . $content . '</div>';
            } else {
                echo '<div id = "page-connect">' . $content . "</div>";
            }
            ?>

            <div id="page-footer">
                <?php echo $footer; ?>
            </div>
            <div id="loading"><p>
                    <img src="<?php echo SITE_ROOT . "public/img/loading.gif" ?>" />
                </p>
            </div>
        </div>
        <!-- Inclure late loading fichier JS -->
         
    </body>
</html>
<?php
/*
 *  <!-- tous les includes doivent se passer dans le controller
        Correspondant et l'obtenir sous la forme d'une variable data[];
         Pour le cas du template, c'est le controller de base
            -->
 */