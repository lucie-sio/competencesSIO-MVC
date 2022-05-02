-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 02 mai 2022 à 17:08
-- Version du serveur : 5.7.26
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bxxxecxn_competencessio`
--

-- --------------------------------------------------------

--
-- Structure de la table `acquerir`
--

DROP TABLE IF EXISTS `acquerir`;
CREATE TABLE IF NOT EXISTS `acquerir` (
  `IDENTIFIANT_ETUD` char(32) NOT NULL,
  `N_ITEM` char(255) NOT NULL,
  `MISE_EN_OEUVRE` tinyint(1) DEFAULT NULL,
  `ACQUISE` tinyint(1) DEFAULT NULL,
  `EN_COURS_ACQUISITION` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`IDENTIFIANT_ETUD`,`N_ITEM`),
  KEY `I_FK_ACQUERIR_ETUDIANT` (`IDENTIFIANT_ETUD`),
  KEY `I_FK_ACQUERIR_ITEM_COMPETENCE` (`N_ITEM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blocs`
--

DROP TABLE IF EXISTS `blocs`;
CREATE TABLE IF NOT EXISTS `blocs` (
  `ID_NOM_BLOC` char(255) NOT NULL,
  `LIBEL_BLOC` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID_NOM_BLOC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `N_ITEM` char(255) NOT NULL,
  `N_ITEM_1` char(32) NOT NULL,
  `N_ITEM_2` char(32) NOT NULL,
  PRIMARY KEY (`N_ITEM`,`N_ITEM_1`,`N_ITEM_2`),
  KEY `I_FK_CONTENIR_ITEM_COMPETENCE` (`N_ITEM`),
  KEY `I_FK_CONTENIR_ITEM_INDICATEUR` (`N_ITEM_1`),
  KEY `I_FK_CONTENIR_SAVOIR` (`N_ITEM_2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ensemble_de_competence`
--

DROP TABLE IF EXISTS `ensemble_de_competence`;
CREATE TABLE IF NOT EXISTS `ensemble_de_competence` (
  `ID_ENSEMBLE_COMPETENCE` char(255) NOT NULL,
  `ID_NOM_BLOC` char(255) NOT NULL,
  `LIBEL_ENSEMBLE_COMPETENCE` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID_ENSEMBLE_COMPETENCE`),
  KEY `I_FK_ENSEMBLE_DE_COMPETENCE_BLOCS` (`ID_NOM_BLOC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `IDENTIFIANT_ETUD` char(255) NOT NULL,
  `NOM_ETUD` char(255) DEFAULT NULL,
  `PRENOM_ETUD` char(255) DEFAULT NULL,
  `OPTION_BTS_ETUD` char(255) DEFAULT NULL,
  `PORTFOLIO_ETUD` char(255) DEFAULT NULL,
  `DATE_NAISSANCE_ETUD` datetime DEFAULT NULL,
  `EMAIL_ETUD` varchar(255) NOT NULL,
  `MDP_ETUD` varchar(255) DEFAULT '$2y$12$vzSKz3RoGGsSaS0/1VCvbel64/cjHg5fSrMaKykl197GeQA3sApam',
  `TOKEN` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IDENTIFIANT_ETUD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `indicateur`
--

DROP TABLE IF EXISTS `indicateur`;
CREATE TABLE IF NOT EXISTS `indicateur` (
  `N_ITEM` char(32) NOT NULL,
  `ID_PROJET` smallint(6) NOT NULL,
  PRIMARY KEY (`N_ITEM`,`ID_PROJET`),
  KEY `I_FK_INDICATEUR_ITEM_INDICATEUR` (`N_ITEM`),
  KEY `I_FK_INDICATEUR_PROJET` (`ID_PROJET`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_competence`
--

DROP TABLE IF EXISTS `item_competence`;
CREATE TABLE IF NOT EXISTS `item_competence` (
  `N_ITEM` char(255) NOT NULL,
  `ID_ENSEMBLE_COMPETENCE` char(255) NOT NULL,
  `LIBEL_ITEM` char(255) DEFAULT NULL,
  PRIMARY KEY (`N_ITEM`),
  KEY `I_FK_ITEM_COMPETENCE_ENSEMBLE_DE_COMPETENCE` (`ID_ENSEMBLE_COMPETENCE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_indicateur`
--

DROP TABLE IF EXISTS `item_indicateur`;
CREATE TABLE IF NOT EXISTS `item_indicateur` (
  `N_ITEM` char(255) NOT NULL,
  `ID_ENSEMBLE_COMPETENCE` char(255) NOT NULL,
  `LIBEL_ITEM` char(255) DEFAULT NULL,
  PRIMARY KEY (`N_ITEM`),
  KEY `ID_ENSEMBLE_COMPETENCE` (`ID_ENSEMBLE_COMPETENCE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `maitriser`
--

DROP TABLE IF EXISTS `maitriser`;
CREATE TABLE IF NOT EXISTS `maitriser` (
  `N_ITEM` char(32) NOT NULL,
  `IDENTIFIANT_ETUD` char(32) NOT NULL,
  `MAITRISE` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`N_ITEM`,`IDENTIFIANT_ETUD`),
  KEY `I_FK_MAITRISER_SAVOIR` (`N_ITEM`),
  KEY `I_FK_MAITRISER_ETUDIANT` (`IDENTIFIANT_ETUD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mobiliser`
--

DROP TABLE IF EXISTS `mobiliser`;
CREATE TABLE IF NOT EXISTS `mobiliser` (
  `N_ITEM` char(32) NOT NULL,
  `ID_PROJET` smallint(6) NOT NULL,
  PRIMARY KEY (`N_ITEM`,`ID_PROJET`),
  KEY `I_FK_MOBILISER_SAVOIR` (`N_ITEM`),
  KEY `I_FK_MOBILISER_PROJET` (`ID_PROJET`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `ID_PROJET` smallint(6) NOT NULL,
  `LIBEL_PROJET` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PROJET`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `realiser`
--

DROP TABLE IF EXISTS `realiser`;
CREATE TABLE IF NOT EXISTS `realiser` (
  `ID_PROJET` smallint(6) NOT NULL,
  `IDENTIFIANT_ETUD` char(32) NOT NULL,
  PRIMARY KEY (`ID_PROJET`,`IDENTIFIANT_ETUD`),
  KEY `I_FK_REALISER_PROJET` (`ID_PROJET`),
  KEY `I_FK_REALISER_ETUDIANT` (`IDENTIFIANT_ETUD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `savoir`
--

DROP TABLE IF EXISTS `savoir`;
CREATE TABLE IF NOT EXISTS `savoir` (
  `N_ITEM` char(255) NOT NULL,
  `ID_ENSEMBLE_COMPETENCE` char(255) NOT NULL,
  `LIBEL_ITEM` char(255) DEFAULT NULL,
  PRIMARY KEY (`N_ITEM`),
  KEY `ID_ENSEMBLE_COMPETENCE` (`ID_ENSEMBLE_COMPETENCE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
