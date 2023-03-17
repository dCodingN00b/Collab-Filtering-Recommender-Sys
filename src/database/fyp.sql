-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2023 at 05:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` smallint(6) NOT NULL,
  `userType` smallint(10) NOT NULL DEFAULT 1,
  `userName` varchar(80) DEFAULT NULL,
  `password` char(100) DEFAULT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `Organization Name` varchar(100) DEFAULT NULL,
  `Organization Website` varchar(100) DEFAULT NULL,
  `pricePlan` varchar(20) NOT NULL DEFAULT '0',
  `accountStatus` varchar(20) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userType`, `userName`, `password`, `emailAddress`, `Organization Name`, `Organization Website`, `pricePlan`, `accountStatus`) VALUES
(15, 1, 'org', '123', 'org@gmail.com', 'orgtest', 'org.com', '0', 'Available'),
(16, 0, 'admin', '123', 'admin@gmail.com', '', '', '0', 'Available'),
(17, 2, 'example', '123', 'example@gmail.com', '', '', '0', 'Available'),
(19, 2, 'mrs', '123', 'mrs@gmail.com', '', '', '0', 'Available'),
(20, 1, 'mrhungry', '123', 'hungry@hotmail.com', 'hungry pte ltd', 'hungryofhungry.com', '0', 'Available'),
(21, 1, 'mrunfair', '123', 'notfair@hotmail.com', 'fairness pte ltd', 'theworldisunfair.com', '0', 'Available'),
(22, 1, 'mrwhy', '123', 'why@gmail.com', 'whyiswhy', 'why.com', '0', 'Available'),
(23, 2, 'individuality', '123', 'individual@gmail.com', '', '', '0', 'Available'),
(27, 0, 'header', '123', 'head@gmail.com', '', '', '0', 'Available'),
(29, 1, 'orgoforg', '123', 'orgorg@gmail.com', 'orgorg', 'orgorg.com', '0', 'Available'),
(30, 1, 'org123', '123', 'org111@gmail.com', 'org123', 'org123.com', '0', 'Available'),
(31, 2, 'indhaha', '123', 'indhaha@gmail.com', '', '', '0', 'Available'),
(32, 1, 'indhahalol', '123', 'indhahalol@gmail.com', 'ttt', 'eee', '0', 'Available'),
(33, 1, 'hmm', '123', 'hmm@gmail.com', 'hmmmm', 'hmmmm.com', '0', 'Available'),
(34, 1, 'joking', '123', 'joke@gmail.com', 'joke', 'joke.com', '0', 'Available'),
(35, 2, 'indhaha', '123', 'indhah33a@gmail.com', '', '', '0', 'Available'),
(36, 0, '233', '123', '24@gmail.com', '', '', '0', 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
