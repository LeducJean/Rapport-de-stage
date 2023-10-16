-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 juin 2023 à 12:09
-- Version du serveur : 10.5.19-MariaDB-0+deb11u2
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `campinglesportesdelabaiedesomme`
--

-- --------------------------------------------------------

--
-- Structure de la table `info_reservation`
--

CREATE TABLE `info_reservation` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `name2` varchar(50) NOT NULL,
  `mail2` varchar(75) NOT NULL,
  `phoneCountry2` varchar(4) NOT NULL,
  `phone2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateReservation` datetime NOT NULL,
  `typeEmplacement` varchar(14) NOT NULL,
  `nbrAdultes` int(11) NOT NULL,
  `nbrEnfantsM12` int(11) DEFAULT NULL,
  `nbrEnfantsP12` int(11) DEFAULT NULL,
  `electricite` varchar(3) NOT NULL,
  `vehicule` varchar(3) NOT NULL,
  `nbrAnimaux` varchar(3) NOT NULL,
  `dateEntree` date NOT NULL,
  `dateSortie` date NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `etat` varchar(6) DEFAULT NULL,
  `numeroEmplacement` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(75) NOT NULL,
  `phoneCountry` varchar(4) NOT NULL,
  `phone` int(11) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `lockout_time` datetime DEFAULT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `mail`, `phoneCountry`, `phone`, `login_attempts`, `lockout_time`, `isAdmin`) VALUES
(0, 'RéservationsAdmin', '', 'RéservationsAdmin', '', 0, 0, NULL, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `info_reservation`
--
ALTER TABLE `info_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `info_reservation`
--
ALTER TABLE `info_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `info_reservation`
--
ALTER TABLE `info_reservation`
  ADD CONSTRAINT `info_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
