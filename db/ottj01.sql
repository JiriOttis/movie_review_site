-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 08. čen 2022, 16:47
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `ottj01`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `film`
--

CREATE TABLE `film` (
  `film_id` int(11) UNSIGNED NOT NULL,
  `nazev` varchar(255) DEFAULT NULL,
  `rok_vydani` year(4) DEFAULT NULL,
  `stopaz` int(10) DEFAULT NULL,
  `zeme_vyroby` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `film`
--

INSERT INTO `film` (`film_id`, `nazev`, `rok_vydani`, `stopaz`, `zeme_vyroby`, `img`) VALUES
(1, 'Doctor Strange v mnohovesmíru šílenství', 2022, 127, 'USA', 'assets/img/posters/DS_MoM.jpg'),
(2, 'Pulp Fiction: Historky z podsvětí', 1994, 154, 'USA', 'assets/img/posters/Pulp_Fiction.jpg'),
(4, 'Forrest Gump', 1994, 142, 'USA', 'assets/img/posters/forest_gump.jpg'),
(5, 'Počátek', 2010, 148, 'USA / Velká Británie', 'assets/img/posters/pocatek.jpg'),
(6, 'Kód Enigmy', 2014, 109, 'Velká Británie / USA', 'assets/img/posters/kod_enigmy.jpg'),
(9, 'Babovřesky', 2013, 133, 'Česko', 'assets/img/posters/babovresky.jpg'),
(10, 'Co jsme komu udělali?', 2014, 97, 'Francie', 'assets/img/posters/co_jsme_komu_udelali.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `film_zanr`
--

CREATE TABLE `film_zanr` (
  `film_zanr_id` int(10) UNSIGNED NOT NULL,
  `film_id` int(11) UNSIGNED NOT NULL,
  `zanr_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `film_zanr`
--

INSERT INTO `film_zanr` (`film_zanr_id`, `film_id`, `zanr_id`) VALUES
(1, 1, 6),
(2, 1, 3),
(3, 1, 1),
(4, 2, 2),
(6, 4, 2),
(7, 4, 4),
(8, 4, 8),
(9, 5, 1),
(10, 5, 5),
(11, 5, 7),
(12, 6, 2),
(13, 6, 7),
(15, 9, 4),
(16, 10, 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `recenze`
--

CREATE TABLE `recenze` (
  `recenze_id` int(10) UNSIGNED NOT NULL,
  `datum_pridani` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `text` text DEFAULT NULL,
  `hodnoceni` smallint(2) NOT NULL,
  `film_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `recenze`
--

INSERT INTO `recenze` (`recenze_id`, `datum_pridani`, `text`, `hodnoceni`, `film_id`, `user_id`) VALUES
(3, '2022-06-01 13:30:35', 'Miluju ten film', 4, 1, 3),
(4, '2022-06-01 13:42:59', '', 5, 4, 3),
(8, '2022-06-08 13:46:26', 'Odpad :)', 1, 9, 5),
(9, '2022-06-08 13:46:55', 'Bomba film :)', 4, 6, 5),
(10, '2022-06-08 13:47:05', '', 5, 5, 5),
(11, '2022-06-08 13:47:19', 'Miluju Foresta', 5, 4, 5),
(12, '2022-06-08 13:50:16', 'Tohle je fakt dobrý! <3 <3', 4, 4, 6),
(13, '2022-06-08 13:48:22', '', 2, 9, 6),
(14, '2022-06-08 13:48:28', 'Ujde', 3, 2, 6),
(15, '2022-06-08 13:48:52', 'Stojí za to vidět', 4, 1, 6),
(16, '2022-06-08 13:49:06', 'Top komedie', 5, 10, 6),
(17, '2022-06-08 14:41:21', '', 0, 6, 6),
(19, '2022-06-08 14:42:30', 'Prostě inception', 4, 5, 6);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `uz_jmeno` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `heslo` varchar(255) NOT NULL DEFAULT '',
  `vid_jmeno` varchar(255) NOT NULL,
  `role` set('uzivatel','admin') NOT NULL DEFAULT 'uzivatel',
  `google_id` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`user_id`, `uz_jmeno`, `email`, `heslo`, `vid_jmeno`, `role`, `google_id`) VALUES
(3, 'test', 'test@test.cz', '$2y$10$FvxnelVZ9DD38QlThg.H9.D/PZoT5S1s4PqvaPirOv1bbngR5T//e', 'Jan Novák', 'uzivatel', 0),
(5, 'jiriottis', 'jiriottis13@gmail.com', '', 'Jiří Ottis', 'uzivatel', 2147483647),
(6, 'novotna_jana', 'novotnajana@seznam.cz', '$2y$10$8st8dHa9qWOGb049Kc4REea.8KXX46gK6ToyuWPsqs6QpNxUierFS', 'Jana Novotná', 'uzivatel', 0),
(10, 'admin', 'admin@admin.cz', '$2y$10$MvPvTUb0O6dmCKmBfwONKemVpCY/5lNqakdJ.dkj4nN1yTnhCduNe', 'admin', 'admin', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `zanr`
--

CREATE TABLE `zanr` (
  `zanr_id` int(11) UNSIGNED NOT NULL,
  `nazev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `zanr`
--

INSERT INTO `zanr` (`zanr_id`, `nazev`) VALUES
(1, 'Akční'),
(2, 'Drama'),
(3, 'Fantasy'),
(4, 'Komedie'),
(5, 'Sci-fi'),
(6, 'Horor'),
(7, 'Thriller'),
(8, 'Romantický');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`film_id`);

--
-- Indexy pro tabulku `film_zanr`
--
ALTER TABLE `film_zanr`
  ADD PRIMARY KEY (`film_zanr_id`),
  ADD KEY `zanr_id` (`zanr_id`),
  ADD KEY `film_zanr_ibfk_1` (`film_id`);

--
-- Indexy pro tabulku `recenze`
--
ALTER TABLE `recenze`
  ADD PRIMARY KEY (`recenze_id`),
  ADD KEY `recenze_ibfk_1` (`film_id`),
  ADD KEY `recenze_ibfk_2` (`user_id`);

--
-- Indexy pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uz_jmeno` (`uz_jmeno`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexy pro tabulku `zanr`
--
ALTER TABLE `zanr`
  ADD PRIMARY KEY (`zanr_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `film`
--
ALTER TABLE `film`
  MODIFY `film_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `film_zanr`
--
ALTER TABLE `film_zanr`
  MODIFY `film_zanr_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pro tabulku `recenze`
--
ALTER TABLE `recenze`
  MODIFY `recenze_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `zanr`
--
ALTER TABLE `zanr`
  MODIFY `zanr_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `film_zanr`
--
ALTER TABLE `film_zanr`
  ADD CONSTRAINT `film_zanr_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `film` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `film_zanr_ibfk_2` FOREIGN KEY (`zanr_id`) REFERENCES `zanr` (`zanr_id`);

--
-- Omezení pro tabulku `recenze`
--
ALTER TABLE `recenze`
  ADD CONSTRAINT `recenze_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `film` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recenze_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `uzivatel` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
