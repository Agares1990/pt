-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 02 avr. 2022 à 16:38
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `niceone`
--

-- --------------------------------------------------------

--
-- Structure de la table `caracterestique_chambre`
--

DROP TABLE IF EXISTS `caracterestique_chambre`;
CREATE TABLE IF NOT EXISTS `caracterestique_chambre` (
  `idCaracterestiqueChambre` int NOT NULL AUTO_INCREMENT,
  `categorieChambreId` int NOT NULL,
  `langueId` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `caracterestique1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `caracterestique2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caracterestique3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idCaracterestiqueChambre`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `caracterestique_chambre`
--

INSERT INTO `caracterestique_chambre` (`idCaracterestiqueChambre`, `categorieChambreId`, `langueId`, `caracterestique1`, `caracterestique2`, `caracterestique3`) VALUES
(1, 1, 'fr', '1 grand lit simple de 140 cm', 'Salle de bain privative : douche', 'Air conditionné'),
(2, 1, 'en', '1 large single bed of 140 cm ', 'Private bathroom: shower', 'Air conditioning'),
(3, 2, 'fr', '2 grand lit simple de 140 cm', '2 Salle de bain privative : douche', 'Air conditionné'),
(4, 2, 'en', '2 large single beds of 140 cm', '2 Private bathroom: shower', 'Air conditioning'),
(5, 3, 'fr', 'Très spacieuse : 48 m²', 'Salle de bain privative avec jacuzzi 	', 'Vue mer'),
(6, 3, 'en', 'Very spacious: 48 m² ', 'Salle de bain privative avec jacuzzi 	', 'Sea view');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_chambre`
--

DROP TABLE IF EXISTS `categorie_chambre`;
CREATE TABLE IF NOT EXISTS `categorie_chambre` (
  `idCategorieChambre` int NOT NULL AUTO_INCREMENT,
  `nombreChambreDispo` int NOT NULL,
  `image1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tarifCategorieChambre` float NOT NULL,
  PRIMARY KEY (`idCategorieChambre`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `categorie_chambre`
--

INSERT INTO `categorie_chambre` (`idCategorieChambre`, `nombreChambreDispo`, `image1`, `image2`, `image3`, `tarifCategorieChambre`) VALUES
(1, 3, 'images/standard/room1.jpg', 'images/standard/room2.jpg', 'images/standard/room3.jpg', 100),
(2, 2, 'images/familyRoom/familyRoom1.jpg 	', ' 	images/familyRoom/familyRoom2.jpg 	', '', 130),
(3, 1, 'images/suite/suite1.jpg', '', '', 250);

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `idChambre` int NOT NULL AUTO_INCREMENT,
  `numChambre` int NOT NULL,
  `categorieChambreId` int NOT NULL,
  `imageChambre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `capaciteAdulte` int NOT NULL,
  `capaciteEnfant` int NOT NULL,
  PRIMARY KEY (`idChambre`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`idChambre`, `numChambre`, `categorieChambreId`, `imageChambre`, `capaciteAdulte`, `capaciteEnfant`) VALUES
(1, 1, 1, 'images/standard/room1.jpg', 2, 2),
(2, 2, 1, 'images/standard/room2.jpg', 2, 2),
(3, 3, 1, 'images/standard/room3.jpg', 2, 2),
(4, 4, 2, 'images/familyRoom/familyRoom1.jpg', 4, 3),
(5, 5, 2, 'images/familyRoom/familyRoom2.jpg', 4, 3),
(6, 6, 3, 'images/suite/suite1.jpg', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pays` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nom`, `prenom`, `email`, `mdp`, `tel`, `pays`) VALUES
(1, 'tom', 'ford', 'tomford@gmail.com', '$2y$10$XFDGrWzOSwp/Kf4J1D6t3u0aOvLBQE13HFSOtN8C7KKmI3kKmVQna', '+337XXXXXXXX', 'France'),
(2, 'tom', 'ford', 'tomford@gmail.com', '$2y$10$H0rTaZ3OLQSoW4cQV1zU3.xM2vMctrC/G4obk1YosrvPQ5u2pk1iG', '111111111111111', 'France'),
(3, 'fom', 'ford', 'tomford@gmail.com', '$2y$10$7AohEuF2zGAlQhS3m.C7ouDUpUqhJr71L38lzkrXLdy4pvSLoYhyi', '+337XXXXXXXX', 'France'),
(4, 'Dexter', 'Morgan', 'morgan@gmail.com', '$2y$10$EANqxTwk4m5MV0BrjKy/M.jn5nbTp1mYlLfgMp6dbCsp9FD45ttxS', '111111111111111', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `idCommentaire` int NOT NULL AUTO_INCREMENT,
  `clientId` int NOT NULL,
  `note` int NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `commentaire` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idCommentaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `description_chambre`
--

DROP TABLE IF EXISTS `description_chambre`;
CREATE TABLE IF NOT EXISTS `description_chambre` (
  `idDescription` int NOT NULL AUTO_INCREMENT,
  `chambreId` int NOT NULL,
  `categorieChambreId` int NOT NULL,
  `langueId` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idDescription`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `description_chambre`
--

INSERT INTO `description_chambre` (`idDescription`, `chambreId`, `categorieChambreId`, `langueId`, `description`) VALUES
(1, 1, 1, 'fr', 'Ces chambres Classiques au cadre chaleureux et agréable présentent une décoration évocatrice sur le thème du voyage et disposent d’équipements haut de gamme pour un séjour reposant au cœur de Nice.'),
(2, 1, 1, 'en', 'These Classic rooms in a warm and pleasant setting have an evocative decoration on the theme of travel and have top-of-the-range equipment for a relaxing stay in the heart of Nice. '),
(3, 2, 1, 'fr', 'Ces chambres Classiques au cadre chaleureux et agréable présentent une décoration évocatrice sur le thème du voyage et disposent d’équipements haut de gamme pour un séjour reposant au cœur de Nice.'),
(4, 2, 1, 'en', 'These Classic rooms in a warm and pleasant setting have an evocative decoration on the theme of travel and have top-of-the-range equipment for a relaxing stay in the heart of Nice. '),
(5, 3, 1, 'fr', 'Ces chambres Classiques au cadre chaleureux et agréable présentent une décoration évocatrice sur le thème du voyage et disposent d’équipements haut de gamme pour un séjour reposant au cœur de Nice.'),
(6, 3, 1, 'en', 'These Classic rooms in a warm and pleasant setting have an evocative decoration on the theme of travel and have top-of-the-range equipment for a relaxing stay in the heart of Nice. '),
(7, 4, 2, 'fr', 'Ces spacieuses chambres Familiales ont vue sur notre paisible jardin et disposent de tous les aménagements nécessaires pour passer un agréable séjour à Nice.'),
(8, 4, 2, 'rn', 'These spacious Family rooms have a view of our peaceful garden and have all the necessary facilities for a pleasant stay in Nice. '),
(9, 5, 2, 'fr', 'Ces spacieuses chambres Familiales ont vue sur notre paisible jardin et disposent de tous les aménagements nécessaires pour passer un agréable séjour à Nice.'),
(10, 5, 2, 'en', 'These spacious Family rooms have a view of our peaceful garden and have all the necessary facilities for a pleasant stay in Nice.'),
(11, 6, 3, 'fr', 'Elles ne sont que trois mais ont forgé l’histoire du Nice ONE. Les plus grands artistes y ont séjourné, laissant comme un parfum de talent et de glamour. Leurs meubles d’époque évoquent les splendeurs de Versailles et des rois de France.'),
(12, 6, 3, 'en', 'They are only three but have forged the history of Nice ONE. The greatest artists have stayed there, leaving a scent of talent and glamour. Their period furniture evokes the splendours of Versailles and the kings of France. ');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `idLangue` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `valeurLangue` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `iconeLangue` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLangue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`idLangue`, `valeurLangue`, `iconeLangue`) VALUES
('fr', 'Français', 'images/flags/fr.gif'),
('en', 'Anglais', 'images/flags/uk.gif'),
('it', 'Italien', 'images/flags/it.gif');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `idMessage` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sujet` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idMessage`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`idMessage`, `nom`, `email`, `sujet`, `message`) VALUES
(1, 'Lamjarad Brahim', 'agabra@gmail.com', 'HHH', 'sssssssssssssssss');

-- --------------------------------------------------------

--
-- Structure de la table `nom_categorie_chambre`
--

DROP TABLE IF EXISTS `nom_categorie_chambre`;
CREATE TABLE IF NOT EXISTS `nom_categorie_chambre` (
  `idNomCategorie` int NOT NULL AUTO_INCREMENT,
  `categorieChambreId` int NOT NULL,
  `langueId` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nomCategorie` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idNomCategorie`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `nom_categorie_chambre`
--

INSERT INTO `nom_categorie_chambre` (`idNomCategorie`, `categorieChambreId`, `langueId`, `nomCategorie`) VALUES
(1, 1, 'fr', 'Chambre Standard'),
(2, 1, 'en', 'Standard Room'),
(3, 2, 'fr', 'Chambre Familiale'),
(4, 2, 'en', 'Family Room'),
(5, 3, 'fr', 'Suite Senior'),
(6, 3, 'en', 'Senior Suite');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_chambre`
--

DROP TABLE IF EXISTS `reservation_chambre`;
CREATE TABLE IF NOT EXISTS `reservation_chambre` (
  `idReservationChambre` int NOT NULL AUTO_INCREMENT,
  `chambreId` int NOT NULL,
  `categorieChambreId` int NOT NULL,
  `clientId` int NOT NULL,
  `dateArriver` date NOT NULL,
  `dateDepart` date NOT NULL,
  `nbPerson` int NOT NULL,
  `nbChild` int NOT NULL,
  `requeteSpeciale` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idReservationChambre`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservation_chambre`
--

INSERT INTO `reservation_chambre` (`idReservationChambre`, `chambreId`, `categorieChambreId`, `clientId`, `dateArriver`, `dateDepart`, `nbPerson`, `nbChild`, `requeteSpeciale`) VALUES
(1, 4, 2, 1, '2022-04-01', '2022-04-30', 1, 2, ''),
(2, 4, 2, 2, '2022-04-15', '2022-04-20', 1, 2, ''),
(4, 6, 3, 4, '2022-04-22', '2022-04-29', 1, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_evenement`
--

DROP TABLE IF EXISTS `reservation_evenement`;
CREATE TABLE IF NOT EXISTS `reservation_evenement` (
  `idRservationEvenement` int NOT NULL AUTO_INCREMENT,
  `salleId` int NOT NULL,
  `clientId` int NOT NULL,
  `titreEvenement` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dateArriver` timestamp NOT NULL,
  `dateDepart` timestamp NOT NULL,
  `nombrePersonne` int NOT NULL,
  `requeteSpeciale` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idRservationEvenement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation_restaurant`
--

DROP TABLE IF EXISTS `reservation_restaurant`;
CREATE TABLE IF NOT EXISTS `reservation_restaurant` (
  `idReservationRestaurant` int NOT NULL AUTO_INCREMENT,
  `restaurantId` int NOT NULL,
  `clientId` int NOT NULL,
  `dateReseravation` timestamp NOT NULL,
  `repas` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombrePersonne` int NOT NULL,
  `requeteSpeciale` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idReservationRestaurant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `idRestaurant` int NOT NULL AUTO_INCREMENT,
  `tableNum` int NOT NULL,
  `imageRestaurant` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tarif` float NOT NULL,
  PRIMARY KEY (`idRestaurant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salle_evenement`
--

DROP TABLE IF EXISTS `salle_evenement`;
CREATE TABLE IF NOT EXISTS `salle_evenement` (
  `idSalle` int NOT NULL AUTO_INCREMENT,
  `nomSalle` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tarif` float NOT NULL,
  `capaciteSalle` int NOT NULL,
  `imageSalle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idSalle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
