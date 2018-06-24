-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 23 juin 2018 à 00:50
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sondage`
--

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(500) NOT NULL,
  `ordre` int(11) NOT NULL,
  `idSondage` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Fk_sondage` (`idSondage`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `titre`, `ordre`, `idSondage`) VALUES
(1, 'Quel est votre série préférée ?', 1, 1),
(2, 'Question 2', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(500) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_question` (`idQuestion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id`, `libelle`, `idQuestion`) VALUES
(1, 'Kaamelott', 1),
(2, 'Dr House', 1),
(3, 'Réponse 1 - Question 2', 2),
(4, 'Réponse 2 - Question 2', 2);

-- --------------------------------------------------------

--
-- Structure de la table `sondage`
--

DROP TABLE IF EXISTS `sondage`;
CREATE TABLE IF NOT EXISTS `sondage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `token_url` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sondage`
--

INSERT INTO `sondage` (`id`, `titre`, `description`, `dateDebut`, `dateFin`, `token_url`) VALUES
(1, 'Sondage 1', '', '2018-05-22', '2018-06-30', ''),
(2, 'Sondage 2', '', '2018-05-15', '2018-06-27', ''),
(3, 'Sondage 3', 'Cloturé', '2018-06-13', '2018-06-22', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) DEFAULT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `password`, `type`) VALUES
(1, 'test', 'test', 'florian.lephore@outlook.com', 'test', 'USER');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_reponse`
--

DROP TABLE IF EXISTS `utilisateur_reponse`;
CREATE TABLE IF NOT EXISTS `utilisateur_reponse` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `idReponse` int(11) NOT NULL,
  `preference` int(11) NOT NULL,
  KEY `FK_utilisateur` (`idUtilisateur`),
  KEY `FK_utilisateur_reponse` (`idReponse`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur_reponse`
--

INSERT INTO `utilisateur_reponse` (`idUtilisateur`, `idReponse`, `preference`) VALUES
(1, 2, 2),
(1, 1, 1),
(1, 3, 2),
(1, 4, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `Fk_sondage` FOREIGN KEY (`idSondage`) REFERENCES `sondage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_question` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur_reponse`
--
ALTER TABLE `utilisateur_reponse`
  ADD CONSTRAINT `FK_utilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_utilisateur_reponse` FOREIGN KEY (`idReponse`) REFERENCES `reponse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
