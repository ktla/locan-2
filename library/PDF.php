<?php

class PDF extends TCPDF {

    private $logo;

    /**
     * Est ce que la page est en portrait, permet la modification apres le constructeur
     * @var type 
     */
    public $isLandscape = false;

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4') {
        parent::__construct($orientation, $unit, $format, true, 'UTF-8', false);
        $this->fontpath = SITE_ROOT . "library/tcpdf/fonts";
        $this->logo = SITE_ROOT . "public/img/logo.jpg";
    }

    //Page header
    public function Header() {
       
        $header_gauche = <<<EOD
                <p style = "text-align:center;line-height: 10px">
                    Minist&egrave;re des Enseignements Secondaires<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation R&eacute;gionale du Centre<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation D&eacute;partementale de la MEFOU<br/>
                                AFAMBA<br/>
                                *************<br/>
                    <b>INSTITUT POLYVALENT WAGU&Eacute;</b><br/>
                    <i>Autorisation d'ouverture N° 79/12/MINESEC</i><br/>
                    BP 5062 YAOUNDE<br/>
                    T&eacute;l&eacute;phone: +237 97 86 84 99<br/>
                    Email: <a href ="maito:institutwague@yahoo.fr">institutwague@yahoo.fr</a><br/>
                    <a href = "http://wwww.institutwague.com">www.institutwague.com</a>
                </p>
                        
EOD;
        $this->SetFontSize(9);

        $this->writeHTMLCell(70, 50, 2, 5, $header_gauche);
        
        //$this->writeHTML($header_gauche);
        if ($this->isLandscape) {
            $this->Image($this->logo, 130, 5, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            $this->Image($this->logo, 90, 5, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
        //$this->WriteHTML
        $header_droit = <<<EOD
                <p style = "text-align:center">R&eacute;publique du Cameroun<br/>
                    <i>Paix-Travail-Patrie<br/>***********</p>
EOD;
        if ($this->isLandscape) {
             $this->writeHTMLCell(50, 50, 230, 5, $header_droit);
        } else {
            $this->writeHTMLCell(50, 50, 155, 5, $header_droit);
        }
        $this->SetFont('helvetica', 'B', 20);
        // set document information
        $this->SetCreator("BAACK Group");
        $this->SetAuthor('BAACK Group');
        # set auto page breaks
        //$this->CEll
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        # $this->writeHTMLCell(50, 50, 20, 20, $this->GetY(), 1);
    }

    /**
     * Fonction defini comme entete pour les page en paysage,
     * le rendu par defaut qui est celui en portrait est defini dans la fonction Header
     */
    public function LandScapeHeader() {
        $header_gauche = <<<EOD
                <p style = "text-align:center">
                    Minist&egrave;re des Enseignements Secondaires<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation R&eacute;gionale du Centre<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation D&eacute;partementale de la MEFOU<br/>
                                AFAMBA<br/>
                                *************<br/>
                    <b>INSTITUT POLYVALENT WAGU&Eacute;</b><br/>
                    <i>Autorisation d'ouverture N° 79/12/MINESEC</i><br/>
                    BP 5062 YAOUNDE<br/>
                    T&eacute;l&eacute;phone: +237 97 86 84 99<br/>
                    Email: <a href ="maito:institutwague@yahoo.fr">institutwague@yahoo.fr</a><br/>
                    <a href = "http://wwww.institutwague.com">www.institutwague.com</a>
                </p>
                        
EOD;
        $this->SetFontSize(10);
        $this->writeHTMLCell(80, 30, 5, 5, $header_gauche);

        //$this->writeHTML($header_gauche);
        $this->Image($this->logo, 130, 5, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        //$this->WriteHTML
        $header_droit = <<<EOD
                <p style = "text-align:center">R&eacute;publique du Cameroun<br/>
                    <i>Paix-Travail-Patrie<br/>***********</p>
EOD;
        $this->writeHTMLCell(70, 50, 230, 5, $header_droit);
        $this->SetFont('helvetica', 'B', 20);
        // set document information
        $this->SetCreator("BAACK Group");
        $this->SetAuthor('BAACK Group');

        # set auto page breaks
        //$this->CEll
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    }

    /**
     *  Page footer
     */
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function LandScapeFooter() {
        
    }

}
