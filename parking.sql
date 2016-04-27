-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 27 Avril 2016 à 15:48
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `parking`
--

-- --------------------------------------------------------

--
-- Structure de la table `listedattente`
--

CREATE TABLE IF NOT EXISTS `listedattente` (
  `numliste` int(5) NOT NULL,
  `position` int(2) NOT NULL,
  `duree` int(11) NOT NULL,
  `codeclient` int(5) NOT NULL,
  PRIMARY KEY (`numliste`),
  KEY `codeclient` (`codeclient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `listedattente`
--

INSERT INTO `listedattente` (`numliste`, `position`, `duree`, `codeclient`) VALUES
(1, 1, 7, 2),
(2, 2, 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `numnotif` int(3) NOT NULL,
  `datenotif` date NOT NULL,
  `nbjours` int(3) NOT NULL,
  `numuser` int(2) NOT NULL,
  PRIMARY KEY (`numnotif`),
  KEY `numuser` (`numuser`),
  KEY `numuser_2` (`numuser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `parking_utilisateurs`
--

CREATE TABLE IF NOT EXISTS `parking_utilisateurs` (
  `numplace` int(11) NOT NULL,
  `numuser` int(11) NOT NULL,
  PRIMARY KEY (`numplace`,`numuser`),
  KEY `numuser` (`numuser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `parking_utilisateurs`
--

INSERT INTO `parking_utilisateurs` (`numplace`, `numuser`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `stationnement`
--

CREATE TABLE IF NOT EXISTS `stationnement` (
  `numplace` int(11) NOT NULL,
  `datedebut` date NOT NULL,
  `echeance` date NOT NULL,
  PRIMARY KEY (`numplace`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stationnement`
--

INSERT INTO `stationnement` (`numplace`, `datedebut`, `echeance`) VALUES
(1, '2016-04-11', '2016-04-16');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `numutil` int(5) NOT NULL AUTO_INCREMENT,
  `nomutil` varchar(20) NOT NULL,
  `prenomutil` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `motdepasse` varchar(40) NOT NULL,
  `dateinscription` date NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`numutil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`numutil`, `nomutil`, `prenomutil`, `email`, `motdepasse`, `dateinscription`, `admin`, `statut`) VALUES
(1, 'JHINGOOR', 'Akram', 'akram@admin.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-10', 1, 1),
(2, 'GILIBERT', 'Kevin', 'kevgili@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-18', 0, 1),
(3, 'AZOULAI', 'Hicham', 'hicham@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-23', 0, 1),
(4, 'ZERROUDI', 'Cerine', 'cerise@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-12-01', 0, 1),
(5, 'SHAO', 'Chris', 'chris@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2016-04-19', 0, 1),
(6, 'PIAUGEARD', 'Alex', 'alex@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2016-04-20', 0, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `listedattente`
--
ALTER TABLE `listedattente`
  ADD CONSTRAINT `listedattente_ibfk_1` FOREIGN KEY (`codeclient`) REFERENCES `utilisateurs` (`numutil`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`numuser`) REFERENCES `utilisateurs` (`numutil`);

--
-- Contraintes pour la table `parking_utilisateurs`
--
ALTER TABLE `parking_utilisateurs`
  ADD CONSTRAINT `parking_utilisateurs_ibfk_1` FOREIGN KEY (`numplace`) REFERENCES `stationnement` (`numplace`),
  ADD CONSTRAINT `parking_utilisateurs_ibfk_2` FOREIGN KEY (`numuser`) REFERENCES `utilisateurs` (`numutil`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
