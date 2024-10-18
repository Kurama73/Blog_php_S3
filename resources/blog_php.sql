-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 18 oct. 2024 à 08:19
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `description`, `date`, `id_utilisateur`) VALUES
(1, 'Les Bienfaits de la Méditation', 'La méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n\r\nLa méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n\r\n\r\n\r\nLa méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n', '2024-10-01 08:00:00', 1),
(2, 'Advanced MySQL Tips', 'Learn advanced features of MySQL for better performance.', '2024-10-02 10:00:00', 2),
(3, 'Web Design Trends 2024', 'Discover the latest web design trends for 2024.', '2024-10-05 12:30:00', 3),
(4, 'Introduction to APIs', 'How to build and use APIs effectively.', '2024-10-07 07:15:00', 1),
(5, 'AI and the Future of Work', 'Exploring how AI will transform industries.', '2024-10-09 14:45:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(1, 'Programming'),
(2, 'Database'),
(3, 'Design'),
(4, 'Technology'),
(5, 'AI');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_article` int DEFAULT NULL,
  `pseudo` varchar(100) NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_article` (`id_article`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `contenu`, `date`, `id_article`, `pseudo`, `id_utilisateur`) VALUES
(1, 'Great introduction, very helpful!', '2024-10-02 10:30:00', 1, 'UserTwo', NULL),
(2, 'Looking forward to the next article.', '2024-10-03 07:45:00', 1, 'UserThree', NULL),
(3, 'Can you cover more MySQL optimization techniques?', '2024-10-04 13:10:00', 2, 'UserOne', NULL),
(4, 'This trend is very interesting, thanks for sharing!', '2024-10-06 08:20:00', 3, 'UserFour', NULL),
(5, 'Very insightful article on AI.', '2024-10-09 15:00:00', 5, 'UserTwo', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reference`
--

DROP TABLE IF EXISTS `reference`;
CREATE TABLE IF NOT EXISTS `reference` (
  `id_article` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_article`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reference`
--

INSERT INTO `reference` (`id_article`, `id_categorie`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`(191))
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(1, 'user5@example.com', 'password5', 'UserFive', 0),
(2, 'user6@example.com', 'password6', 'UserSix', 0),
(3, 'user7@example.com', 'password7', 'UserSeven', 0),
(4, 'user8@example.com', 'password8', 'UserEight', 0),
(5, 'user9@example.com', 'password9', 'UserNine', 0),
(6, 'userjaloux@example.com', 'maths', 'm.jaloux', 0),
(7, 'userpikachu@example.com', 'pika', 'pikachu', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
