-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 06:54 PM
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
  `name` varchar(80) DEFAULT NULL,
  `password` char(100) DEFAULT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `Organization Name` varchar(100) DEFAULT NULL,
  `Organization Website` varchar(100) DEFAULT NULL,
  `pricePlan` varchar(20) NOT NULL DEFAULT '0',
  `accountStatus` varchar(20) NOT NULL DEFAULT 'Available',
  `dateTimeOfCreation` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userType`, `name`, `password`, `emailAddress`, `Organization Name`, `Organization Website`, `pricePlan`, `accountStatus`, `dateTimeOfCreation`) VALUES
(21, 1, 'mrunfaire', '123', 'notfair@hotmail.com', 'fairness pte ltd', 'theworldisunfair.com', '0', 'Available', '2023-03-10 21:56:46.058438'),
(23, 2, 'individuality11', '1234', 'individual@gmail.com', '', '', '0', 'Available', '2023-03-19 21:56:46.058438'),
(29, 1, 'orgoforg', '123', 'orgorg@gmail.com', 'orgorg', 'orgorg.com', '0', 'Available', '2023-03-19 21:56:46.058438'),
(31, 2, 'indhaha', '123', 'indhaha1@gmail.com', '', '', '0', 'Available', '2023-03-19 21:56:46.058438'),
(32, 1, 'indhahalol', '123', 'indhahaloll@gmail.com', 'ttt', 'eee', '0', 'Available', '2023-03-19 21:56:46.058438'),
(33, 1, 'hmm', '123', 'hmm@gmail.com', 'hmmmm', 'hmmmm.com', '0', 'Available', '2023-03-19 21:56:46.058438'),
(34, 1, 'joking', '123', 'joke@gmail.com', 'joke', 'joke.com', '0', 'Available', '2023-03-19 21:56:46.058438'),
(35, 2, 'indhaha', '123', 'indhah33a@gmail.com', '', '', '0', 'Available', '2023-03-19 21:56:46.058438'),
(36, 0, '233', '123', '24@gmail.com', '', '', '0', 'Available', '2023-03-19 21:56:46.058438'),
(37, 2, 'hiamind', '123', 'hiiamind@gmail.com', '', '', '0', 'Available', '2023-03-19 21:58:08.521212'),
(38, 2, 'yesitsmeind', '123', 'ind11@gmail.com', '', '', '0', 'Available', '2023-03-20 16:04:47.658707'),
(39, 1, 'hiamorg', '123', 'org11@gmail.com', 'testorg11', 'test.com', '0', 'Available', '2023-03-20 16:05:13.872732'),
(40, 2, 'ind321', '123', 'ind321@gmail.com', '', '', '0', 'Available', '2023-03-20 16:07:16.687552'),
(41, 1, 'org321', '123', 'org321@gmail.com', 'org321 org', 'org321.com', '0', 'Available', '2023-03-20 16:07:46.616903'),
(42, 0, 'admin11', '123', 'admin11@gmail.com', '', '', '0', 'Available', '2023-03-20 16:08:04.322379'),
(43, 1, 'organization', '123', 'organization@gmail.com', 'organization limited', NULL, '0', 'Available', '2023-03-20 17:04:21.560187'),
(44, 2, 'individual11', '123', 'individual11@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:09:26.139642'),
(45, 2, 'individual111', '123', 'individual111@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:11:30.988251'),
(46, 0, 'admin123', '123', 'admin123@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:12:08.121501'),
(47, 0, 'admin132', '123', 'admin132@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:16:00.064714'),
(48, 2, '11', '123', 'individual1111@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:55:55.794621'),
(49, 2, '11', '123', 'individual11111@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:56:22.814876'),
(50, 2, '11', '123', 'individual111111@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:57:45.865457'),
(51, 2, '11', '123', 'individual1111111@gmail.com', '', NULL, '0', 'Available', '2023-03-20 17:59:19.409408'),
(52, 2, '11', '123', 'individual11111211@gmail.com', '', NULL, '0', 'Available', '2023-03-20 18:00:59.838740'),
(53, 1, '123', '123', 'og1234@gmail.com', '123', NULL, '0', 'Available', '2023-03-20 18:12:01.742858'),
(54, 1, '1', '123', 'og333@gmail.com', '1', NULL, '0', 'Available', '2023-03-20 18:12:43.340386'),
(55, 1, '11', '1', 'individual111112113@gmail.com', '1', NULL, '0', 'Available', '2023-03-20 18:12:58.760403'),
(56, 1, '1', '123', 'org12345@gmail.com', '1', NULL, '0', 'Available', '2023-03-20 18:26:03.517343'),
(57, 2, '1', '123', 'gg@gmail.com', '', NULL, '0', 'Available', '2023-03-20 18:29:37.681133'),
(58, 2, 'yesyes', NULL, 'yesyes@gmail.com', '', '', '0', 'Available', '2023-03-20 23:27:18.889440'),
(59, 2, 'yesyes', NULL, 'yesyes11@gmail.com', '', '', '0', 'Available', '2023-03-20 23:27:56.417670'),
(60, 1, 'yesyes', NULL, 'yesyes111@gmail.com', '1', '1', '0', 'Available', '2023-03-20 23:31:32.444080'),
(61, 1, '1', '123', 'org1122@gmail.com', '1', NULL, '0', 'Available', '2023-03-21 00:51:55.150096'),
(62, 2, 'yesyes22', '222', 'yesyes222@gmail.com', '', NULL, '0', 'Available', '2023-03-21 00:52:06.184961'),
(63, 2, 'yesyes222', '222', 'yesyes2222@gmail.com', '', NULL, '0', 'Available', '2023-03-21 00:52:49.142470'),
(64, 0, 'e', '123', 'whya@gmail.com', '', NULL, '0', 'Available', '2023-03-21 00:53:26.104108'),
(65, 0, '1', '1', '1234@hotmail.com', '', NULL, '0', 'Available', '2023-03-21 00:55:31.713251'),
(66, 0, 'admin132', '123', 'admin1323@gmail.com', '', '', '0', 'Available', '2023-03-21 00:56:19.042726'),
(67, 2, 'yesyes22', 'ee', 'yesyes22e2@gmail.com', '', '', '0', 'Available', '2023-03-21 00:56:25.597661'),
(68, 1, 'yesyes222', '3', 'yesyes22223@gmail.com', '3', '3', '0', 'Available', '2023-03-21 00:56:36.838543'),
(71, 1, '123', '123', 'org11111f@gmail.com', '123', '123', '0', 'Available', '2023-03-21 01:04:28.539344'),
(72, 2, '123', '123', 'org11111h@gmail.com', '', '', '0', 'Available', '2023-03-21 01:04:38.432410'),
(73, 0, 'admin', '123', 'admin@gmail.com', '', '', '0', 'Available', '2023-03-21 01:13:19.731215'),
(74, 2, 'ind', '123', 'ind@gmail.com', '', '', '0', 'Available', '2023-03-16 01:13:29.187531'),
(75, 1, 'org', '123', 'org@gmail.com', 'org pte ltd', 'org.com', '0', 'Available', '2023-03-11 01:13:48.579488');

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
  MODIFY `userID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
