-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 30 avr. 2025 à 15:21
-- Version du serveur : 8.4.3
-- Version de PHP : 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `catalogue_livres`
--  Requêtes utilisées pour l'exercice :

-- Tous les livres :
-- SELECT * FROM library;

-- Livres publiés après 2000, triés par titre :
-- SELECT * FROM library
-- WHERE YEAR(Date_de_publication) > 2000
-- ORDER BY titre ;

-- Livres disponibles :
-- SELECT * FROM library
-- WHERE Disponible = 1;

-- Livres triés par titre:
-- SELECT * FROM library
-- ORDER BY titre ;
--

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
  `id` int NOT NULL,
  `titre` varchar(100) NOT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `Date_de_publication` date DEFAULT NULL,
  `Disponible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`id`, `titre`, `auteur`, `Date_de_publication`, `Disponible`) VALUES
(1, 'Le Petit Prince', 'Antoine de Saint Exupery', '1943-04-06', 1),
(2, 'Les Miserables', 'Victor Hugo', '1862-04-03', 0),
(3, 'Letranger', 'Albert Camus', '1942-05-19', 1),
(4, 'Ce que le jour doit a la nuit', 'Yasmina Khadra', '2008-08-27', 1),
(5, 'Da Vinci Code', 'Dan Brown', '2003-03-18', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auteur` (`auteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
