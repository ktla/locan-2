-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 14 Juillet 2015 à 18:28
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `locan`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE IF NOT EXISTS `absences` (
  `IDABSENCE` int(11) NOT NULL AUTO_INCREMENT,
  `APPEL` int(11) NOT NULL,
  `ELEVE` int(11) NOT NULL,
  `ETAT` varchar(250) NOT NULL COMMENT 'JSON object A= Absent, R = Retard suivi de l''heure du retard',
  `HORAIRE` varchar(50) DEFAULT NULL COMMENT '1ere heure, 2nde heure etc....',
  `JUSTIFIER` int(11) DEFAULT NULL COMMENT 'si cette absence est justifier (Null si non justifier; idjustification si c est justifier',
  PRIMARY KEY (`IDABSENCE`),
  KEY `IDELEVE` (`ELEVE`),
  KEY `IDAPPEL` (`APPEL`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Contenu de la table `absences`
--

INSERT INTO `absences` (`IDABSENCE`, `APPEL`, `ELEVE`, `ETAT`, `HORAIRE`, `JUSTIFIER`) VALUES
(42, 24, 82, 'R', '2', 27),
(43, 24, 82, 'A', '3', 26),
(44, 24, 77, 'A', '4', 21),
(45, 24, 28, 'R', '3', 28),
(46, 24, 31, 'E', '2', NULL),
(52, 25, 25, 'A', '1', NULL),
(53, 25, 28, 'A', '2', NULL),
(54, 25, 31, 'R', '3', NULL),
(55, 25, 34, 'E', '2', NULL),
(56, 19, 77, 'A', '2', NULL),
(57, 19, 77, 'A', '4', NULL),
(58, 19, 25, 'A', '3', NULL),
(59, 19, 31, 'A', '4', NULL),
(60, 19, 34, 'A', '3', NULL),
(61, 26, 77, 'A', '1', NULL),
(62, 26, 77, 'A', '2', NULL),
(63, 26, 77, 'A', '3', NULL),
(64, 26, 77, 'A', '4', NULL),
(65, 26, 77, 'A', '5', NULL),
(66, 26, 77, 'A', '6', NULL),
(67, 26, 77, 'A', '7', NULL),
(68, 26, 27, 'A', '2', NULL),
(69, 26, 28, 'R', '3', NULL),
(70, 27, 29, 'A', '4', NULL),
(71, 27, 29, 'E', '6', NULL),
(72, 27, 31, 'A', '3', NULL),
(73, 27, 32, 'E', '3', NULL),
(74, 27, 33, 'A', '4', NULL),
(75, 27, 35, 'E', '4', NULL),
(76, 27, 37, 'E', '3', NULL),
(85, 29, 81, 'E', '4', NULL),
(86, 29, 26, 'E', '3', NULL),
(87, 29, 27, 'E', '4', NULL),
(88, 30, 82, 'A', '3', NULL),
(89, 30, 77, 'A', '1', NULL),
(90, 30, 77, 'A', '5', NULL),
(91, 30, 30, 'R', '1', NULL),
(92, 30, 30, 'A', '3', NULL),
(93, 30, 31, 'E', '2', NULL),
(99, 31, 25, 'E', '1', NULL),
(100, 31, 27, 'A', '2', NULL),
(101, 31, 27, 'R', '4', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `anneeacademique`
--

CREATE TABLE IF NOT EXISTS `anneeacademique` (
  `ANNEEACADEMIQUE` varchar(15) CHARACTER SET utf8 NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `VERROUILLER` int(2) NOT NULL DEFAULT '0' COMMENT '0=Non verrouiller, 1 = verrouiller',
  PRIMARY KEY (`ANNEEACADEMIQUE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `anneeacademique`
--

INSERT INTO `anneeacademique` (`ANNEEACADEMIQUE`, `DATEDEBUT`, `DATEFIN`, `VERROUILLER`) VALUES
('2013-2014', '2013-10-02', '2014-06-30', 1),
('2014-2015', '2014-09-01', '2015-07-31', 0),
('2015-2016', '2015-09-01', '2016-05-27', 0);

-- --------------------------------------------------------

--
-- Structure de la table `appels`
--

CREATE TABLE IF NOT EXISTS `appels` (
  `IDAPPEL` int(11) NOT NULL AUTO_INCREMENT,
  `CLASSE` int(11) NOT NULL,
  `DATEJOUR` date NOT NULL,
  `REALISERPAR` int(11) DEFAULT NULL COMMENT 'idpersonnel qui realise l appel',
  `DATEMODIF` date DEFAULT NULL,
  `MODIFIERPAR` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDAPPEL`),
  KEY `IDCLASSE` (`CLASSE`),
  KEY `REALISERPAR` (`REALISERPAR`),
  KEY `MODIFIERPAR` (`MODIFIERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `appels`
--

INSERT INTO `appels` (`IDAPPEL`, `CLASSE`, `DATEJOUR`, `REALISERPAR`, `DATEMODIF`, `MODIFIERPAR`) VALUES
(7, 1, '2015-06-01', 1, '0000-00-00', NULL),
(8, 1, '2015-06-01', 1, '0000-00-00', NULL),
(9, 1, '2015-06-01', NULL, '0000-00-00', NULL),
(11, 1, '2015-07-01', NULL, '0000-00-00', NULL),
(12, 1, '2015-06-29', NULL, '0000-00-00', NULL),
(19, 1, '2015-07-07', 1, '2015-07-08', 5),
(24, 1, '2015-07-09', 1, NULL, NULL),
(25, 1, '2015-07-08', 1, '2015-07-09', 1),
(26, 1, '2015-07-13', 1, NULL, NULL),
(27, 1, '2015-07-14', 1, NULL, NULL),
(29, 1, '2015-07-16', 1, NULL, NULL),
(30, 1, '2015-07-17', 1, NULL, NULL),
(31, 1, '2015-07-15', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `caisses`
--

CREATE TABLE IF NOT EXISTS `caisses` (
  `IDCAISSE` int(11) NOT NULL AUTO_INCREMENT,
  `JOURNAL` int(11) DEFAULT NULL,
  `COMPTE` int(11) NOT NULL,
  `TYPE` char(1) NOT NULL COMMENT 'D = pour debit et C = pour credit',
  `REFTRANSACTION` varchar(50) NOT NULL DEFAULT 'CASH',
  `REFCAISSE` varchar(30) NOT NULL COMMENT 'Chaine de caractere generer au hazar',
  `DESCRIPTION` varchar(150) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `DATETRANSACTION` date NOT NULL,
  `REALISERPAR` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`IDCAISSE`),
  KEY `COMPTE` (`COMPTE`),
  KEY `JOURNAL` (`JOURNAL`),
  KEY `REALISERPAR` (`REALISERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `caisses`
--

INSERT INTO `caisses` (`IDCAISSE`, `JOURNAL`, `COMPTE`, `TYPE`, `REFTRANSACTION`, `REFCAISSE`, `DESCRIPTION`, `MONTANT`, `DATETRANSACTION`, `REALISERPAR`) VALUES
(1, 1, 1, 'C', 'CASH', 'SC000140017', 'Inscription pour l''annee academique 2015-2016', 150000, '2015-06-14', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `charge`
--

CREATE TABLE IF NOT EXISTS `charge` (
  `IDCHARGE` varchar(15) NOT NULL,
  `LIBELLE` varchar(150) NOT NULL,
  PRIMARY KEY (`IDCHARGE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `charge`
--

INSERT INTO `charge` (`IDCHARGE`, `LIBELLE`) VALUES
('Accident', 'Resp. à prévénir en cas d''accident'),
('Contact', 'Resp. contact'),
('Financier', 'Resp. financier');

-- --------------------------------------------------------

--
-- Structure de la table `civilite`
--

CREATE TABLE IF NOT EXISTS `civilite` (
  `CIVILITE` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`CIVILITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `civilite`
--

INSERT INTO `civilite` (`CIVILITE`) VALUES
('Dr'),
('Mlle'),
('Mme'),
('Mr');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `IDCLASSE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(150) NOT NULL,
  `DECOUPAGE` int(11) DEFAULT NULL,
  `NIVEAU` int(11) DEFAULT NULL,
  `ANNEEACADEMIQUE` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`IDCLASSE`),
  KEY `DECOUPAGE` (`DECOUPAGE`),
  KEY `NIVEAU` (`NIVEAU`),
  KEY `classes_ibfk_2` (`ANNEEACADEMIQUE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `classes`
--

INSERT INTO `classes` (`IDCLASSE`, `LIBELLE`, `DECOUPAGE`, `NIVEAU`, `ANNEEACADEMIQUE`) VALUES
(1, 'Sixième', 1, 6, '2014-2015'),
(2, 'Sixieme B', 1, 7, '2013-2014'),
(3, 'Terminale A', 1, 0, '2014-2015');

-- --------------------------------------------------------

--
-- Structure de la table `classes_parametres`
--

CREATE TABLE IF NOT EXISTS `classes_parametres` (
  `IDPARAMETRE` int(11) NOT NULL AUTO_INCREMENT,
  `CLASSE` int(11) DEFAULT NULL,
  `PROFPRINCIPALE` int(11) DEFAULT NULL,
  `CPEPRINCIPALE` int(11) DEFAULT NULL,
  `RESPADMINISTRATIF` int(11) DEFAULT NULL,
  `ANNEEACADEMIQUE` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`IDPARAMETRE`),
  UNIQUE KEY `IDCLASSE_2` (`CLASSE`,`PROFPRINCIPALE`,`CPEPRINCIPALE`,`RESPADMINISTRATIF`,`ANNEEACADEMIQUE`),
  KEY `IDCLASSE` (`CLASSE`,`PROFPRINCIPALE`,`CPEPRINCIPALE`,`RESPADMINISTRATIF`,`ANNEEACADEMIQUE`),
  KEY `PROFPRINCIPALE` (`PROFPRINCIPALE`),
  KEY `CPEPRINCIPALE` (`CPEPRINCIPALE`),
  KEY `RESPADMINISTRATIF` (`RESPADMINISTRATIF`),
  KEY `ANNEEACADEMIQUE` (`ANNEEACADEMIQUE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Contenu de la table `classes_parametres`
--

INSERT INTO `classes_parametres` (`IDPARAMETRE`, `CLASSE`, `PROFPRINCIPALE`, `CPEPRINCIPALE`, `RESPADMINISTRATIF`, `ANNEEACADEMIQUE`) VALUES
(57, 1, 3, 54, 3, NULL),
(58, 2, 3, 54, 3, NULL),
(59, 3, 5, 53, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comptes_eleves`
--

CREATE TABLE IF NOT EXISTS `comptes_eleves` (
  `IDCOMPTE` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(15) NOT NULL,
  `ELEVE` int(11) NOT NULL,
  `CREERPAR` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`IDCOMPTE`),
  KEY `ELEVE` (`ELEVE`),
  KEY `CREERPAR` (`CREERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `comptes_eleves`
--

INSERT INTO `comptes_eleves` (`IDCOMPTE`, `CODE`, `ELEVE`, `CREERPAR`) VALUES
(1, 'SAINJEA001', 74, 'armel');

-- --------------------------------------------------------

--
-- Structure de la table `connexions`
--

CREATE TABLE IF NOT EXISTS `connexions` (
  `IDCONNEXION` int(11) NOT NULL AUTO_INCREMENT,
  `COMPTE` varchar(30) CHARACTER SET latin1 NOT NULL,
  `DATEDEBUT` datetime NOT NULL,
  `MACHINESOURCE` varchar(100) CHARACTER SET latin1 NOT NULL,
  `IPSOURCE` varchar(48) CHARACTER SET latin1 DEFAULT NULL,
  `CONNEXION` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DATEFIN` datetime DEFAULT NULL,
  `DECONNEXION` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IDCONNEXION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=167 ;

--
-- Contenu de la table `connexions`
--

INSERT INTO `connexions` (`IDCONNEXION`, `COMPTE`, `DATEDEBUT`, `MACHINESOURCE`, `IPSOURCE`, `CONNEXION`, `DATEFIN`, `DECONNEXION`) VALUES
(134, 'armel', '2015-07-09 08:27:33', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 08:27:49', 'Session fermée correctement'),
(135, 'armel', '2015-07-09 08:27:53', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 10:16:34', 'Session expriée'),
(136, 'armel', '2015-07-09 10:20:58', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 11:55:03', 'Session fermée correctement'),
(137, 'armel', '2015-07-09 11:55:09', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 15:33:26', 'Session expriée'),
(138, 'armel', '2015-07-09 16:08:04', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 17:08:53', 'Session expriée'),
(139, 'armel', '2015-07-09 17:17:32', 'PET-PC', '::1', 'Connexion réussie', '2015-07-09 20:02:35', 'Session expriée'),
(140, 'armel', '2015-07-09 21:51:34', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 01:19:26', 'Session expriée'),
(141, 'armel', '2015-07-10 08:12:23', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 09:12:45', 'Session expriée'),
(142, 'armel', '2015-07-10 09:50:30', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(143, 'armel', '2015-07-10 11:10:47', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 14:56:27', 'Session expriée'),
(144, 'armel', '2015-07-10 14:24:38', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 18:31:26', 'Session fermée correctement'),
(145, 'armel', '2015-07-10 15:40:15', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 16:40:22', 'Session expriée'),
(146, 'armel', '2015-07-10 18:31:45', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(147, 'armel', '2015-07-10 19:16:40', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 21:47:03', 'Session expriée'),
(148, 'armel', '2015-07-10 20:12:00', 'PET-PC', '::1', 'Connexion réussie', '2015-07-10 21:47:06', 'Session expriée'),
(149, 'armel', '2015-07-11 00:56:01', 'PET-PC', '::1', 'Connexion réussie', '2015-07-11 02:00:00', 'Session expriée'),
(150, 'armel', '2015-07-11 01:54:05', 'PET-PC', '::1', 'Connexion réussie', '2015-07-11 02:59:21', 'Session expriée'),
(151, 'armel', '2015-07-11 02:06:06', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(152, 'armel', '2015-07-11 08:39:36', 'PET-PC', '::1', 'Connexion réussie', '2015-07-11 10:09:20', 'Session expriée'),
(153, 'armel', '2015-07-11 14:43:59', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(154, 'armel', '2015-07-11 15:01:56', 'PET-PC', '::1', 'Connexion réussie', '2015-07-11 16:48:46', 'Session expriée'),
(155, 'armel', '2015-07-11 20:41:26', 'PET-PC', '::1', 'Connexion réussie', '2015-07-11 22:38:56', 'Session expriée'),
(156, 'armel', '2015-07-11 21:18:02', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(157, 'armel', '2015-07-12 00:02:33', 'PET-PC', '::1', 'Connexion réussie', '2015-07-12 01:02:33', 'Session expriée'),
(158, 'armel', '2015-07-12 06:47:38', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(159, 'armel', '2015-07-12 08:09:49', 'PET-PC', '::1', 'Connexion réussie', '2015-07-12 09:22:00', 'Session expriée'),
(160, 'armel', '2015-07-13 07:16:12', 'PET-PC', '::1', 'Connexion réussie', '2015-07-13 08:16:59', 'Session expriée'),
(161, 'armel', '2015-07-13 11:36:11', 'PET-PC', '::1', 'Connexion réussie', '2015-07-13 12:36:29', 'Session expriée'),
(162, 'armel', '2015-07-13 16:17:24', 'PET-PC', '::1', 'Connexion réussie', '2015-07-13 18:19:18', 'Session expriée'),
(163, 'armel', '2015-07-13 18:57:58', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(164, 'armel', '2015-07-13 23:31:09', 'PET-PC', '::1', 'Connexion réussie', '2015-07-14 02:41:34', 'Session expriée'),
(165, 'armel', '2015-07-14 08:27:47', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', ''),
(166, 'armel', '2015-07-14 16:32:57', 'PET-PC', '::1', 'Session en cours', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `decoupage`
--

CREATE TABLE IF NOT EXISTS `decoupage` (
  `IDDECOUPAGE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(30) NOT NULL,
  PRIMARY KEY (`IDDECOUPAGE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `decoupage`
--

INSERT INTO `decoupage` (`IDDECOUPAGE`, `LIBELLE`) VALUES
(1, 'Séquence'),
(2, 'Trimestre'),
(3, 'Semestre');

-- --------------------------------------------------------

--
-- Structure de la table `droits`
--

CREATE TABLE IF NOT EXISTS `droits` (
  `IDDROIT` int(11) NOT NULL AUTO_INCREMENT,
  `CODEDROIT` varchar(10) NOT NULL,
  `LIBELLE` varchar(255) NOT NULL,
  `VERROUILLER` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Ce droit n est pas verrouiller; 1 = verrouiller et donc inaccessible',
  PRIMARY KEY (`IDDROIT`),
  UNIQUE KEY `CODE` (`CODEDROIT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Contenu de la table `droits`
--

INSERT INTO `droits` (`IDDROIT`, `CODEDROIT`, `LIBELLE`, `VERROUILLER`) VALUES
(1, '101', 'Modifier mon mot de passe', 0),
(2, '102', 'Modifier mon adresse email', 0),
(3, '103', 'Mes connexions', 0),
(4, '104', 'Modifier mon numéro de téléphone', 0),
(5, '201', 'Consulter les informations sur l''etablissement', 0),
(6, '202', 'Consulter les informations sur les classes', 0),
(7, '203', 'Consulter les informations sur le personnels', 0),
(8, '204', 'Consulter les informations sur les élèves', 0),
(11, '205', 'Afficher les clauses des conseils de classe', 0),
(12, '206', 'Consulter le répertoire téléphonique de l''établissement et du personnels', 0),
(13, '301', 'Appel en salle', 0),
(14, '302', 'Liste d''appel de la semaine', 0),
(15, '303', 'Consultation des absences', 0),
(16, '304', 'Suivi des absences', 0),
(17, '305', 'Saisie d''une absence', 0),
(18, '306', 'Justification des appels', 0),
(19, '307', 'Envoi de SMS', 0),
(20, '308', 'Suivi des SMS', 0),
(21, '309', 'Saisie des appréciations', 0),
(22, '310', 'Passages à l''infirmerie', 0),
(23, '311', 'Punitions', 0),
(24, '312', 'Sanctions', 0),
(25, '313', 'Paramétrage des justifications', 0),
(26, '314', 'Paramétrage des modèles de SMS', 0),
(27, '401', 'Saisie des notes', 0),
(28, '402', 'Récapitulatif des notes', 0),
(29, '403', 'Bilan bulletins', 0),
(30, '604', 'Verrouillage des périodes', 0),
(31, '405', 'Observations du conseil de classe', 0),
(32, '406', 'Impression des bulletins', 0),
(33, '501', 'Saisie établissement', 0),
(34, '502', 'Saisie du personnel', 0),
(35, '503', 'Saisie des élèves', 0),
(36, '504', 'Saisie des matières', 0),
(37, '505', 'Saisie des classes', 0),
(38, '506', 'Saisie des emplois du temps', 0),
(39, '601', 'Options générales', 0),
(40, '602', 'Tous les mots de passe', 0),
(41, '603', 'Gestion des utilisateurs', 0),
(43, '605', 'Calendrier scolaire', 0),
(44, '701', 'Sauvegarder la base de données', 0),
(45, '702', 'Restaurer la base de données', 0),
(46, '801', 'Récupération du personnel', 0),
(47, '802', 'Récupération des élèves', 0),
(48, '803', 'Récupération des classes', 0),
(49, '105', 'Déconnexion', 0),
(50, '507', 'Suppression du personnel', 0),
(51, '207', 'Consulter les informations sur les enseignants', 0),
(52, '315', 'Saisie d''une punition', 0),
(53, '407', 'Modification des notes', 0),
(54, '408', 'Verrouillage et Déverrouillage des notes', 0),
(56, '508', 'Payement de la scolarité', 0),
(57, '208', 'Consulter la scolarités de chaque classes', 0),
(58, '209', 'Consulter les informations sur les matières enseignées', 0),
(59, '210', 'Consulter les informations sur les responsables d''élèves', 0),
(66, '317', 'Modification de responsable d''élève', 0),
(67, '318', 'Suppression de responsable d''élève', 0),
(69, '319', 'Saisie/Ajout de responsable d''élève', 0),
(71, '320', 'Modification d''une saisie du registre d''appel', 0),
(72, '509', 'Saisie des frais', 0),
(73, '211', 'Consulter les informations sur les frais à payer', 0),
(74, '510', 'Suppression des frais scolaires', 0),
(75, '511', 'Modification des frais scolaires', 0),
(79, '512', 'Saisie d''une opération caisse', 0),
(80, '513', 'Modification des informations du personnel', 0),
(81, '212', 'Consulter les informations sur les notes scolaires', 0),
(84, '409', 'Suppression des notes d''élèves', 0),
(85, '514', 'Modification des matières', 0),
(86, '515', 'Suppression des matières', 0),
(88, '213', 'Consulter la liste d''appel de la semaine', 0),
(89, '410', 'Afficher les statistiques des notes', 0),
(90, '411', 'Fiche de report de notes de vierge', 0),
(91, '606', 'Gestion des droits des utilisateurs', 0),
(92, '323', 'Saisie de la liste d''appel de la semaine', 0),
(93, '517', 'Modification des classes et ajout d''élèves dans une classe', 0),
(94, '518', 'Suppression des classes et des élèves d''une classe', 0),
(96, '324', 'Suppression d''une liste d''absence', 0);

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE IF NOT EXISTS `eleves` (
  `IDELEVE` int(11) NOT NULL AUTO_INCREMENT,
  `MATRICULE` varchar(15) DEFAULT NULL,
  `NOM` varchar(30) NOT NULL,
  `PRENOM` varchar(30) DEFAULT NULL,
  `AUTRENOM` varchar(30) DEFAULT NULL,
  `SEXE` varchar(15) NOT NULL,
  `PHOTO` varchar(150) DEFAULT NULL,
  `CNI` varchar(15) DEFAULT NULL,
  `NATIONALITE` int(11) DEFAULT NULL,
  `DATENAISS` date NOT NULL,
  `PAYSNAISS` int(11) DEFAULT NULL,
  `LIEUNAISS` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `DATEENTREE` date NOT NULL,
  `PROVENANCE` int(11) DEFAULT NULL,
  `REDOUBLANT` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = non redoublant, 1 = redoublant',
  `DATESORTIE` date DEFAULT NULL,
  `MOTIFSORTIE` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDELEVE`),
  UNIQUE KEY `MATRICULE` (`MATRICULE`),
  KEY `NATIONALITE` (`NATIONALITE`),
  KEY `LIEUNAISS` (`PAYSNAISS`),
  KEY `PROVENANCE` (`PROVENANCE`),
  KEY `MOTIFSORTIE` (`MOTIFSORTIE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Contenu de la table `eleves`
--

INSERT INTO `eleves` (`IDELEVE`, `MATRICULE`, `NOM`, `PRENOM`, `AUTRENOM`, `SEXE`, `PHOTO`, `CNI`, `NATIONALITE`, `DATENAISS`, `PAYSNAISS`, `LIEUNAISS`, `DATEENTREE`, `PROVENANCE`, `REDOUBLANT`, `DATESORTIE`, `MOTIFSORTIE`) VALUES
(25, '156001', 'Beyenguena', 'Franklin', '', 'M', '031014_1754_Connectinga20.png', '', 1, '2015-05-06', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(26, '156014', 'Djoum', 'Emini Francois', '', 'M', '031014_1754_Connectinga20.png', '', 1, '2015-05-06', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(27, '156002', 'Edzigui', 'Henri Christian', '', 'M', '031014_1754_Connectinga20.png', '', 1, '2015-05-06', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(28, '156019', 'Emini', 'Eyala', 'Dieudonnée', 'M', '031014_1754_Connectinga20.png', 'uog8g', 1, '2015-05-06', 1, '', '2015-05-20', 1, 0, NULL, NULL),
(29, '156021', 'Eog', 'Emile', 'oihioin', 'F', '031014_1754_Connectinga20.png', 'uog8g', 1, '2015-05-06', 1, '', '2015-05-20', 1, 0, NULL, NULL),
(30, '156015', 'Evanie', 'Enama', 'Abodo R.', 'F', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(31, '156005', 'Faha', 'Nembo', 'Steve', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(32, '156003', 'Fouda', 'Omgba', 'Andre R.', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(33, '150009', 'Gauater Gauater', 'Simon', '', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(34, '156022', 'Gouo ', 'Daniel', 'Jerry', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(35, '156016', 'Kayem', 'Tchuem', 'T.', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(37, '156024', 'Mbema', 'Moudio', 'William', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(38, '156023', 'Mieyo', 'Cheunchou D.', 'ELAUTRENOM3', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(39, '156017', 'Mimche', 'Cherifa', '', 'F', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(40, '156006', 'Mouzong', 'Emini', 'Jean-B', 'M', '031014_1754_Connectinga20.png', 'kuvyuv', 1, '2015-05-20', 1, 'iuigui', '2015-05-19', 1, 0, NULL, NULL),
(47, '150015', 'Ndokou', 'Nanwou', 'Marie', 'M', '031014_1754_Connectinga20.png', '', 1, '2015-05-04', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(48, '150013', 'Nga', 'Atizi', 'Ernestine', 'M', '', '', 1, '2015-05-04', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(50, '150016', 'Ngayene', 'Ketty', 'Sandra', 'F', '', '', 1, '2015-06-16', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(51, '156007', 'Njom', 'Steve', 'Alain', 'M', '', '', 1, '2015-06-16', 1, '', '1899-11-30', 1, 0, '0000-00-00', 0),
(53, '150003', 'Nkoa', 'Abanda', 'Franck U.', 'M', '', '', 1, '2015-07-08', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(55, '156018', 'Noupa', 'Dylan', 'Steve', 'M', '', '', 1, '2015-06-02', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(56, '150002', 'Onomo', 'Bedjeme', 'G.', 'F', '', '', 1, '2015-06-09', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(58, '150014', 'Simou', 'Fota', 'Adrien', 'M', '', '', 1, '2015-06-09', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(73, '150006', 'Sipowa', 'Tsangning', 'Ange', 'M', '', '', 1, '2015-06-02', 1, '', '0000-00-00', 1, 0, NULL, NULL),
(74, '150005', 'Ainam', 'Jean-Paul', '', 'M', '031014_1754_Connectinga20.png', '1454', 1, '2015-06-02', 1, 'bongor', '2015-06-15', 1, 0, '1899-11-30', 0),
(76, '150004', 'Tayou', 'Fokam', 'Brian', 'M', '', '', 1, '2015-06-09', 1, 'wevewvev', '0000-00-00', 1, 0, NULL, NULL),
(77, '150001', 'Armel', 'Kadje', 'Luc Talom', 'M', 'jorge.jpg', '', 1, '2015-06-09', 1, 'Yaoundé', '2015-06-03', 1, 0, '1899-11-30', 0),
(78, '150008', 'Wembe', 'Yvan', '', 'M', 'ainam.jpg', 'cni id', 1, '2014-12-16', 1, 'llieu naiss', '2015-06-03', 1, 0, NULL, NULL),
(79, '150007', 'Zemta', 'Kaji', 'Ela Merveille', 'F', '', '', 1, '2015-06-10', 1, '', '0000-00-00', 0, 1, NULL, NULL),
(81, '156020', 'Abogo', 'Marie Noelle', '', 'F', 'elab_logo.png', '', 1, '2013-04-02', 1, '', '2015-07-05', 0, 0, NULL, NULL),
(82, '156004', 'Amoungui', 'Bidzogo E.', '', 'M', 'Pavilion15_Teaser.jpg', '', 1, '2012-06-12', 1, '', '2015-07-05', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `emplois`
--

CREATE TABLE IF NOT EXISTS `emplois` (
  `IDEMPLOIS` int(11) NOT NULL AUTO_INCREMENT,
  `JOUR` int(11) NOT NULL COMMENT '1 = Lundi... 7 = Dimanche',
  `IDENSEIGNEMENT` int(11) NOT NULL,
  `HEUREDEBUT` time NOT NULL,
  `HEUREFIN` time NOT NULL,
  PRIMARY KEY (`IDEMPLOIS`),
  KEY `IDENSEIGNEMENT` (`IDENSEIGNEMENT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `emplois`
--

INSERT INTO `emplois` (`IDEMPLOIS`, `JOUR`, `IDENSEIGNEMENT`, `HEUREDEBUT`, `HEUREFIN`) VALUES
(2, 1, 60, '08:00:00', '08:55:00'),
(3, 1, 61, '09:00:00', '11:55:00'),
(4, 1, 62, '12:00:00', '13:55:00'),
(5, 3, 62, '10:00:00', '13:55:00'),
(6, 5, 63, '11:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE IF NOT EXISTS `enseignants` (
  `IDENSEIGNANT` varchar(15) NOT NULL,
  `NOM` varchar(30) NOT NULL,
  `PRENOM` varchar(30) NOT NULL,
  `AUTRENOM` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`IDENSEIGNANT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `enseignements`
--

CREATE TABLE IF NOT EXISTS `enseignements` (
  `IDENSEIGNEMENT` int(11) NOT NULL AUTO_INCREMENT,
  `MATIERE` int(11) DEFAULT NULL,
  `PROFESSEUR` int(11) DEFAULT NULL,
  `CLASSE` int(11) NOT NULL,
  `GROUPE` int(11) DEFAULT NULL,
  `COEFF` decimal(3,1) NOT NULL,
  PRIMARY KEY (`IDENSEIGNEMENT`),
  KEY `MATIERE` (`MATIERE`,`PROFESSEUR`,`CLASSE`),
  KEY `PROFESSEUR` (`PROFESSEUR`),
  KEY `CLASSE` (`CLASSE`),
  KEY `GROUPE` (`GROUPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Contenu de la table `enseignements`
--

INSERT INTO `enseignements` (`IDENSEIGNEMENT`, `MATIERE`, `PROFESSEUR`, `CLASSE`, `GROUPE`, `COEFF`) VALUES
(60, 1, 6, 1, 1, '2.0'),
(61, 2, 3, 1, 1, '2.0'),
(62, 14, 3, 1, 1, '4.0'),
(63, 19, 3, 1, 2, '4.0'),
(64, 1, 3, 2, 1, '2.0'),
(65, 17, 5, 2, 1, '2.0'),
(66, 2, 1, 2, 2, '4.0'),
(67, 1, 3, 3, 1, '4.0'),
(68, 17, 3, 3, 1, '4.0'),
(69, 2, 3, 3, 1, '2.0'),
(70, 3, 3, 1, 1, '2.0'),
(71, 5, 3, 1, 1, '2.0'),
(72, 6, 3, 1, 2, '4.0'),
(73, 10, 5, 1, 2, '4.0'),
(74, 7, 5, 1, 2, '2.0'),
(75, 9, 5, 1, 2, '1.0'),
(76, 8, 3, 1, 3, '1.0'),
(77, 15, 1, 1, 3, '1.0');

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE IF NOT EXISTS `etablissements` (
  `IDETABLISSEMENT` int(11) NOT NULL AUTO_INCREMENT,
  `ETABLISSEMENT` varchar(150) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`IDETABLISSEMENT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `etablissements`
--

INSERT INTO `etablissements` (`IDETABLISSEMENT`, `ETABLISSEMENT`) VALUES
(1, 'Collège Adventiste de Yaoundé'),
(2, 'Lycée Leclerc'),
(3, 'Lycee Provenance');

-- --------------------------------------------------------

--
-- Structure de la table `feries`
--

CREATE TABLE IF NOT EXISTS `feries` (
  `IDFERIE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(50) NOT NULL,
  `DATEFERIE` date NOT NULL,
  `PERIODE` varchar(15) NOT NULL,
  PRIMARY KEY (`IDFERIE`),
  KEY `PERIODE` (`PERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `feries`
--

INSERT INTO `feries` (`IDFERIE`, `LIBELLE`, `DATEFERIE`, `PERIODE`) VALUES
(1, 'Ferier en plein juillet', '2015-07-10', '2014-2015');

-- --------------------------------------------------------

--
-- Structure de la table `fermetures`
--

CREATE TABLE IF NOT EXISTS `fermetures` (
  `IDFERMETURE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(50) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `PERIODE` varchar(15) NOT NULL,
  PRIMARY KEY (`IDFERMETURE`),
  KEY `PERIODE` (`PERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `fermetures`
--

INSERT INTO `fermetures` (`IDFERMETURE`, `LIBELLE`, `DATEDEBUT`, `DATEFIN`, `PERIODE`) VALUES
(1, 'weekedn 1ere semaine de classe', '2014-09-06', '2014-09-07', '2014-2015'),
(2, 'weekend 2 eme semaine de classe', '2014-09-13', '2014-09-14', '2014-2015'),
(3, 'weekeend de la 1ere semaine de juillet ', '2015-07-04', '2015-07-05', '2014-2015'),
(4, 'weekend de la 2nde semaine de juillet', '2015-07-11', '2015-07-12', '2014-2015'),
(5, 'weekeend de la 3eme semaine de juillet', '2015-07-18', '2015-07-19', '2014-2015'),
(6, 'weekend de la 4eme semaine de juillet', '2015-07-25', '2015-07-30', '2014-2015');

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

CREATE TABLE IF NOT EXISTS `fonctions` (
  `IDFONCTION` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`IDFONCTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `fonctions`
--

INSERT INTO `fonctions` (`IDFONCTION`, `LIBELLE`) VALUES
(1, 'Enseignant'),
(2, 'Assistant éducation'),
(3, 'Direction'),
(4, 'Consultant');

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

CREATE TABLE IF NOT EXISTS `frais` (
  `IDFRAIS` int(11) NOT NULL AUTO_INCREMENT,
  `CLASSE` int(11) NOT NULL,
  `DESCRIPTION` varchar(150) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `ECHEANCES` date NOT NULL,
  PRIMARY KEY (`IDFRAIS`),
  KEY `CLASSE` (`CLASSE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `frais`
--

INSERT INTO `frais` (`IDFRAIS`, `CLASSE`, `DESCRIPTION`, `MONTANT`, `ECHEANCES`) VALUES
(1, 1, 'Inscription', 10000, '2015-06-09'),
(2, 1, 'Tranche 1', 10000, '2015-06-18');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `IDGROUPE` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(250) NOT NULL,
  PRIMARY KEY (`IDGROUPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`IDGROUPE`, `DESCRIPTION`) VALUES
(1, 'Groupe 1'),
(2, 'Groupe 2'),
(3, 'Groupe 3');

-- --------------------------------------------------------

--
-- Structure de la table `groupemenus`
--

CREATE TABLE IF NOT EXISTS `groupemenus` (
  `IDGROUPE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(250) NOT NULL,
  `ICON` varchar(150) NOT NULL,
  `ALT` varchar(50) DEFAULT NULL,
  `TITLE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IDGROUPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `groupemenus`
--

INSERT INTO `groupemenus` (`IDGROUPE`, `LIBELLE`, `ICON`, `ALT`, `TITLE`) VALUES
(1, 'Mon Compte', 'compte.png', NULL, NULL),
(2, 'Informations internes', 'infointerne.png', NULL, NULL),
(3, 'Vie scolaire', 'viescolaire.png', NULL, NULL),
(4, 'Notes et bulletins', 'bulletin.png', NULL, NULL),
(5, 'Gestion des données', 'gestiondonnees.png', NULL, NULL),
(6, 'Paramètres', 'parametre.png', NULL, NULL),
(7, 'Sauvegarde', 'sauvegarde.png', NULL, NULL),
(8, 'Année précédente', 'anneeprecende.png', NULL, NULL),
(9, 'Imports/Exports', 'compte.png', NULL, NULL),
(10, 'Tableau d''affichage', 'compte.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE IF NOT EXISTS `inscription` (
  `IDINSCRIPTION` int(11) NOT NULL AUTO_INCREMENT,
  `IDELEVE` int(11) NOT NULL,
  `IDCLASSE` int(11) NOT NULL,
  `ANNEEACADEMIQUE` varchar(15) NOT NULL,
  PRIMARY KEY (`IDINSCRIPTION`),
  UNIQUE KEY `IDELEVE` (`IDELEVE`,`IDCLASSE`,`ANNEEACADEMIQUE`),
  KEY `IDCLASSE` (`IDCLASSE`),
  KEY `ANNEEACADEMIQUE` (`ANNEEACADEMIQUE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Contenu de la table `inscription`
--

INSERT INTO `inscription` (`IDINSCRIPTION`, `IDELEVE`, `IDCLASSE`, `ANNEEACADEMIQUE`) VALUES
(81, 25, 1, '2014-2015'),
(82, 26, 1, '2014-2015'),
(104, 27, 3, '2014-2015'),
(105, 28, 3, '2014-2015'),
(85, 29, 1, '2014-2015'),
(86, 30, 1, '2014-2015'),
(87, 31, 1, '2014-2015'),
(88, 32, 1, '2014-2015'),
(89, 33, 1, '2014-2015'),
(90, 34, 1, '2014-2015'),
(91, 35, 1, '2014-2015'),
(92, 37, 1, '2014-2015'),
(93, 38, 1, '2014-2015'),
(94, 39, 1, '2014-2015'),
(95, 40, 1, '2014-2015'),
(96, 47, 1, '2014-2015'),
(97, 48, 1, '2014-2015'),
(98, 50, 1, '2014-2015'),
(75, 51, 1, '2014-2015'),
(99, 53, 1, '2014-2015'),
(76, 55, 1, '2014-2015'),
(72, 56, 1, '2014-2015'),
(100, 58, 1, '2014-2015'),
(106, 73, 3, '2014-2015'),
(74, 74, 1, '2014-2015'),
(78, 74, 2, '2013-2014'),
(102, 76, 1, '2014-2015'),
(73, 77, 1, '2014-2015'),
(103, 78, 1, '2014-2015'),
(77, 79, 1, '2014-2015'),
(79, 81, 1, '2014-2015'),
(80, 82, 1, '2014-2015');

-- --------------------------------------------------------

--
-- Structure de la table `journals`
--

CREATE TABLE IF NOT EXISTS `journals` (
  `IDTYPE` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` char(1) NOT NULL COMMENT 'Code du journal',
  `LIBELLE` varchar(150) NOT NULL,
  PRIMARY KEY (`IDTYPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `journals`
--

INSERT INTO `journals` (`IDTYPE`, `CODE`, `LIBELLE`) VALUES
(1, 'S', 'Payement de la scolarité'),
(2, '', 'Payement des salaires');

-- --------------------------------------------------------

--
-- Structure de la table `justifications`
--

CREATE TABLE IF NOT EXISTS `justifications` (
  `IDJUSTIFICATION` int(11) NOT NULL AUTO_INCREMENT,
  `MOTIF` varchar(250) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `DATEJOUR` date DEFAULT NULL,
  `REALISERPAR` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDJUSTIFICATION`),
  KEY `REALISERPAR` (`REALISERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `justifications`
--

INSERT INTO `justifications` (`IDJUSTIFICATION`, `MOTIF`, `DESCRIPTION`, `DATEJOUR`, `REALISERPAR`) VALUES
(10, 'wrvwre', 'vwrevervwev', NULL, 1),
(13, 'weerv', 'rbrtbrtbrt', NULL, 1),
(14, 'Retard', 'il a ete excuse ', '2015-07-06', 1),
(15, 'justifier encore', 'montre petit', '2015-07-06', 1),
(16, 'justifier encorecwec', 'montre petitec', '2015-07-06', 6),
(18, 'brgbtbt', 'brgbdr', '2015-07-06', 2),
(19, 'Maladie', 'Malade est hospitalis et donc pouvai pas venir en classe', '2015-07-07', 5),
(20, 'gregwergerher', 'befdrtntntrntrnhrtnrthr', '2015-07-07', 3),
(23, 'accident', 'il a connu un accident qui l&#39;empeche de marché', '2015-07-09', 1),
(26, 'erfb', 'brdbrb', '2015-07-10', 1),
(27, 'erfb', 'brdbrb', '2015-07-10', 1),
(28, 'erfb', 'brdbrb', '2015-07-10', 1),
(29, 'erfb', 'brdbrb', '2015-07-10', 1);

-- --------------------------------------------------------

--
-- Structure de la table `locan`
--

CREATE TABLE IF NOT EXISTS `locan` (
  `ID` varchar(15) NOT NULL,
  `NOM` varchar(150) NOT NULL,
  `RESPONSABLE` varchar(150) NOT NULL,
  `ADRESSE` varchar(150) NOT NULL,
  `BP` varchar(10) DEFAULT NULL,
  `TELEPHONE` varchar(30) NOT NULL,
  `TELEPHONE2` varchar(30) NOT NULL,
  `MOBILE` varchar(30) NOT NULL,
  `FAX` varchar(30) CHARACTER SET ucs2 DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `SITEWEB` varchar(30) DEFAULT NULL,
  `LOGO` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `locan`
--

INSERT INTO `locan` (`ID`, `NOM`, `RESPONSABLE`, `ADRESSE`, `BP`, `TELEPHONE`, `TELEPHONE2`, `MOBILE`, `FAX`, `EMAIL`, `SITEWEB`, `LOGO`) VALUES
('IPW', 'Institut Polyvalent WAGUE', 'Mme WACGUE', 'Route vers SOA', NULL, '+237654258182', '+237958652142', '+237584961536', NULL, 'institutwague@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE IF NOT EXISTS `matieres` (
  `IDMATIERE` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(15) NOT NULL,
  `LIBELLE` varchar(255) NOT NULL,
  `BULLETIN` varchar(150) NOT NULL COMMENT 'Libelle utiliser pour les impressions des bulletins',
  PRIMARY KEY (`IDMATIERE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `matieres`
--

INSERT INTO `matieres` (`IDMATIERE`, `CODE`, `LIBELLE`, `BULLETIN`) VALUES
(1, 'FR', 'Français', 'Francais'),
(2, 'ANG', 'Anglais', 'Anglais'),
(3, 'H', 'Histoire', 'Histoire'),
(4, 'G', 'Géographie', 'Géographie'),
(5, 'ECM', 'Education Civique et Morale', 'ECM'),
(6, 'MATHS-GEN', 'Mathématiques Générales', 'Mathematiques Generales'),
(7, 'PC-TECH', 'Phisique, Technologie et Chimie', 'Phisique, Techno. et Chimie'),
(8, 'EPS', 'Education Physique et Sportive', 'E.P.S'),
(9, 'INFO', 'Informatique', 'Informatique'),
(10, 'SVT', 'Sciences de la vie et de la terre', 'ST/SVT'),
(11, 'PHILO', 'Philosophie', 'Philosophie'),
(12, 'COUR', 'Courrier', 'Courrier'),
(13, 'FISC', 'Fiscalité', 'Fiscalité'),
(14, 'BUR', 'Bureautique', 'Bureautique'),
(15, 'MOR', 'Morale', 'Morale'),
(16, 'TECH-COMPT', 'Techniques Comptables TCP', 'Techniques Comptables TCP'),
(17, 'ALL', 'Allemand', 'Allemand'),
(18, 'ESP', 'Espagnol', 'Espagnol'),
(19, 'COMM', 'Commerce', 'Commerce'),
(20, 'COMPT', 'Comptabilité', 'Comptabilite'),
(21, 'ECON-GEN', 'Economie Générale', 'Economie Generale'),
(22, 'MATHS-APPL', 'Mathématiques Appliquées', 'Mathématiques Appliquees'),
(23, 'STAT', 'Statistiques', 'Statistiques'),
(24, 'OTA', 'Organisation du Travail Administratif', 'Organisation du Travail Administratif'),
(25, 'EOE', 'Economie et organisation des Entreprises', 'Economie et organisation des Entreprises'),
(26, 'DROIT', 'Droit', 'Droit'),
(27, 'TA', 'Travaux d''application', 'Travaux d''application'),
(28, 'CGAO', 'Comptabilité et Gestion Assistées par Ordinateur', 'CGAO'),
(29, 'OC-TCM', 'Outils et Communication', 'Outils et Communication'),
(30, 'EE', 'Economie d''Entreprise', 'Economie d''Entreprise'),
(31, 'GSI', 'Gestion des Systèmes Informatique', 'GSI'),
(32, 'TPGSI', 'Travaux Pratiques GSI', 'Travaux Pratiques GSI');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `IDMENUS` int(11) NOT NULL AUTO_INCREMENT,
  `IDGROUPE` int(11) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL,
  `HREF` varchar(250) NOT NULL,
  `ICON` varchar(250) NOT NULL,
  `CODEDROIT` varchar(10) NOT NULL,
  `ALT` varchar(50) DEFAULT NULL,
  `TITLE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IDMENUS`),
  KEY `CODEDROIT` (`CODEDROIT`),
  KEY `IDGROUPE` (`IDGROUPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Contenu de la table `menus`
--

INSERT INTO `menus` (`IDMENUS`, `IDGROUPE`, `LIBELLE`, `HREF`, `ICON`, `CODEDROIT`, `ALT`, `TITLE`) VALUES
(1, 1, 'Mon mot de passe', 'user/mdp', 'mdp.png', '101', NULL, NULL),
(2, 1, 'Mon email', 'user/email', 'email.png', '102', NULL, NULL),
(3, 1, 'Mes connexions', 'user/connexion', 'connexion.png', '103', NULL, NULL),
(4, 1, 'Mon téléphone', 'user/telephone', 'telephone.png', '104', NULL, NULL),
(5, 2, 'Etablissement', 'etablissement', 'etablissement.png', '201', NULL, NULL),
(6, 2, 'Classes', 'classe', 'classe.png', '202', NULL, NULL),
(7, 2, 'Personnels', 'personnel', 'personnel.png', '203', NULL, NULL),
(8, 2, 'Elèves', 'eleve', 'eleve.png', '204', NULL, NULL),
(9, 2, 'Conseils de classe', 'conseil', 'conseil.png', '205', NULL, NULL),
(10, 2, 'Repertoire', 'repertoire', 'repertoire.png', '206', NULL, NULL),
(11, 5, 'Saisie établissement', 'etablissement/saisie', 'etablissement.png', '501', NULL, NULL),
(12, 5, 'Saisie personnel', 'personnel/saisie', 'personnel.png', '502', NULL, NULL),
(13, 5, 'Saisie élèves', 'eleve/saisie', 'addeleve.png', '503', NULL, NULL),
(14, 5, 'Saisie matiere', 'matiere/saisie', 'addmatiere.png', '504', NULL, NULL),
(15, 5, 'Saisie classes', 'classe/saisie', 'addclasse.png', '505', NULL, NULL),
(16, 5, 'Emplois du temps', 'emplois/saisie', 'emploistemps.png', '506', NULL, NULL),
(17, 6, 'Gestion utilisateurs', 'user', 'utilisateur.png', '603', NULL, NULL),
(18, 3, 'Appel en salle', 'appel/saisie', 'appelsalle.png', '301', NULL, NULL),
(19, 1, 'Déconnexion', 'connexion/disconnect', 'disconnect.png', '105', NULL, NULL),
(20, 4, 'Saisie notes', 'note/saisie', 'addnote.png', '401', NULL, NULL),
(21, 4, 'Récapitulatif des notes', 'note/recapitulatif', 'recapitulatif.png', '402', NULL, NULL),
(22, 4, 'Bilans bulletins', 'note/bilan', 'bilan.png', '403', NULL, NULL),
(23, 2, 'Enseignants', 'enseignant', 'enseignant.png', '207', NULL, 'Gestion des enseignants'),
(24, 3, 'Appel de la semaine', 'appel/liste', 'listeappel.png', '302', NULL, NULL),
(25, 3, 'Consultation des appels', 'salle/consultation', 'consultation.png', '303', NULL, NULL),
(26, 3, 'Suivi des absences', 'appel/suivi', 'suivi.png', '304', NULL, NULL),
(28, 3, 'Justification des absences', 'appel/justification', 'justification.png', '306', NULL, NULL),
(29, 3, 'Envoi de SMS', 'sms/envoi', 'envoi.png', '307', NULL, NULL),
(30, 3, 'Suivi des SMS', 'sms/suivi', 'suivi.png', '308', NULL, NULL),
(32, 3, 'Passages à l''infirmerie', 'infirmerie/passage', 'passage.png', '310', NULL, NULL),
(33, 3, 'Punitions', 'punition', 'punition.png', '311', NULL, NULL),
(34, 3, 'Sanctions', 'salle/sanction', 'sanction.png', '312', NULL, NULL),
(35, 3, 'Paramétrage des justification', 'absence/parametrage', 'parametrage.png', '313', NULL, NULL),
(36, 6, 'Options générales', 'parametres/options', 'option.png', '601', NULL, NULL),
(37, 6, 'Tous les mots de passe', 'parametres/mdp', 'mdp.png', '602', NULL, NULL),
(39, 6, 'Calendrier scolaire', 'etablissement/calendrier', 'calendrier.png', '605', NULL, NULL),
(40, 3, 'Saisie d''une punition', 'punition/saisie', 'punition.png', '315', NULL, NULL),
(41, 2, 'Scolarités', 'scolarite', 'scolarite.png', '208', NULL, NULL),
(42, 5, 'Payement de la scolarité', 'scolarite/payement', 'payement.png', '508', NULL, NULL),
(43, 2, 'Matières', 'matiere', 'matiere.png', '209', NULL, NULL),
(44, 2, 'Responsables', 'responsable', 'responsable.png', '210', NULL, NULL),
(45, 5, 'Saisie des frais scolaires', 'frais/saisie', 'saisiefrais.png', '509', NULL, NULL),
(46, 2, 'Frais scolaires', 'frais', 'frais.png', '211', NULL, NULL),
(47, 5, 'Saisie d''une opération', 'caisse/saisie', 'caisse.png', '512', NULL, NULL),
(48, 4, 'Impression des bulletins', 'bulletin/impression', 'impressionbulletin.png', '406', NULL, NULL),
(49, 2, 'Notes', 'note', 'note.png', '212', NULL, NULL),
(50, 4, 'Verrouillage des notes', 'note/verrouillage', 'verrouillage.png', '408', NULL, NULL),
(51, 6, 'Verrouillage des périodes', 'periode/verrouillage', 'verrouillage.png', '604', NULL, NULL),
(52, 2, 'Appels', 'appel', 'appel.png', '213', NULL, NULL),
(53, 4, 'Statistiques des notes', 'note/statistique', 'statistique.png', '410', NULL, NULL),
(54, 4, 'Report de notes', 'note/report', 'report.png', '411', NULL, NULL),
(55, 6, 'Droits utilisateurs', 'user/droit', 'droit.png', '606', NULL, NULL),
(56, 3, 'Saisie appel semaine', 'appel/semaine', 'semaine.png', '323', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `motifsortie`
--

CREATE TABLE IF NOT EXISTS `motifsortie` (
  `IDMOTIF` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(150) NOT NULL,
  `DESCRIPTION` text,
  PRIMARY KEY (`IDMOTIF`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `motifsortie`
--

INSERT INTO `motifsortie` (`IDMOTIF`, `LIBELLE`, `DESCRIPTION`) VALUES
(1, 'Départ pour l''étranger', NULL),
(2, 'Décès', NULL),
(3, 'Exclusion', NULL),
(4, 'Aucune précision', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE IF NOT EXISTS `niveau` (
  `IDNIVEAU` int(11) NOT NULL AUTO_INCREMENT,
  `NIVEAUSELECT` varchar(60) NOT NULL,
  `NIVEAUHTML` varchar(60) NOT NULL,
  `GROUPE` int(11) NOT NULL,
  PRIMARY KEY (`IDNIVEAU`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `niveau`
--

INSERT INTO `niveau` (`IDNIVEAU`, `NIVEAUSELECT`, `NIVEAUHTML`, `GROUPE`) VALUES
(0, 'T&#x2e1;&#x1D49;', 'T<sup>le</sup>', 0),
(1, '1&#x1D49;&#x2b3;&#x1D49;A', '1<sup>ère</sup>A', 1),
(2, '2&#x1db0;&#x1d48;&#x1D49;A', '2<sup>nde</sup>A', 2),
(3, '3&#x1D49;&#x1d50;&#x1D49;A', '3<sup>ème</sup>A', 3),
(4, '4&#x1D49;&#x1d50;&#x1D49;A', '4<sup>ème</sup>A', 4),
(5, '5&#x1D49;&#x1d50;&#x1D49;M&#x2081;', '5<sup>ème</sup>M<sub>1</sub>', 5),
(6, '6&#x1D49;&#x1d50;&#x1D49;M&#x2081;', '6<sup>ème</sup>M<sub>2</sub>', 6),
(7, '6&#x1D49;&#x1d50;&#x1D49;M&#x2082;', '6<sup>ème</sup>M<sub>2</sub>', 6),
(8, '5&#x1D49;&#x1d50;&#x1D49;M&#x2082;', '5<sup>ème</sup>M<sub>2</sub>', 5),
(9, '4&#x1D49;&#x1d50;&#x1D49;E', '4<sup>ème</sup>E', 4),
(10, '3&#x1D49;&#x1d50;&#x1D49;E', '3<sup>ème</sup>E', 3),
(11, '2&#x1db0;&#x1d48;&#x1D49;C', '2<sup>nde</sup>C', 2),
(12, '1&#x1D49;&#x2b3;&#x1D49;C', '1<sup>ère</sup>C', 1),
(13, '1&#x1D49;&#x2b3;&#x1D49;D', '1<sup>ère</sup>D', 1),
(14, '1&#x1D49;&#x2b3;&#x1D49;FIG', '1<sup>ère</sup>FIG', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notations`
--

CREATE TABLE IF NOT EXISTS `notations` (
  `IDNOTATION` int(11) NOT NULL AUTO_INCREMENT,
  `ENSEIGNEMENT` int(11) NOT NULL,
  `TYPENOTE` int(11) NOT NULL,
  `DESCRIPTION` varchar(150) NOT NULL,
  `NOTESUR` decimal(5,2) NOT NULL,
  `SEQUENCE` int(11) NOT NULL,
  `DATEDEVOIR` date NOT NULL COMMENT 'Date a laquelle le devoir a ete fait',
  `DATEJOUR` date NOT NULL,
  `REALISERPAR` int(11) NOT NULL,
  `VERROUILLER` int(11) NOT NULL,
  PRIMARY KEY (`IDNOTATION`),
  KEY `ENSEIGNEMENT` (`ENSEIGNEMENT`),
  KEY `TYPENOTE` (`TYPENOTE`),
  KEY `SEQUENCE` (`SEQUENCE`),
  KEY `REALISERPAR` (`REALISERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `notations`
--

INSERT INTO `notations` (`IDNOTATION`, `ENSEIGNEMENT`, `TYPENOTE`, `DESCRIPTION`, `NOTESUR`, `SEQUENCE`, `DATEDEVOIR`, `DATEJOUR`, `REALISERPAR`, `VERROUILLER`) VALUES
(2, 60, 1, 'Devoir personnalisé', '20.00', 1, '2015-07-07', '2015-07-11', 1, 0),
(3, 67, 1, 'Devoir personnalisé', '20.00', 1, '2015-07-12', '2015-07-12', 1, 0),
(4, 61, 2, 'Devoir harmonisé', '20.00', 1, '2015-07-13', '2015-07-13', 1, 0),
(5, 60, 2, 'Devoir harmonisé', '20.00', 1, '2015-07-13', '2015-07-13', 1, 0),
(6, 61, 1, 'Devoir personnalisé', '20.00', 1, '2015-07-13', '2015-07-13', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `IDNOTE` int(11) NOT NULL AUTO_INCREMENT,
  `NOTE` decimal(5,2) DEFAULT NULL,
  `NOTATION` int(11) NOT NULL,
  `ELEVE` int(11) NOT NULL,
  `ABSENT` int(11) NOT NULL COMMENT '1 = Absent et 0 = present',
  `OBSERVATION` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`IDNOTE`),
  KEY `ELEVE` (`ELEVE`),
  KEY `NOTATION` (`NOTATION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Contenu de la table `notes`
--

INSERT INTO `notes` (`IDNOTE`, `NOTE`, `NOTATION`, `ELEVE`, `ABSENT`, `OBSERVATION`) VALUES
(7, '12.00', 2, 81, 0, ''),
(8, '10.00', 2, 74, 0, ''),
(9, '9.00', 2, 82, 0, ''),
(10, '10.00', 2, 77, 0, ''),
(11, '15.00', 2, 25, 0, ''),
(12, '13.00', 2, 26, 0, ''),
(13, '15.00', 2, 27, 0, ''),
(14, '18.00', 2, 28, 0, ''),
(15, '15.50', 2, 29, 0, ''),
(16, '12.00', 2, 30, 0, ''),
(17, '5.00', 2, 31, 0, ''),
(18, '0.00', 2, 32, 0, ''),
(19, '2.50', 2, 33, 0, ''),
(20, '0.00', 2, 34, 1, ''),
(21, '10.00', 2, 35, 0, ''),
(22, '8.00', 2, 37, 0, ''),
(23, '9.00', 2, 38, 0, ''),
(24, '5.00', 2, 39, 0, ''),
(25, '2.00', 2, 40, 0, ''),
(26, '2.00', 2, 47, 0, ''),
(27, '10.00', 2, 48, 0, ''),
(28, '12.00', 2, 50, 0, ''),
(29, '13.00', 2, 51, 0, ''),
(30, '15.00', 2, 53, 0, ''),
(31, '16.00', 2, 55, 0, ''),
(32, '15.00', 2, 56, 0, ''),
(33, '12.00', 2, 58, 0, ''),
(34, '13.00', 2, 73, 0, ''),
(35, '10.00', 2, 76, 0, ''),
(36, '9.00', 2, 78, 0, ''),
(37, '7.00', 2, 79, 0, ''),
(38, '15.00', 3, 27, 0, ''),
(39, '12.00', 3, 28, 0, ''),
(40, '10.00', 3, 73, 0, ''),
(41, '14.00', 4, 81, 0, ''),
(42, '12.00', 4, 74, 0, ''),
(43, '9.00', 4, 82, 0, ''),
(44, '3.00', 4, 77, 0, ''),
(45, '2.00', 4, 25, 0, ''),
(46, '5.00', 4, 26, 0, ''),
(47, '10.00', 4, 29, 0, ''),
(48, '15.00', 4, 30, 0, ''),
(49, '19.00', 4, 31, 0, ''),
(50, '12.00', 4, 32, 0, ''),
(51, '13.00', 4, 33, 0, ''),
(52, '15.50', 4, 34, 0, ''),
(53, '16.00', 4, 35, 0, ''),
(54, '18.00', 4, 37, 0, ''),
(55, '2.00', 4, 38, 0, ''),
(56, '10.00', 4, 39, 0, ''),
(57, '5.00', 4, 40, 0, ''),
(58, '2.50', 4, 47, 0, ''),
(59, '6.00', 4, 48, 0, ''),
(60, '1.00', 4, 50, 0, ''),
(61, '10.00', 4, 51, 0, ''),
(62, '12.00', 4, 53, 0, ''),
(63, '1.75', 4, 55, 0, ''),
(64, '12.75', 4, 56, 0, ''),
(65, '13.00', 4, 58, 0, ''),
(66, '3.00', 4, 76, 0, ''),
(67, '5.50', 4, 78, 0, ''),
(68, '6.50', 4, 79, 0, ''),
(69, '10.00', 5, 81, 0, ''),
(70, '12.00', 5, 74, 0, ''),
(71, '15.00', 5, 82, 0, ''),
(72, '15.50', 5, 77, 0, ''),
(73, '16.00', 5, 25, 0, ''),
(74, '9.00', 5, 26, 0, ''),
(75, '10.00', 5, 29, 0, ''),
(76, '11.00', 5, 30, 0, ''),
(77, '12.00', 5, 31, 0, ''),
(78, '13.00', 5, 32, 0, ''),
(79, '15.00', 5, 33, 0, ''),
(80, '18.00', 5, 34, 0, ''),
(81, '12.00', 5, 35, 0, ''),
(82, '13.00', 5, 37, 0, ''),
(83, '18.00', 5, 38, 0, ''),
(84, '10.00', 5, 39, 0, ''),
(85, '9.00', 5, 40, 0, ''),
(86, '8.00', 5, 47, 0, ''),
(87, '7.00', 5, 48, 0, ''),
(88, '7.50', 5, 50, 0, ''),
(89, '3.00', 5, 51, 0, ''),
(90, '0.00', 5, 53, 0, ''),
(91, '12.00', 5, 55, 0, ''),
(92, '15.00', 5, 56, 0, ''),
(93, '18.00', 5, 58, 0, ''),
(94, '6.00', 5, 76, 0, ''),
(95, '9.00', 5, 78, 0, ''),
(96, '8.00', 5, 79, 0, ''),
(97, '15.00', 6, 81, 0, ''),
(98, '10.00', 6, 74, 0, ''),
(99, '11.00', 6, 82, 0, ''),
(100, '10.00', 6, 77, 0, ''),
(101, '12.00', 6, 25, 0, ''),
(102, '3.00', 6, 26, 0, ''),
(103, '4.00', 6, 29, 0, ''),
(104, '15.00', 6, 30, 0, ''),
(105, '12.00', 6, 31, 0, ''),
(106, '1.00', 6, 32, 0, ''),
(107, '11.00', 6, 33, 0, ''),
(108, '3.00', 6, 34, 0, ''),
(109, '13.00', 6, 35, 0, ''),
(110, '18.00', 6, 37, 0, ''),
(111, '15.00', 6, 38, 0, ''),
(112, '16.00', 6, 39, 0, ''),
(113, '13.00', 6, 40, 0, ''),
(114, '14.00', 6, 47, 0, ''),
(115, '12.00', 6, 48, 0, ''),
(116, '15.00', 6, 50, 0, ''),
(117, '12.00', 6, 51, 0, ''),
(118, '13.00', 6, 53, 0, ''),
(119, '12.00', 6, 55, 0, ''),
(120, '11.00', 6, 56, 0, ''),
(121, '10.50', 6, 58, 0, ''),
(122, '5.00', 6, 76, 0, ''),
(123, '5.50', 6, 78, 0, ''),
(124, '6.00', 6, 79, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `parente`
--

CREATE TABLE IF NOT EXISTS `parente` (
  `LIBELLE` varchar(15) NOT NULL,
  PRIMARY KEY (`LIBELLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `parente`
--

INSERT INTO `parente` (`LIBELLE`) VALUES
('COUSINE'),
('FRERE'),
('MERE'),
('NIECE'),
('PERE'),
('SOEUR');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `IDPAYS` int(11) NOT NULL AUTO_INCREMENT,
  `PAYS` varchar(30) NOT NULL,
  PRIMARY KEY (`IDPAYS`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`IDPAYS`, `PAYS`) VALUES
(1, 'Cameroun'),
(2, 'Guinée Equ.'),
(3, 'Nigeria'),
(4, 'Tchad');

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

CREATE TABLE IF NOT EXISTS `personnels` (
  `IDPERSONNEL` int(11) NOT NULL AUTO_INCREMENT,
  `MATRICULE` varchar(15) CHARACTER SET latin1 NOT NULL,
  `USER` int(11) DEFAULT NULL,
  `CIVILITE` varchar(10) DEFAULT NULL,
  `NOM` varchar(30) CHARACTER SET latin1 NOT NULL,
  `PRENOM` varchar(30) CHARACTER SET latin1 NOT NULL,
  `AUTRENOM` varchar(30) CHARACTER SET latin1 NOT NULL,
  `FONCTION` int(11) DEFAULT NULL,
  `GRADE` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `DATENAISS` date DEFAULT NULL,
  `PORTABLE` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `TELEPHONE` varchar(15) CHARACTER SET latin1 NOT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `PHOTO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`IDPERSONNEL`),
  KEY `CIVILITE` (`CIVILITE`),
  KEY `LOGIN` (`USER`),
  KEY `FONCTION` (`FONCTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `personnels`
--

INSERT INTO `personnels` (`IDPERSONNEL`, `MATRICULE`, `USER`, `CIVILITE`, `NOM`, `PRENOM`, `AUTRENOM`, `FONCTION`, `GRADE`, `DATENAISS`, `PORTABLE`, `TELEPHONE`, `EMAIL`, `PHOTO`) VALUES
(1, 'ADMIN', 1, 'Mr', 'Bruno', 'Bruno', '', 4, NULL, NULL, '652847527', '65847224', 'admin@yahoo.fr', NULL),
(2, 'ADMIN2', 4, 'Mr', 'Ainam', 'Jean-paul', '', 3, '', '0000-00-00', '554125883', '125785475', 'jpainam@gmail.com', NULL),
(3, 'ASSIST01', 5, 'Mlle', 'Estelle', 'Estelle', '', 1, '', '0000-00-00', '26585685', '54585166', 'assistant@yahoo.fr', NULL),
(5, 'PERSO01', 2, 'Mr', 'Achillle', 'Avom', '', 1, '', '0000-00-00', '+237 673005451', '+237652289165', 'person@yahoo.fr', NULL),
(6, '', NULL, 'Mr', 'Ainam ', 'Jean Paul', '', 1, '', '2015-07-07', '652289165', '', 'cebon@gyhahoo.fr', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `IDPROFILE` int(11) NOT NULL AUTO_INCREMENT,
  `PROFILE` varchar(100) CHARACTER SET utf8 NOT NULL,
  `LISTEDROIT` text,
  PRIMARY KEY (`IDPROFILE`),
  KEY `PROFILE` (`PROFILE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `profile`
--

INSERT INTO `profile` (`IDPROFILE`, `PROFILE`, `LISTEDROIT`) VALUES
(1, 'Administrateur', NULL),
(2, 'Assistant de bureau', NULL),
(3, 'Enseignant', NULL),
(4, 'Infirmerie', NULL),
(5, 'Responsable', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `punitions`
--

CREATE TABLE IF NOT EXISTS `punitions` (
  `IDPUNITION` int(11) NOT NULL AUTO_INCREMENT,
  `ELEVE` int(11) NOT NULL,
  `DATEPUNITION` date NOT NULL,
  `DATEENREGISTREMENT` date NOT NULL,
  `DUREE` int(11) NOT NULL COMMENT 'en terme de nombre de jour',
  `TYPEPUNITION` int(11) DEFAULT NULL,
  `MOTIF` varchar(200) NOT NULL,
  `DESCRIPTION` text,
  `PUNIPAR` int(11) DEFAULT NULL,
  `ENREGISTRERPAR` varchar(30) DEFAULT NULL,
  `ANNEEACADEMIQUE` varchar(13) NOT NULL,
  PRIMARY KEY (`IDPUNITION`),
  KEY `ANNEEACADEMIQUE` (`ANNEEACADEMIQUE`),
  KEY `ELEVE` (`ELEVE`),
  KEY `TYPEPUNITION` (`TYPEPUNITION`),
  KEY `PUNIPAR` (`PUNIPAR`),
  KEY `ENREGISTRERPAR` (`ENREGISTRERPAR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `punitions`
--

INSERT INTO `punitions` (`IDPUNITION`, `ELEVE`, `DATEPUNITION`, `DATEENREGISTREMENT`, `DUREE`, `TYPEPUNITION`, `MOTIF`, `DESCRIPTION`, `PUNIPAR`, `ENREGISTRERPAR`, `ANNEEACADEMIQUE`) VALUES
(6, 74, '2015-06-17', '2015-06-17', 0, 0, 'bryrty', 'ybrybrtbty', 3, 'armel', '2014-2015'),
(8, 78, '2015-06-22', '2015-06-22', 0, 0, '', '', 3, 'armel', '2014-2015');

-- --------------------------------------------------------

--
-- Structure de la table `responsables`
--

CREATE TABLE IF NOT EXISTS `responsables` (
  `IDRESPONSABLE` int(11) NOT NULL AUTO_INCREMENT,
  `CIVILITE` varchar(15) DEFAULT NULL,
  `NOM` varchar(30) NOT NULL,
  `PRENOM` varchar(30) NOT NULL,
  `ADRESSE` varchar(150) NOT NULL,
  `BP` varchar(8) DEFAULT NULL,
  `TELEPHONE` varchar(15) NOT NULL,
  `PORTABLE` varchar(15) DEFAULT NULL,
  `EMAIL` varchar(75) DEFAULT NULL,
  `PROFESSION` varchar(150) DEFAULT NULL,
  `ACCEPTESMS` int(11) DEFAULT NULL COMMENT '0 = n''accepte pas de sms, 1 = accepte de sms',
  `NUMSMS` varchar(15) DEFAULT NULL COMMENT 'numero sur lequel il accepte les sms',
  PRIMARY KEY (`IDRESPONSABLE`),
  KEY `CIVILITE` (`CIVILITE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Contenu de la table `responsables`
--

INSERT INTO `responsables` (`IDRESPONSABLE`, `CIVILITE`, `NOM`, `PRENOM`, `ADRESSE`, `BP`, `TELEPHONE`, `PORTABLE`, `EMAIL`, `PROFESSION`, `ACCEPTESMS`, `NUMSMS`) VALUES
(53, 'Mr', 'Kadje', 'Talom', 'Ekounou', '', '66769526', '67589635', 'kadje@yahoo.fr', 'Cadre à Camtel', 0, '66769526'),
(54, 'Mr', 'Suzanne', 'Elise', 'Avenue Kennedy', '', '', '99602535', '', '', 0, ''),
(55, 'Mr', 'responfinal', '', '##', '', '', 'ezee', '', '', 1, ''),
(57, 'Dr', 'tbretb', 'bertbtr', 'brebrt', 'bretbrt', 'betrb', '', 'betrbr', 'rtbrt', 1, 'bertb');

-- --------------------------------------------------------

--
-- Structure de la table `responsable_eleve`
--

CREATE TABLE IF NOT EXISTS `responsable_eleve` (
  `IDRESPONSABLEELEVE` int(11) NOT NULL AUTO_INCREMENT,
  `IDRESPONSABLE` int(11) NOT NULL,
  `IDELEVE` int(11) NOT NULL,
  `PARENTE` varchar(15) DEFAULT NULL,
  `CHARGES` varchar(250) DEFAULT NULL COMMENT 'Les charges de ce responsable sous forme d''objet JSON',
  PRIMARY KEY (`IDRESPONSABLEELEVE`),
  KEY `PARENTE` (`PARENTE`),
  KEY `IDRESPONSABLE` (`IDRESPONSABLE`,`IDELEVE`),
  KEY `responsable_eleve_ibfk_2` (`IDELEVE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Contenu de la table `responsable_eleve`
--

INSERT INTO `responsable_eleve` (`IDRESPONSABLEELEVE`, `IDRESPONSABLE`, `IDELEVE`, `PARENTE`, `CHARGES`) VALUES
(51, 53, 73, 'COUSINE', '["Accident","Contact","Financier"]'),
(52, 53, 74, 'COUSINE', '["Accident","Contact","Financier"]'),
(56, 54, 74, 'MERE', '["Accident","Contact","Financier"]'),
(59, 53, 77, 'COUSINE', '["Accident","Contact"]'),
(60, 55, 78, 'COUSINE', '[]'),
(64, 54, 77, 'COUSINE', '[]'),
(66, 55, 74, 'COUSINE', '[]'),
(67, 53, 81, 'COUSINE', '["Accident","Contact"]'),
(68, 53, 82, 'COUSINE', '["Contact","Financier"]');

-- --------------------------------------------------------

--
-- Structure de la table `scolarites`
--

CREATE TABLE IF NOT EXISTS `scolarites` (
  `IDSCOLARITE` int(11) NOT NULL AUTO_INCREMENT,
  `ELEVE` int(11) NOT NULL,
  `FRAIS` int(11) NOT NULL,
  `CAISSE` int(11) DEFAULT NULL COMMENT 'Entree de la caisse permettant d effectuer cet enregistrement',
  `MONTANT` int(11) NOT NULL,
  `DATEPAYEMENT` date NOT NULL,
  `ANNEEACADEMIQUE` varchar(30) NOT NULL,
  `REALISERPAR` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDSCOLARITE`),
  KEY `ELEVE` (`ELEVE`,`FRAIS`),
  KEY `FRAIS` (`FRAIS`),
  KEY `REALISERPAR` (`REALISERPAR`),
  KEY `ANNEEACADEMIQUE` (`ANNEEACADEMIQUE`),
  KEY `CAISSE` (`CAISSE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sequences`
--

CREATE TABLE IF NOT EXISTS `sequences` (
  `IDSEQUENCE` int(11) NOT NULL AUTO_INCREMENT,
  `TRIMESTRE` int(11) NOT NULL,
  `LIBELLE` varchar(30) NOT NULL,
  `LIBELLEHTML` varchar(50) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `VERROUILLER` int(2) NOT NULL DEFAULT '0' COMMENT '0 = non verrouiller; 1 = verrouiller',
  PRIMARY KEY (`IDSEQUENCE`),
  KEY `SEMESTRE` (`TRIMESTRE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `sequences`
--

INSERT INTO `sequences` (`IDSEQUENCE`, `TRIMESTRE`, `LIBELLE`, `LIBELLEHTML`, `DATEDEBUT`, `DATEFIN`, `ORDRE`, `VERROUILLER`) VALUES
(1, 1, '1ère Séquence', '1<sup>ère</sup> Séquence', '2014-09-01', '2014-10-01', 1, 0),
(2, 1, '2nde Séquence', '2<sup>nde</sup> Séquence', '2014-10-02', '2014-11-01', 2, 0),
(3, 2, '3ème Séquence', '3<sup>ème</sup> Séquence', '2014-11-02', '2014-12-01', 3, 0),
(4, 2, '4ème Séquence', '4<sup>ème</sup> Séquence', '0000-00-00', '0000-00-00', 4, 0),
(5, 3, '5ème Séquence', '5<sup>ème</sup> Séquence', '0000-00-00', '0000-00-00', 5, 0),
(6, 3, '6ème Séquence', '6<sup>ème</sup> Séquence', '2015-05-01', '2015-07-31', 6, 0);

-- --------------------------------------------------------

--
-- Structure de la table `trimestres`
--

CREATE TABLE IF NOT EXISTS `trimestres` (
  `IDTRIMESTRE` int(11) NOT NULL AUTO_INCREMENT,
  `PERIODE` varchar(30) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `LIBELLE` varchar(50) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `VERROUILLER` int(2) NOT NULL DEFAULT '0' COMMENT '0=Non verrouiller, 1 = verrouiller',
  PRIMARY KEY (`IDTRIMESTRE`),
  KEY `ANNEEACADEMIQUE` (`PERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `trimestres`
--

INSERT INTO `trimestres` (`IDTRIMESTRE`, `PERIODE`, `DATEDEBUT`, `DATEFIN`, `LIBELLE`, `ORDRE`, `VERROUILLER`) VALUES
(1, '2014-2015', '2014-09-02', '2014-11-23', '1er Trimestre', 1, 0),
(2, '2014-2015', '2014-11-24', '2015-03-08', '2ème Trimestre', 2, 0),
(3, '2014-2015', '2015-03-09', '2015-07-04', '3ème Trimestre', 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_notes`
--

CREATE TABLE IF NOT EXISTS `type_notes` (
  `IDTYPENOTE` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(150) NOT NULL,
  PRIMARY KEY (`IDTYPENOTE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `type_notes`
--

INSERT INTO `type_notes` (`IDTYPENOTE`, `TYPE`) VALUES
(1, 'Devoir personnalisé'),
(2, 'Devoir harmonisé'),
(3, 'Autre type de notes');

-- --------------------------------------------------------

--
-- Structure de la table `type_punitions`
--

CREATE TABLE IF NOT EXISTS `type_punitions` (
  `IDTYPEPUNITION` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(150) NOT NULL,
  PRIMARY KEY (`IDTYPEPUNITION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `type_punitions`
--

INSERT INTO `type_punitions` (`IDTYPEPUNITION`, `LIBELLE`) VALUES
(1, 'Exclusion'),
(2, 'Retenue'),
(3, 'Rapport');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `IDUSER` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(80) CHARACTER SET utf8 NOT NULL,
  `PASSWORD` text CHARACTER SET utf8 NOT NULL,
  `PROFILE` int(11) DEFAULT NULL,
  `DROITSPECIFIQUE` text CHARACTER SET utf8,
  `ACTIF` int(11) NOT NULL DEFAULT '1' COMMENT 'Actif = 1 et 0 = Non actif (cad bloquee)',
  PRIMARY KEY (`IDUSER`),
  UNIQUE KEY `LOGIN` (`LOGIN`),
  KEY `PROFILE` (`PROFILE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`IDUSER`, `LOGIN`, `PASSWORD`, `PROFILE`, `DROITSPECIFIQUE`, `ACTIF`) VALUES
(1, 'armel', '069a6a9ccaaca7967a0c43cb5e161187', 1, '["103","104","105","201","202","203","204","205","206","207","208","209","212","213","301","302","304","305","306","320","323","324","401","402","403","405","406","407","408","409","410","501","502","503","504","505","506","507","508","513","515","517","602","603","604","605","606"]', 1),
(2, 'bruno', 'md5(''bruno'')', 1, '["301"]', 1),
(3, 'estelle', 'md5(''estelle'')', 2, '["104","105","201"]', 1),
(4, 'jp', '55add3d845bfcd87a9b0949b0da49c0a', 1, '["103","104","105","201","202","203","204","205","206","207","208","212","213","301","302","304","305","306","309","320","323","401","402","403","405","406","407","408","409","410","411","501","502","503","504","505","506","508","602","603","605","606"]', 1),
(5, 'nom1', 'md5(''nom1'')', 2, '["102","103","201","202"]', 1),
(6, 'nom2', 'md5(''nom2'')', 4, '["101","102","103","104","105","201","202","203","204","205","206","207","301","302","303","304","305","306","307","308","309","310","311","312","313","314","315","401","402","403","404","405","406","501","502","503","504","505","506","507","601","602","603","604","605","701","702","801","802","803"]', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vacances`
--

CREATE TABLE IF NOT EXISTS `vacances` (
  `IDVACANCE` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(50) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `PERIODE` varchar(15) NOT NULL,
  PRIMARY KEY (`IDVACANCE`),
  KEY `PERIODE` (`PERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `vacances`
--

INSERT INTO `vacances` (`IDVACANCE`, `LIBELLE`, `DATEDEBUT`, `DATEFIN`, `PERIODE`) VALUES
(1, 'Grand vacances', '2015-07-31', '2015-09-01', '2014-2015');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`ELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absences_ibfk_2` FOREIGN KEY (`APPEL`) REFERENCES `appels` (`IDAPPEL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `appels`
--
ALTER TABLE `appels`
  ADD CONSTRAINT `appels_ibfk_1` FOREIGN KEY (`CLASSE`) REFERENCES `classes` (`IDCLASSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appels_ibfk_2` FOREIGN KEY (`REALISERPAR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `appels_ibfk_3` FOREIGN KEY (`MODIFIERPAR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `caisses`
--
ALTER TABLE `caisses`
  ADD CONSTRAINT `caisses_ibfk_1` FOREIGN KEY (`COMPTE`) REFERENCES `comptes_eleves` (`IDCOMPTE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `caisses_ibfk_2` FOREIGN KEY (`JOURNAL`) REFERENCES `journals` (`IDTYPE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `caisses_ibfk_3` FOREIGN KEY (`REALISERPAR`) REFERENCES `users` (`LOGIN`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`DECOUPAGE`) REFERENCES `decoupage` (`IDDECOUPAGE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`ANNEEACADEMIQUE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_3` FOREIGN KEY (`NIVEAU`) REFERENCES `niveau` (`IDNIVEAU`);

--
-- Contraintes pour la table `classes_parametres`
--
ALTER TABLE `classes_parametres`
  ADD CONSTRAINT `classes_parametres_ibfk_1` FOREIGN KEY (`CLASSE`) REFERENCES `classes` (`IDCLASSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_parametres_ibfk_2` FOREIGN KEY (`ANNEEACADEMIQUE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_parametres_ibfk_3` FOREIGN KEY (`PROFPRINCIPALE`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_parametres_ibfk_4` FOREIGN KEY (`CPEPRINCIPALE`) REFERENCES `responsables` (`IDRESPONSABLE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_parametres_ibfk_5` FOREIGN KEY (`RESPADMINISTRATIF`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `comptes_eleves`
--
ALTER TABLE `comptes_eleves`
  ADD CONSTRAINT `comptes_eleves_ibfk_1` FOREIGN KEY (`ELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comptes_eleves_ibfk_2` FOREIGN KEY (`CREERPAR`) REFERENCES `users` (`LOGIN`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_6` FOREIGN KEY (`NATIONALITE`) REFERENCES `pays` (`IDPAYS`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `eleves_ibfk_7` FOREIGN KEY (`PAYSNAISS`) REFERENCES `pays` (`IDPAYS`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `emplois`
--
ALTER TABLE `emplois`
  ADD CONSTRAINT `emplois_ibfk_1` FOREIGN KEY (`IDENSEIGNEMENT`) REFERENCES `enseignements` (`IDENSEIGNEMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `enseignements`
--
ALTER TABLE `enseignements`
  ADD CONSTRAINT `enseignements_ibfk_1` FOREIGN KEY (`MATIERE`) REFERENCES `matieres` (`IDMATIERE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `enseignements_ibfk_2` FOREIGN KEY (`PROFESSEUR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `enseignements_ibfk_3` FOREIGN KEY (`CLASSE`) REFERENCES `classes` (`IDCLASSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enseignements_ibfk_4` FOREIGN KEY (`GROUPE`) REFERENCES `groupe` (`IDGROUPE`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `feries`
--
ALTER TABLE `feries`
  ADD CONSTRAINT `feries_ibfk_1` FOREIGN KEY (`PERIODE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fermetures`
--
ALTER TABLE `fermetures`
  ADD CONSTRAINT `fermetures_ibfk_1` FOREIGN KEY (`PERIODE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `frais`
--
ALTER TABLE `frais`
  ADD CONSTRAINT `frais_ibfk_1` FOREIGN KEY (`CLASSE`) REFERENCES `classes` (`IDCLASSE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`IDELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`IDCLASSE`) REFERENCES `classes` (`IDCLASSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_3` FOREIGN KEY (`ANNEEACADEMIQUE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `justifications`
--
ALTER TABLE `justifications`
  ADD CONSTRAINT `justifications_ibfk_1` FOREIGN KEY (`REALISERPAR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`CODEDROIT`) REFERENCES `droits` (`CODEDROIT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`IDGROUPE`) REFERENCES `groupemenus` (`IDGROUPE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notations`
--
ALTER TABLE `notations`
  ADD CONSTRAINT `notations_ibfk_1` FOREIGN KEY (`REALISERPAR`) REFERENCES `personnels` (`IDPERSONNEL`),
  ADD CONSTRAINT `notations_ibfk_2` FOREIGN KEY (`SEQUENCE`) REFERENCES `sequences` (`IDSEQUENCE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notations_ibfk_3` FOREIGN KEY (`TYPENOTE`) REFERENCES `type_notes` (`IDTYPENOTE`),
  ADD CONSTRAINT `notations_ibfk_4` FOREIGN KEY (`ENSEIGNEMENT`) REFERENCES `enseignements` (`IDENSEIGNEMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`ELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`NOTATION`) REFERENCES `notations` (`IDNOTATION`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnels`
--
ALTER TABLE `personnels`
  ADD CONSTRAINT `personnels_ibfk_1` FOREIGN KEY (`CIVILITE`) REFERENCES `civilite` (`CIVILITE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `personnels_ibfk_3` FOREIGN KEY (`FONCTION`) REFERENCES `fonctions` (`IDFONCTION`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `personnels_ibfk_4` FOREIGN KEY (`USER`) REFERENCES `users` (`IDUSER`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `punitions`
--
ALTER TABLE `punitions`
  ADD CONSTRAINT `punitions_ibfk_1` FOREIGN KEY (`ELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `punitions_ibfk_2` FOREIGN KEY (`ANNEEACADEMIQUE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `punitions_ibfk_5` FOREIGN KEY (`ENREGISTRERPAR`) REFERENCES `users` (`LOGIN`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `punitions_ibfk_6` FOREIGN KEY (`PUNIPAR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `responsables`
--
ALTER TABLE `responsables`
  ADD CONSTRAINT `responsables_ibfk_1` FOREIGN KEY (`CIVILITE`) REFERENCES `civilite` (`CIVILITE`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `responsable_eleve`
--
ALTER TABLE `responsable_eleve`
  ADD CONSTRAINT `responsable_eleve_ibfk_1` FOREIGN KEY (`IDRESPONSABLE`) REFERENCES `responsables` (`IDRESPONSABLE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsable_eleve_ibfk_2` FOREIGN KEY (`IDELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsable_eleve_ibfk_3` FOREIGN KEY (`PARENTE`) REFERENCES `parente` (`LIBELLE`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `scolarites`
--
ALTER TABLE `scolarites`
  ADD CONSTRAINT `scolarites_ibfk_1` FOREIGN KEY (`ELEVE`) REFERENCES `eleves` (`IDELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scolarites_ibfk_2` FOREIGN KEY (`FRAIS`) REFERENCES `frais` (`IDFRAIS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scolarites_ibfk_3` FOREIGN KEY (`ANNEEACADEMIQUE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scolarites_ibfk_4` FOREIGN KEY (`CAISSE`) REFERENCES `caisses` (`IDCAISSE`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `scolarites_ibfk_5` FOREIGN KEY (`REALISERPAR`) REFERENCES `personnels` (`IDPERSONNEL`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `sequences`
--
ALTER TABLE `sequences`
  ADD CONSTRAINT `sequences_ibfk_1` FOREIGN KEY (`TRIMESTRE`) REFERENCES `trimestres` (`IDTRIMESTRE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `trimestres`
--
ALTER TABLE `trimestres`
  ADD CONSTRAINT `trimestres_ibfk_1` FOREIGN KEY (`PERIODE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`PROFILE`) REFERENCES `profile` (`IDPROFILE`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `vacances`
--
ALTER TABLE `vacances`
  ADD CONSTRAINT `vacances_ibfk_1` FOREIGN KEY (`PERIODE`) REFERENCES `anneeacademique` (`ANNEEACADEMIQUE`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
