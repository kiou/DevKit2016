-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 11 Mai 2017 à 13:32
-- Version du serveur :  5.7.14
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `devkit2016`
--

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `menuId` int(11) NOT NULL,
  `menuCreated` datetime NOT NULL,
  `menuChanged` datetime DEFAULT NULL,
  `menuNom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menuLien` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menuDestination` int(11) NOT NULL,
  `menuPoid` int(11) NOT NULL DEFAULT '1',
  `menuParent` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `utilisateurId` int(11) NOT NULL,
  `utilisateurCreated` datetime NOT NULL,
  `utilisateurChanged` datetime DEFAULT NULL,
  `utilisateurRole` int(11) NOT NULL,
  `utilisateurNom` varchar(256) CHARACTER SET utf8 NOT NULL,
  `utilisateurPrenom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `utilisateurEtat` int(11) NOT NULL DEFAULT '1',
  `utilisateurEmail` varchar(160) CHARACTER SET utf8 NOT NULL,
  `utilisateurPasse` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateurId`, `utilisateurCreated`, `utilisateurChanged`, `utilisateurRole`, `utilisateurNom`, `utilisateurPrenom`, `utilisateurEtat`, `utilisateurEmail`, `utilisateurPasse`) VALUES
(1, '2015-06-13 00:00:00', '2016-09-29 10:14:00', 1, 'Pinelli', 'luc', 1, 'admin@colocarts.com', '1fab942889e352164e44b08114b857111955d31e');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_oublier`
--

CREATE TABLE `utilisateur_oublier` (
  `oublierId` int(11) NOT NULL,
  `oublierCreated` datetime NOT NULL,
  `oublierUtilisateur` int(11) NOT NULL,
  `oublierToken` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_role`
--

CREATE TABLE `utilisateur_role` (
  `roleId` int(11) NOT NULL,
  `roleNom` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur_role`
--

INSERT INTO `utilisateur_role` (`roleId`, `roleNom`) VALUES
(1, 'Administrateur');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menuId`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`utilisateurId`);

--
-- Index pour la table `utilisateur_oublier`
--
ALTER TABLE `utilisateur_oublier`
  ADD PRIMARY KEY (`oublierId`);

--
-- Index pour la table `utilisateur_role`
--
ALTER TABLE `utilisateur_role`
  ADD PRIMARY KEY (`roleId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `menuId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `utilisateurId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `utilisateur_oublier`
--
ALTER TABLE `utilisateur_oublier`
  MODIFY `oublierId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur_role`
--
ALTER TABLE `utilisateur_role`
  MODIFY `roleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
