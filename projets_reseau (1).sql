-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 17 juin 2025 à 13:55
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projets_reseau`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projet_id` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `message` text,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projet_id` int DEFAULT NULL,
  `nom_fichier` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `upload_par` int DEFAULT NULL,
  `date_upload` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`),
  KEY `upload_par` (`upload_par`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projet_id` int DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `ip_acces` varchar(50) DEFAULT NULL,
  `protocole` varchar(20) DEFAULT NULL,
  `port` int DEFAULT '22',
  `emplacement` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `equipements`
--

INSERT INTO `equipements` (`id`, `projet_id`, `nom`, `type`, `ip_acces`, `protocole`, `port`, `emplacement`, `description`) VALUES
(1, 1, 'Switch Réseau RDC', 'Switch Cisco 2960', '192.168.10.10', 'SSH', 22, 'Salle Réseau - Rez-de-chaussée', 'Switch de distribution pour les postes utilisateurs'),
(3, 3, 'Switch Principal', 'Switch 2960', '192.168.10.2', 'SSH', 22, 'Data-center TC', ''),
(4, 4, 'ASA MTN', 'ASA 5505', '192.168.1.1', 'SSH', 22, 'Siège MTN', '');

-- --------------------------------------------------------

--
-- Structure de la table `interfaces`
--

DROP TABLE IF EXISTS `interfaces`;
CREATE TABLE IF NOT EXISTS `interfaces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipement_id` int DEFAULT NULL,
  `interfaces` varchar(255) DEFAULT NULL,
  `vlan` int DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `equipement_id` (`equipement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plages_adresses`
--

DROP TABLE IF EXISTS `plages_adresses`;
CREATE TABLE IF NOT EXISTS `plages_adresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projet_id` int DEFAULT NULL,
  `type_reseau` varchar(50) DEFAULT NULL,
  `plage_ip` varchar(50) DEFAULT NULL,
  `passerelle` varchar(50) DEFAULT NULL,
  `masque` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plages_adresses`
--

INSERT INTO `plages_adresses` (`id`, `projet_id`, `type_reseau`, `plage_ip`, `passerelle`, `masque`, `description`) VALUES
(1, 1, 'LAN', '192.168.1.0/26', '194.168.10.1', '255.255.255.192', 'pour aller vers le internet '),
(2, 1, 'LAN', '192.168.1.0/26', '192.168.1.1', '255.255.255.192', 'vers l\'interco'),
(3, 3, 'LAN', '192.168.10.0/24', '192.168.10.1', '255.255.255.0', '');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `chef_projet_id` int DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `statut` enum('en cours','terminé','en pause') DEFAULT 'en cours',
  `description` text,
  PRIMARY KEY (`id`),
  KEY `chef_projet_id` (`chef_projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `nom`, `client`, `chef_projet_id`, `date_debut`, `statut`, `description`) VALUES
(1, 'Projet Madapi', 'SI', 1, '2025-05-24', 'en cours', 'le projet regorge beaucoup de plage '),
(2, 'DHCP', 'Billings', 1, '2025-06-17', 'en cours', 'le projet consiste à rendre les adresses ip automatique  '),
(3, 'Déploiement LAN ', 'Alpha Industries', 1, '2025-06-01', 'en cours', 'Mise en place de l’infrastructure LAN du client, incluant le câblage, la configuration des switches, des VLANs et des accès utilisateurs.'),
(4, 'Mise en place VPN site-à-site', 'Partenaire X', 1, '2025-06-17', 'en cours', '');

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

DROP TABLE IF EXISTS `taches`;
CREATE TABLE IF NOT EXISTS `taches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projet_id` int DEFAULT NULL,
  `description` text,
  `assigne_a` int DEFAULT NULL,
  `statut` enum('à faire','en cours','terminée') DEFAULT 'à faire',
  `priorite` enum('basse','moyenne','haute') DEFAULT 'moyenne',
  `date_limite` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`),
  KEY `assigne_a` (`assigne_a`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('admin','technicien','chef_projet') DEFAULT 'technicien',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'Zouegna Othniel Blaise', 'Othniel.Mlan@MTN.com', 'Password@@@2025', 'technicien');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
