 n SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 05, 2018 alle 15:20
-- Versione del server: 10.1.26-MariaDB-0+deb9u1
-- Versione PHP: 7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `dashboards` (
	  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `dashboard_id` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `token` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `DataTriggers` (
	  `Device_ID` varchar(22) CHARACTER SET utf8 NOT NULL,
	  `Data_Path` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `status` varchar(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `devices` (
	  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `DeviceName` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `Device_ID` varchar(255) CHARACTER SET utf8 NOT NULL,
	  `status` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
	  `id` int(11) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
