-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2017 at 02:42 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app-dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `_xyz_users`
--

CREATE TABLE `_xyz_users` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'user_id',
  `username` varchar(25) DEFAULT NULL COMMENT 'username',
  `email` varchar(254) DEFAULT NULL COMMENT 'email',
  `country_code` char(2) DEFAULT NULL COMMENT 'country_code'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_xyz_users`
--

INSERT INTO `_xyz_users` (`id`, `username`, `email`, `country_code`) VALUES
(1, NULL, NULL, NULL),
(2, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `_xyz_users`
--
ALTER TABLE `_xyz_users`
  ADD PRIMARY KEY (`id`) COMMENT 'user_id',
  ADD UNIQUE KEY `username` (`username`) COMMENT 'username',
  ADD UNIQUE KEY `email` (`email`) COMMENT 'email';

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `_xyz_users`
--
ALTER TABLE `_xyz_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'user_id', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
