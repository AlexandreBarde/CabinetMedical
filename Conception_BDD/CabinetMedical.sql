-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 15 jan. 2018 à 17:06
-- Version du serveur :  10.1.28-MariaDB
-- Version de PHP :  7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `CabinetMedical`
--

-- --------------------------------------------------------

--
-- Structure de la table `Consultation`
--

CREATE TABLE `Consultation` (
  `id_medecin` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Consultation`
--

INSERT INTO `Consultation` (`id_medecin`, `id_patient`, `date_debut`, `date_fin`) VALUES
(11, 9, '2018-02-28 13:00:00', '2018-02-28 13:15:00'),
(12, 10, '2018-02-07 15:00:00', '2018-02-07 15:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `Medecin`
--

CREATE TABLE `Medecin` (
  `id_medecin` int(11) NOT NULL,
  `civilite` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Medecin`
--

INSERT INTO `Medecin` (`id_medecin`, `civilite`, `nom`, `prenom`) VALUES
(11, 'Monsieur', 'Diafoirus', 'Augustin'),
(12, 'Monsieur', 'Cressac', 'Thomas'),
(13, 'Madame', 'Beaulac', 'Eloise');

-- --------------------------------------------------------

--
-- Structure de la table `Patient`
--

CREATE TABLE `Patient` (
  `id_patient` int(11) NOT NULL,
  `id_medecin` int(11) DEFAULT NULL,
  `civilite` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL,
  `num_secu` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Patient`
--

INSERT INTO `Patient` (`id_patient`, `id_medecin`, `civilite`, `nom`, `prenom`, `adresse`, `date_naissance`, `num_secu`) VALUES
(8, 13, 'Monsieur', 'Benoit', 'Félicien', '4 rue roussy 93130 noisy-le-sec', '1982-01-14', '182024604691491'),
(9, 12, 'Monsieur', 'Covillon', 'Donatien', '28 rue frédéric chopin', '1973-11-09', '173013228693278'),
(10, 11, 'Madame', 'Baril', 'Angelette', '8 avenue du marechal juin', '1997-09-10', '234029474516087'),
(11, NULL, 'Madame', 'Goudreau', 'Christine', '80 rue léon dierx 87280 limoges', '1980-12-23', '281064690485878'),
(12, NULL, 'Madame', 'Chartier', 'Anastasie', '58, rue pierre de coubertin 31000 toulouse', '1943-02-01', '243029325373881');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`login`, `password`) VALUES
('Utilisateur', '81fe8bfe87576c3ecb22426f8e57847382917acf');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`id_medecin`,`id_patient`,`date_debut`),
  ADD KEY `Consultation_ibfk_2` (`id_patient`);

--
-- Index pour la table `Medecin`
--
ALTER TABLE `Medecin`
  ADD PRIMARY KEY (`id_medecin`);

--
-- Index pour la table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `Patient_ibfk_1` (`id_medecin`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Medecin`
--
ALTER TABLE `Medecin`
  MODIFY `id_medecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `Consultation_ibfk_1` FOREIGN KEY (`id_medecin`) REFERENCES `Medecin` (`id_medecin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Consultation_ibfk_2` FOREIGN KEY (`id_patient`) REFERENCES `Patient` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `Patient_ibfk_1` FOREIGN KEY (`id_medecin`) REFERENCES `Medecin` (`id_medecin`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
