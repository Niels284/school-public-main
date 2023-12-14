-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 14 dec 2023 om 19:47
-- Serverversie: 5.7.39
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbo-autorisatie`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(100) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `rechten_niveau` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `wachtwoord`, `rechten_niveau`) VALUES
(1, 'admin', '$2y$10$TWR9HIRb3edpqtfA5UOqSOxEKB4SC1jrb2x9Ysmy.KSx2/TjaSG/G', 4),
(2, 'admin123', '$2y$10$NZzvYhPCfxb.MSsQOQoeEOjaxR/HQF7Kwg.klI3pzP6VpbbMRBKnC', 4),
(7, 'admin1', '$2y$10$b3q9fqtQ9fs.Ws1NR9/YcuhUJFrbNUbF2hrhGJohMlunPPLAEbvYy', 1),
(8, 'admin2', '$2y$10$Mu3ThTya208O2JGgxJ.PA.4157ILIFh7u0c3wQFJRG.Tso/m.rcGm', 2),
(9, 'admin3', '$2y$10$477neyVjUFdHTlMMv0kFkefCJCoEIjxSUiEZx4uLWU6Sub2aUjw7C', 3),
(10, 'admin4', '$2y$10$KdR637uFLrHqqpBOPSmWlOucUpHlCr6GATnlFyhcLnMMnFP3YEAve', 4),
(11, 'admin0', '$2y$10$BBZN/ecAuGKOibBDZ.sD.OiFkxJzcvz.sG4IqhrpggLDVwVVUbQiu', 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
