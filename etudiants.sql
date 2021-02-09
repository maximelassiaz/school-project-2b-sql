-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2021 at 03:36 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utilisateurs`
--

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `etudiants_id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `sexe` tinyint(1) NOT NULL,
  `email` varchar(250) NOT NULL,
  `departement` varchar(250) NOT NULL,
  `date_naissance` datetime NOT NULL,
  `id_matieres` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`etudiants_id`, `nom`, `prenom`, `sexe`, `email`, `departement`, `date_naissance`, `id_matieres`) VALUES
(1, 'TOUSESTOK', 'Michael', 0, 'michael@moi.com', 'ISERE', '1975-11-11 13:55:47', 1),
(2, 'COOL', 'Sophie', 1, 'sophie@hotmail.fr', 'ARDECHE', '1984-06-16 13:55:47', 2),
(3, 'PALMER', 'Laura', 1, 'laura@laposte.net', 'CORSE SUD', '1974-01-15 13:55:47', 1),
(4, 'SUPERCOOL', 'Michelle ', 1, 'michelle@laposte.net', 'ISERE', '2001-07-10 13:55:47', 3),
(5, 'JAVADCRIPT', 'Laurent ', 0, 'laurent@google.it', 'GARD', '1981-03-24 13:55:47', 1),
(6, 'NODEJS', 'Laetitia ', 1, 'laetitia@gmail.com', 'LOIRE', '2004-06-28 13:55:47', 2),
(7, 'JAVA', 'Johnatan ', 0, 'johnatant@google.fr', 'LOIRE', '1965-01-14 13:55:47', 3),
(8, 'HTML', 'Anita ', 1, 'anita@laposte.net', 'MEUSE', '1988-05-18 13:55:47', 1),
(9, 'TAPIN', 'Jean ', 0, 'jean@google.fr', 'MEUSE', '1942-07-16 13:55:47', 2),
(10, 'CUBASE', 'Lucie ', 1, 'lucie@gmail.com', 'SAVOIE', '1989-10-17 13:55:47', 3),
(11, 'ADOBE', 'Bob ', 0, 'bob@google.com', 'SAVOIE', '1959-01-01 13:55:47', 1),
(12, 'VLC', 'Albin ', 0, 'albin@hotmail.com', 'VOSGES', '1999-07-02 13:55:47', 3),
(13, 'POWERISO', 'Clementine ', 1, 'clementine@google.it', 'AIN', '1986-11-10 13:55:47', 1),
(14, 'C#', 'Anthony', 1, 'anthony@google.com', 'CORSE', '2020-12-30 00:00:00', 2),
(15, 'ALACOOL', 'Jane', 1, 'jane@google.fr', 'LOIRE', '1971-05-18 13:55:47', 3),
(16, 'PYTHON', 'Marcel', 0, 'marcel@hotmail.fr', 'NORD', '1942-02-10 13:55:47', 1),
(17, 'PDO', 'Sabine', 1, 'sabine@google.uk', 'NORD', '1987-01-05 13:55:47', 2),
(18, 'UNITY', 'Léon', 0, 'leon@unity.com', 'NIEVRE', '1973-04-19 13:55:47', 3),
(19, 'RUBY', 'Leila', 1, 'leila@gmail.fr', 'NIEVRE', '1985-06-24 13:55:47', 1),
(20, 'RAILS', 'Moustapha', 0, 'moustapha@google.fr', 'NORD', '1962-12-01 13:55:47', 2),
(21, 'KOTLIN', 'Aicha', 1, 'aicha@laposte.net', 'VOSGES', '1944-05-22 13:55:47', 3),
(22, 'CSS', 'Lola', 1, 'lola@laposte.net', 'LOIRE', '1934-07-11 13:55:47', 1),
(23, 'TWIG', 'Emilie', 1, 'emilie@gmail.uk', 'SAVOIE', '1974-11-11 13:55:47', 2),
(24, 'NOSQL', 'Laura', 1, 'laura@cool.fr', 'ISERE', '2000-03-02 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`etudiants_id`),
  ADD KEY `id_matieres` (`id_matieres`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `etudiants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`id_matieres`) REFERENCES `matieres` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
