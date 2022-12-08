-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 07 déc. 2022 à 22:47
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionbancaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` char(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id`, `mail`) VALUES
('117625807335326589890', 'shotgreen.c@gmail.com'),
('113969151864074644861', 'clementprevost45@gmail.com'),
('0', '');

-- --------------------------------------------------------

--
-- Structure de la table `account_banks`
--

DROP TABLE IF EXISTS `account_banks`;
CREATE TABLE IF NOT EXISTS `account_banks` (
  `compte_number` bigint(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_account` text NOT NULL,
  PRIMARY KEY (`compte_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `account_banks`
--

INSERT INTO `account_banks` (`compte_number`, `name`, `id_account`) VALUES
(83475897835475, 'Clément Prévost', '113969151864074644861');

-- --------------------------------------------------------

--
-- Structure de la table `base_change`
--

DROP TABLE IF EXISTS `base_change`;
CREATE TABLE IF NOT EXISTS `base_change` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_livret` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `intitule` text NOT NULL,
  `type_change` enum('gain','depense') NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `base_change`
--

INSERT INTO `base_change` (`name`, `id`, `id_livret`, `id_categorie`, `montant`, `intitule`, `type_change`, `date`) VALUES
('Virment noël Parent', 13, 12, 13, 180, 'Virment noël Parent', 'gain', '2022-12-24'),
('Dêpot chèque', 9, 10, 8, 500, 'Dépot de mes cheques anniv', 'gain', '2022-12-16'),
('Pantalon', 14, 12, 13, 43, 'Pantalon', 'depense', '2022-12-09'),
('Ecouteur', 15, 12, 13, 79, 'Ecouteur', 'depense', '2022-12-21'),
('Remboursement du train', 16, 12, 19, 29, 'Remboursement du train', 'gain', '2022-12-20'),
('AjoutEpargne', 17, 13, 13, 500, 'AjoutEpargne', 'gain', '2022-12-07');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account_banks_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `account_banks_id`) VALUES
(13, 'Loisirs', 83475897835475),
(14, 'Entretien maison', 83475897835475),
(15, 'Energie', 83475897835475),
(16, 'Nourriture', 83475897835475),
(17, 'Soins', 83475897835475),
(18, 'Loyer', 83475897835475),
(19, 'Transport', 83475897835475);

-- --------------------------------------------------------

--
-- Structure de la table `livret`
--

DROP TABLE IF EXISTS `livret`;
CREATE TABLE IF NOT EXISTS `livret` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account_banks_id` bigint(20) NOT NULL,
  `solde_base` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livret`
--

INSERT INTO `livret` (`id`, `name`, `account_banks_id`, `solde_base`) VALUES
(12, 'Livret A Sup', 83475897835475, 0),
(13, 'Livret Jeune', 83475897835475, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mensualites`
--

DROP TABLE IF EXISTS `mensualites`;
CREATE TABLE IF NOT EXISTS `mensualites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_livret` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `montant` int(11) DEFAULT '0',
  `intitule` text NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `type_change` enum('gain','depense') DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mensualites`
--

INSERT INTO `mensualites` (`id`, `name`, `id_livret`, `id_categorie`, `montant`, `intitule`, `actif`, `date`, `type_change`, `start_date`) VALUES
(7, 'Loyer', 12, 18, 450, 'LocationLoyer', 1, '2022-12-05', 'depense', '2022-12-07 18:22:59'),
(8, 'CAF', 12, 18, 91, 'CAF', 1, '2022-12-05', 'gain', '2022-12-07 18:22:59'),
(9, 'Alternance', 12, 13, 620, 'Salaire alternance', 1, '2022-12-06', 'gain', '2022-12-07 18:22:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
