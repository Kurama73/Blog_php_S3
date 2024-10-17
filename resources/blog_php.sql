-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 oct. 2024 à 11:32
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
  `pseudo` varchar(100) NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `description`, `date`, `pseudo`, `id_utilisateur`) VALUES
(1, 'Les Bienfaits de la Méditation', 'La méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n\r\nLa méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n\r\n\r\n\r\nLa méditation est une pratique millénaire qui apporte de nombreux bienfaits. Elle aide à réduire le stress, améliore la concentration et favorise la paix intérieure. En prenant quelques minutes par jour pour méditer, vous pouvez transformer votre esprit et améliorer votre qualité de vie. Essayez-la !\r\n\r\n', '2024-10-01 08:00:00', 'UserOne', 1),
(2, 'Advanced MySQL Tips', 'Learn advanced features of MySQL for better performance.', '2024-10-02 10:00:00', 'AdminUser', 2),
(3, 'Web Design Trends 2024', 'Discover the latest web design trends for 2024.', '2024-10-05 12:30:00', 'UserTwo', 3),
(4, 'Introduction to APIs', 'How to build and use APIs effectively.', '2024-10-07 07:15:00', 'UserThree', 1),
(5, 'AI and the Future of Work', 'Exploring how AI will transform industries.', '2024-10-09 14:45:00', 'UserFour', 4),
(6, 'Titre de l\'article 1', 'Ceci est la description de l\'article 1.', '2024-10-09 22:00:00', 'user1', NULL),
(7, 'Titre de l\'article 2', 'Ceci est la description de l\'article 2.', '2024-10-10 22:00:00', 'user2', NULL),
(8, 'Titre de l\'article 3', 'Ceci est la description de l\'article 3.', '2024-10-11 22:00:00', 'user3', NULL),
(9, 'Titre de l\'article 4', 'Ceci est la description de l\'article 4.', '2024-10-12 22:00:00', 'user4', NULL),
(10, 'Titre de l\'article 5', 'Ceci est la description de l\'article 5.', '2024-10-13 22:00:00', 'user5', NULL),
(11, 'Titre de l\'article 6', 'Ceci est la description de l\'article 6.', '2024-10-14 22:00:00', 'user6', NULL),
(12, 'Titre de l\'article 7', 'Ceci est la description de l\'article 7.', '2024-10-15 22:00:00', 'user7', NULL),
(13, 'Titre de l\'article 8', 'Ceci est la description de l\'article 8.', '2024-10-16 22:00:00', 'user8', NULL),
(14, 'Titre de l\'article 9', 'Ceci est la description de l\'article 9.', '2024-10-17 22:00:00', 'user9', NULL),
(15, 'Titre de l\'article 10', 'Ceci est la description de l\'article 10.', '2024-10-18 22:00:00', 'user10', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
