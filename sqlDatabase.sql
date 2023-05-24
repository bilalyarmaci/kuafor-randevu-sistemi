-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2023 at 06:04 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Yeni bir veritabanı oluşturma
CREATE DATABASE kuafor_vt;

-- Oluşturulan veritabanını seçme
USE kuafor_vt;

--
-- Table structure for table `musteriler`
--

CREATE TABLE `musteriler` (
  `musteriID` bigint(20) UNSIGNED NOT NULL,
  `ad_soyad` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `sifre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `musteriler`
--

INSERT INTO `musteriler` (`musteriID`, `ad_soyad`, `email`, `sifre`) VALUES
(1, 'Dener Denemez', 'denerim@denemezim.com', 'rastgelesifre123'),
(2, 'Selcan Dönmez', 'feak@b.c', '$2y$10$KdBj7ZR5XTBHYCAyJg7s5eds7U9xXQr0RXDmsuUd/l1DSCZASuNxi'),
(5, 'maykil jackson', 'maykil@jackson.co', '$2y$10$Cp0kUww.HytlhG3fh/zk3e75b3XoVg7umfuOjDzjPgRUEulMI5ANi'),
(6, 'Ben Deniz ', 'ben@deniz.com', '$2y$10$bg5b5DAvahzepJvbSdr6HeSL0WJUSIkEDE.YKSRjZ3qerCwnu1VIy'),
(7, 'safdsa gvfsxc', 'sad@mad.kad', '$2y$10$yTyzZRp61J/VVcSfb4xKI.oRmdlKYhJ/j5BZd3Zi0MES05Km6T6GC');

-- --------------------------------------------------------

--
-- Table structure for table `randevular`
--

CREATE TABLE `randevular` (
  `randevuID` bigint(20) NOT NULL,
  `musteriID` bigint(20) UNSIGNED DEFAULT NULL,
  `tarih` varchar(12) NOT NULL,
  `saat` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `randevular`
--

INSERT INTO `randevular` (`randevuID`, `musteriID`, `tarih`, `saat`) VALUES
(25, 7, '2023-05-21', '17:00'),
(27, 2, '2023-05-20', '16:00');

-- --------------------------------------------------------

--
-- Table structure for table `yoneticiler`
--

CREATE TABLE `yoneticiler` (
  `yoneticiID` bigint(20) NOT NULL,
  `ad_soyad` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `sifre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yoneticiler`
--

INSERT INTO `yoneticiler` (`yoneticiID`, `ad_soyad`, `email`, `sifre`) VALUES
(1, 'admin', 'admin@kuafor.com', '$2y$10$PKZ5rb9AQFUHx1SVzgSDsuJ6KlEjVV0WRIFHwfYc7dgJhOXHI56G6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `musteriler`
--
ALTER TABLE `musteriler`
  ADD PRIMARY KEY (`musteriID`),
  ADD UNIQUE KEY `mail` (`email`);

--
-- Indexes for table `randevular`
--
ALTER TABLE `randevular`
  ADD PRIMARY KEY (`randevuID`),
  ADD KEY `musteriID` (`musteriID`);

--
-- Indexes for table `yoneticiler`
--
ALTER TABLE `yoneticiler`
  ADD PRIMARY KEY (`yoneticiID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `musteriler`
--
ALTER TABLE `musteriler`
  MODIFY `musteriID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `randevular`
--
ALTER TABLE `randevular`
  MODIFY `randevuID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `yoneticiler`
--
ALTER TABLE `yoneticiler`
  MODIFY `yoneticiID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `randevular`
--
ALTER TABLE `randevular`
  ADD CONSTRAINT `randevular_ibfk_1` FOREIGN KEY (`musteriID`) REFERENCES `musteriler` (`musteriID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
