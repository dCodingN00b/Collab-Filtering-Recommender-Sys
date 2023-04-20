-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 08:49 AM
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
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_id` int(2) NOT NULL,
  `code` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`otp_id`, `code`) VALUES
(71, 252865),
(72, 344926),
(73, 353028),
(74, 178681),
(76, 187132),
(81, 918272),
(93, 300484),
(94, 349290);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(20) NOT NULL,
  `userID` smallint(6) NOT NULL,
  `pricePlan` varchar(2) NOT NULL,
  `amountPaid` varchar(20) NOT NULL,
  `startDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `expiryDate` timestamp NOT NULL DEFAULT (current_timestamp() + interval 30 day),
  ` isExpired` varchar(20) GENERATED ALWAYS AS (case when `expiryDate` < current_timestamp() then 'Expired' else 'Active' end) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `userID`, `pricePlan`, `amountPaid`, `startDate`, `expiryDate`) VALUES
(50, 114, 'i1', '$9.90', '2023-04-12 21:43:30.315381', '2023-05-12 13:43:30'),
(51, 115, 'o2', '$49.90', '2023-04-12 21:52:25.267606', '2023-05-12 13:52:25'),
(52, 116, 'o2', '$49.90', '2023-04-12 22:03:35.136658', '2023-05-12 14:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` smallint(6) NOT NULL,
  `userType` smallint(10) NOT NULL DEFAULT 1,
  `name` varchar(80) DEFAULT NULL,
  `password` char(100) DEFAULT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `Organization Name` varchar(100) DEFAULT NULL,
  `Organization Website` varchar(100) DEFAULT NULL,
  `categoryOne` varchar(20) NOT NULL,
  `pricePlan` varchar(20) NOT NULL DEFAULT '0',
  `startDate` datetime(6) DEFAULT NULL,
  `expiryDate` datetime(6) DEFAULT NULL,
  `accountStatus` varchar(20) NOT NULL DEFAULT 'Available',
  `dateTimeOfCreation` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `freeTrialExpiryDate` timestamp NOT NULL DEFAULT (current_timestamp() + interval 30 day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userType`, `name`, `password`, `emailAddress`, `Organization Name`, `Organization Website`, `categoryOne`, `pricePlan`, `startDate`, `expiryDate`, `accountStatus`, `dateTimeOfCreation`, `freeTrialExpiryDate`) VALUES
(33, 0, 'admin', '123', 'admin@gmail.com', NULL, NULL, '', 'None', NULL, NULL, 'Available', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00'),
(114, 2, 'mr ind', '123', 'ind@gmail.com', '', '', 'Electronics', 'i1', '2023-04-12 21:43:30.315381', '2023-05-12 21:43:30.000000', 'Available', '2023-04-12 21:39:58.746739', '2023-05-12 13:39:58'),
(115, 1, '123', '123', 'org@gmail.com', '123', '123', 'Computers', 'o2', '2023-04-12 21:52:25.267606', '2023-05-12 21:52:25.000000', 'Available', '2023-04-12 21:41:00.507863', '2023-05-12 13:41:00'),
(116, 1, '123', '333', 'o4@gmail.com', '123', '123', 'Electronics', 'o2', '2023-04-12 22:03:35.136658', '2023-05-12 22:03:35.000000', 'Available', '2023-04-12 21:41:33.324450', '2023-05-12 13:41:33'),
(117, 1, '123', '123', 'o5@gmail.com', '123', '123', 'Video Games', 'None', NULL, NULL, 'Available', '2023-03-12 21:42:08.849124', '2023-04-11 13:42:08'),
(118, 2, '123', '123', 'meethedese@gmail.com', '', '', 'Electronics', '0', NULL, NULL, 'Available', '2023-04-18 13:50:45.893245', '2023-05-18 05:50:45'),
(119, 2, '2', '2', 'kakashihatake3419@gmail.com', '', '', 'Computers', '0', NULL, NULL, 'Available', '2023-04-19 12:59:44.211900', '2023-05-19 04:59:44'),
(120, 1, '123', '123', 'travisthamjiaxuan@gmail.com', '123', '123', 'Video Games', '0', NULL, NULL, 'Available', '2023-04-19 13:00:22.142030', '2023-05-19 05:00:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `transactions_ibfk_1` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
