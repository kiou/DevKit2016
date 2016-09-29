-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 29 Septembre 2016 à 11:23
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `devkit2016`
--

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menuId` int(11) NOT NULL AUTO_INCREMENT,
  `menuCreated` datetime NOT NULL,
  `menuChanged` datetime DEFAULT NULL,
  `menuNom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menuLien` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menuDestination` int(11) NOT NULL,
  `menuPoid` int(11) NOT NULL,
  `menuParent` int(11) NOT NULL,
  PRIMARY KEY (`menuId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `utilisateurId` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateurCreated` datetime NOT NULL,
  `utilisateurChanged` datetime DEFAULT NULL,
  `utilisateurRole` int(11) NOT NULL,
  `utilisateurNom` varchar(256) CHARACTER SET utf8 NOT NULL,
  `utilisateurPrenom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `utilisateurEtat` int(11) NOT NULL DEFAULT '1',
  `utilisateurEmail` varchar(160) CHARACTER SET utf8 NOT NULL,
  `utilisateurPasse` varchar(128) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`utilisateurId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateurId`, `utilisateurCreated`, `utilisateurChanged`, `utilisateurRole`, `utilisateurNom`, `utilisateurPrenom`, `utilisateurEtat`, `utilisateurEmail`, `utilisateurPasse`) VALUES
(1, '2015-06-13 00:00:00', '2016-09-29 10:14:00', 1, 'Pinelli', 'luc', 1, 'admin@colocarts.com', '1fab942889e352164e44b08114b857111955d31e');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_oublier`
--

CREATE TABLE IF NOT EXISTS `utilisateur_oublier` (
  `oublierId` int(11) NOT NULL AUTO_INCREMENT,
  `oublierCreated` datetime NOT NULL,
  `oublierUtilisateur` int(11) NOT NULL,
  `oublierToken` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`oublierId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_role`
--

CREATE TABLE IF NOT EXISTS `utilisateur_role` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `roleNom` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateur_role`
--

INSERT INTO `utilisateur_role` (`roleId`, `roleNom`) VALUES
(1, 'Administrateur');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
