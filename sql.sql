-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: tbsdbinstance.ctlrgvtx2zlb.ap-south-1.rds.amazonaws.com
-- Generation Time: Sep 01, 2018 at 06:18 AM
-- Server version: 5.7.17-log
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iitr`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `enrlid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `fn` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ln` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `ph` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `officeid` int(11) NOT NULL,
  `permission` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`enrlid`, `id`, `pwd`, `fn`, `ln`, `dob`, `ph`, `email`, `officeid`, `permission`) VALUES
('1', 'ADMIN', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Nikhil', 'Kumar', '1999-09-14', '8002572171', 'admin@nikhilkumar.cf', 1, 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`enrlid`),
  ADD UNIQUE KEY `enrlid_2` (`enrlid`),
  ADD KEY `enrlid` (`enrlid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
