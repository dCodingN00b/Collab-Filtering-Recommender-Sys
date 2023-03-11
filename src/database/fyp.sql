-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2023 at 07:05 AM
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
  `Email Address` varchar(100) NOT NULL,
  `Organization Name` varchar(100) DEFAULT NULL,
  `Organization Website` varchar(100) DEFAULT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userType`, `userName`, `password`, `Email Address`, `Organization Name`, `Organization Website`, `Name`) VALUES
(5, 0, 'Tom', 'Pass123', '', NULL, NULL, ''),
(6, 0, 'Tan', 'Pass123', 'tan@gmail.com', NULL, NULL, ''),
(7, 0, 'Sam', 'Pass123', '', NULL, NULL, ''),
(8, 0, 'Lee', 'Pass123', '', NULL, NULL, ''),
(12, 1, 'itsyaboi', '12345', 'test@gmail.com', 'testorg', 'test.com', 'tester'),
(15, 2, 'alpha', '123', 'thomas@gmail.com', '', '', 'tester'),
(16, 1, 'org', '123', 'co2ld@hotmail.com', 'testorg', 'test.com', 'firefighter'),
(17, 2, 'ind', '123', 'tt@hotmail.com', '', '', 'cc');

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
  MODIFY `userID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
