-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 18 jan. 2024 à 13:05
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tasksdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbltaks`
--

CREATE TABLE `tbltaks` (
  `id` int(11) NOT NULL COMMENT 'Task ID - Primary Key',
  `title` varchar(255) NOT NULL COMMENT 'Task Title',
  `description` mediumtext NOT NULL COMMENT 'Task Description',
  `deadline` datetime NOT NULL COMMENT 'Task Deadline Date',
  `completed` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Task Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Task table';

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbltaks`
--
ALTER TABLE `tbltaks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbltaks`
--
ALTER TABLE `tbltaks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Task ID - Primary Key';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
