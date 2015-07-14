<?php

class Menus extends Database {

    public function __construct() {
        $this->setDroits();
        parent::__construct();
    }

    /**
     * Obtenir la liste des droits de l'utilisateur connected
     * En fonction de son profil
     * Sa liste des droits = a la liste des droit du groupe 
     * auquel il fait parti + ses droit specifiq
     */
    public function setDroits() {
        //if (!isset($_SESSION['droits']) || empty($_SESSION['droits'])) {
            $user = $_SESSION['user'];
            $query = "SELECT DROITSPECIFIQUE FROM users WHERE LOGIN = :login";
            $_SESSION['droits'] = json_decode($this->single($query, ["login" => $user]));
       // }
    }

    public function getMenus() {

        $droits = json_encode($_SESSION['droits']);
        $droits = str_replace("\\", "", $droits);
        $droits = str_replace("\"", "'", $droits);
        $droits = substr($droits, 0, strlen($droits) - 1);
        $droits = substr($droits, - strlen($droits) + 1);

        $groupes = $this->query("SELECT * FROM groupemenus ORDER BY IDGROUPE");
        $str = "<ul id='menu-accordeon'>";
        foreach ($groupes as $groupe) {
            $query = "SELECT m.* FROM menus m "
                    . "WHERE m.CODEDROIT IN ($droits) "
                    . "AND m.IDGROUPE = :groupe";
            $menus = $this->query($query, ["groupe" => $groupe['IDGROUPE']]);
            if (count($menus) > 0) {
                $str .= "<li><p><img src = '" . SITE_ROOT . "public/img/" . $groupe['ICON'] . "' alt = '" . $groupe['ALT'] . "' title = '" . $groupe['TITLE'] . "' />"
                        . "<a>" . $groupe['LIBELLE'] . "</a></p><ul>";
            }
            foreach ($menus as $menu) {
                $str .= "<li><a href = '" . SITE_ROOT . $menu['HREF'] . "'><img src ='" . SITE_ROOT . "public/img/icons/" . $menu['ICON'] . "' alt ='" . $menu['ALT'] . "' title = '" . $menu['TITLE'] . "' />"
                        . "<span>" . $menu['LIBELLE'] . "</span></a></li>";
            }
            if (count($menus) > 0) {
                $str .= "</ul></li>";
            }
        }
        $str .= "</ul>";
        return $str;
    }

}
