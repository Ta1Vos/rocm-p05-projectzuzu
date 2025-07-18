-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 12 okt 2023 om 10:30
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zuzu`
--
CREATE DATABASE IF NOT EXISTS `zuzu` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zuzu`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(75) NOT NULL,
  `postal_code` varchar(6) NOT NULL,
  `residence` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer_receipt`
--

DROP TABLE IF EXISTS `customer_receipt`;
CREATE TABLE `customer_receipt` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sushi_id` int(11) NOT NULL,
  `receipt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sushi`
--

DROP TABLE IF EXISTS `sushi`;
CREATE TABLE `sushi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ingredients` longtext DEFAULT NULL,
  `available_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `sushi`
--

INSERT INTO `sushi` (`id`, `name`, `price`, `image`, `ingredients`, `available_amount`) VALUES
(1, 'Maki cucumber/salmon', '4.99', 'img/makis/maki_cucumber_salmon.jpg', 'Zeewier, rijst, komkommer, zalm', 50),
(2, 'Maki Omelet', '3.99', 'img/makis/maki_omelet.jpg', 'Zeewier, rijst, Japans Omelet', 50),
(3, 'Salmon Ebi Roll', '7.99', 'img/rolls/salmon_ebi_roll.jpg', 'Geflambeerde zalm, cheddar kaas, komkommer, gefrituurde garnaal, surimi, Japanse mayonaise', 50),
(4, 'Salmon Surimi Roll', '6.99', 'img/rolls/salmon_surimi_roll.jpg', 'Geflambeerde zalm, surimi, avocado, masago, komkommer, unagisaus, Japanse mayonaise', 50),
(5, 'Nigiri Tuna Melt', '5.99', 'img/nigiris/nigiri_tuna_melt.jpg', 'Rijst bed, tonijn, oude gesmolten kaas', 50),
(6, 'Nigiri Salmon', '4.99', 'img/nigiris/nigiri_salmon.jpg', 'Rijst bed, zalm', 50),
(7, 'Nigiri Salmon Cheese', '5.99', 'img/nigiris/nigiri_salmon_cheese.jpg', 'Rijst bed, zalm, oude gesmolten kaas', 50);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `customer_receipt`
--
ALTER TABLE `customer_receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_receipt_customer_fk` (`customer_id`),
  ADD KEY `sushi_id` (`sushi_id`);

--
-- Indexen voor tabel `sushi`
--
ALTER TABLE `sushi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `customer_receipt`
--
ALTER TABLE `customer_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `sushi`
--
ALTER TABLE `sushi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `customer_receipt`
--
ALTER TABLE `customer_receipt`
  ADD CONSTRAINT `customer_receipt_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `customer_receipt_ibfk_1` FOREIGN KEY (`sushi_id`) REFERENCES `sushi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
