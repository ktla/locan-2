<?php

class connexionController extends Controller {

    public function __construct() {
        parent::__construct();

        if (isset($this->session->user)) {
            header("Location:" . Router::url("connexion", "disconnect"));
        }
    }

    public function index() {
        $this->view->clientsJS("connexion" . DS . "index");
        $view = new View();
        $view->Assign("errors", false);
        $view->setCSS("public/css/connexion.css");
        //le formulaire est soumis
        if (isset($this->request->login) && isset($this->request->pwd)) {

            if ($this->Connexion->authenticate($this->request->login, md5($this->request->pwd)) === TRUE) {

                $_SESSION['user'] = $this->request->login;
                //Definir la valeur du Timeout lors de la connexion a 10 min
                $_SESSION['timeout'] = time() + TIME_OUT;
                $_SESSION['anneeacademique'] = $this->request->anneeacademique;
                //Garder la trace de connexion dans la table connexion
                $this->keepTrack();
                if (isset($_SESSION['activeurl'])) {

                    header("Location:" . $_SESSION['activeurl']);
                } else {
                    header("Location:" . SITE_ROOT);
                }
            } else {
                $view->Assign("errors", true);
            }
        }

        $view->Assign("post", $this->request);

        $this->loadModel("anneeacademique");

        $anneeAcad = $this->Anneeacademique->selectAll();

        $anneeacademique = new Combobox($anneeAcad, "anneeacademique", "ANNEEACADEMIQUE", "ANNEEACADEMIQUE");
        $view->Assign("anneeacademique", $anneeacademique->view());

        $content = $view->Render("connexion" . DS . "index", false);

        $this->Assign("content", $content);
    }

    public function disconnect() {
        //S'il n'est meme pas connecter et essaye d'ouvrir l'action disconnect
        //le redireger ver la page de connexion
        if (!isset($this->session->user)) {
            header("Location:" . url("connexion"));
        }

        $id = $this->session->idconnexion;
        $connexion = "Connexion réussie";
        /** il a deborder, sa session est expiree */
        if ($this->session->timeout <= time()) {
            $datefin = date("Y-m-d H:i:s", $this->session->timeout);
            $deconnexion = "Session expriée";
        } else {
            /** Il s'est deconnecter durant sa session normale */
            $deconnexion = "Session fermée correctement";
            $datefin = date("Y-m-d H:i:s", time());
        }
        //updateConnexion($idconnexion, $connexion, $datefin, $deconnexion)
        $this->Connexion->updateConnexion($id, $connexion, $datefin, $deconnexion);
        unset($_SESSION['user']);
        unset($_SESSION['profile']);
        unset($_SESSION['droits']);
        unset($_SESSION['timeout']);
        unset($_SESSION['idconnexion']);
        unset($_SESSION['idprofile']);
        session_destroy();
        header("Location:" . Router::url('connexion'));
    }

    public function keepTrack() {
        //Utiliser le cookie pour gerer cette affaire de deconnexion
        //la session est perdu quand on ferme le navigateur et du coup, j'arrive pas update le libelle de la deconnexion et de
        //de la date de fin parce q session user est non defini
        //Connexion($compte, $datedebut, $machine, $ipsource, $connexion, $datefin, $deconnexion)
        $ip = $this->input->server('REMOTE_ADDR');
        $machine = gethostbyaddr($ip);

        $con = new Connexion($_SESSION['user'], date("Y-m-d H:i:s", time()), $machine, $ip, "Session en cours");
        return $this->Connexion->saveConnexion($con);
    }

}
