-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 04, 2018 alle 12:26
-- Versione del server: 10.1.26-MariaDB-0+deb9u1
-- Versione PHP: 7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Laravel_Data`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `dashboards`
--

CREATE TABLE `dashboards` (
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `dashboard_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `DataTriggers`
--

CREATE TABLE `DataTriggers` (
  `Device_ID` varchar(22) CHARACTER SET utf8 NOT NULL,
  `Data_Path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `devices`
--

CREATE TABLE `devices` (
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `DeviceName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Device_ID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `devices`
--
ALTER TABLE `devices`
  ADD KEY `email` (`email`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `dashboards` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
