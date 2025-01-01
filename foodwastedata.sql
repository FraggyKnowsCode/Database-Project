-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 03:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_waste_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `foodwastedata`
--

CREATE TABLE `foodwastedata` (
  `waste_id` int(11) NOT NULL,
  `food_category` enum('vegetables','fruits','cooked','dairy','dry','others') DEFAULT NULL,
  `amount_wasted` float NOT NULL,
  `cause_of_waste` text NOT NULL,
  `location` text NOT NULL,
  `disposal_method` enum('landfill','compost','donation') NOT NULL,
  `date_of_waste` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `Id` int(11) NOT NULL,
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foodwastedata`
--
ALTER TABLE `foodwastedata`
  ADD PRIMARY KEY (`waste_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foodwastedata`
--
ALTER TABLE `foodwastedata`
  MODIFY `waste_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foodwastedata`
--
ALTER TABLE `foodwastedata`
  ADD CONSTRAINT `foodwastedata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
