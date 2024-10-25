-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 25, 2024 at 06:21 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_article` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `description`, `date_article`, `id_utilisateur`) VALUES
(28, 'The Future of AI', 'Artificial Intelligence is transforming industries worldwide. Its applications range from healthcare to finance, and the future holds endless possibilities for innovation, though ethical considerations are paramount in this expanding digital landscape.', '2024-10-25 06:12:44', 6),
(29, 'Sustainable Living Tips', 'Embracing sustainable living helps preserve the environment. Start with small actions like recycling, reducing energy consumption, and choosing eco-friendly products. Together, these choices contribute to a healthier, greener planet for future generations.', '2024-10-25 06:15:05', 5),
(30, 'Travel on a Budget', 'Traveling doesn\'\'t have to be expensive. With careful planning, you can explore new destinations without breaking the bank. Look for deals on flights, consider budget accommodations, and embrace local food for an affordable and enriching experience.', '2024-10-25 06:16:03', 4),
(31, 'The Power of Coding', 'Learning to code is more than a career choice; it’s a tool for problem-solving and creativity. Coding opens doors to innovation, allowing individuals to develop software, create solutions, and drive technological advancements in diverse fields.', '2024-10-25 06:17:03', 4),
(32, 'Benefits of Mindfulness', 'Practicing mindfulness reduces stress and improves well-being. By focusing on the present moment, individuals can foster a greater sense of peace, mental clarity, and resilience, helping them navigate daily challenges more effectively.', '2024-10-25 06:18:32', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(1, 'Programming'),
(2, 'Database'),
(3, 'Design'),
(4, 'Technology'),
(5, 'AI'),
(8, 'Sustainability'),
(9, 'Traveling'),
(10, 'Psychologie');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `contenu`, `date`, `id_article`, `pseudo`, `id_utilisateur`) VALUES
(13, 'Interesting', '2024-10-25 06:20:19', 30, '', 5),
(11, 'Lol :)', '2024-10-25 06:19:26', 32, '', 5),
(12, 'Ok.', '2024-10-25 06:19:43', 31, '', 5),
(10, 'Great !!', '2024-10-25 06:19:14', 32, '', 5),
(9, 'Super useful and inspiring article !', '2024-10-25 06:19:08', 32, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
CREATE TABLE IF NOT EXISTS `reference` (
  `id_article` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_article`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`id_article`, `id_categorie`) VALUES
(28, 5),
(29, 8),
(30, 9),
(31, 1),
(32, 10);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(6, 'tom@gmail.com', 'tom', 'tom', 0),
(2, 'userpikachu@example.com', 'pika', 'pika', 1),
(4, 'thomas@gmail.com', 'thomas', 'thomas', 0),
(5, 'alec@gmail.com', 'alec', 'alec', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
