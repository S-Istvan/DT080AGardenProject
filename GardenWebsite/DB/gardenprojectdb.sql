-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2017 at 06:22 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gardenprojectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `airdata`
--

CREATE TABLE `airdata` (
  `Counter` int(11) NOT NULL,
  `airTemp` int(11) NOT NULL,
  `airHumi` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airdata`
--

INSERT INTO `airdata` (`Counter`, `airTemp`, `airHumi`, `timestamp`, `date`) VALUES
(55, 18, 50, '2017-07-01 17:23:08', '2017-07-01'),
(56, 18, 50, '2017-07-01 17:24:55', '2017-07-01'),
(57, 12, 40, '2017-07-02 10:38:32', '2017-07-02'),
(58, 15, 40, '2017-07-02 10:38:36', '2017-07-02'),
(59, 16, 20, '2017-07-02 10:38:42', '2017-07-02'),
(60, 18, 40, '2017-07-02 10:38:49', '2017-07-02'),
(61, 30, 30, '2017-07-02 10:39:01', '2017-07-02'),
(62, 20, 90, '2017-07-02 10:39:09', '2017-07-02'),
(63, 50, 50, '2017-07-02 14:24:06', '2017-07-02'),
(64, 30, 70, '2017-07-02 14:24:20', '2017-07-02'),
(65, 30, 70, '2017-07-02 14:24:48', '2017-07-02'),
(66, 30, 70, '2017-07-02 14:24:50', '2017-07-02'),
(67, 30, 70, '2017-07-02 14:24:51', '2017-07-02'),
(68, 20, 70, '2017-07-02 14:24:56', '2017-07-02'),
(69, 25, 70, '2017-07-02 14:24:59', '2017-07-02'),
(70, 25, 70, '2017-07-02 14:25:17', '2017-07-02'),
(71, 25, 70, '2017-07-02 14:25:18', '2017-07-02'),
(72, 25, 70, '2017-07-02 14:25:20', '2017-07-02'),
(73, 25, 70, '2017-07-02 14:25:21', '2017-07-02'),
(74, 25, 70, '2017-07-02 14:25:24', '2017-07-02'),
(75, 25, 70, '2017-07-02 14:25:25', '2017-07-02'),
(76, 25, 70, '2017-07-02 14:25:47', '2017-07-02'),
(77, 25, 70, '2017-07-02 14:25:49', '2017-07-02'),
(78, 25, 70, '2017-07-02 14:25:50', '2017-07-02'),
(79, 25, 70, '2017-07-02 14:25:58', '2017-07-02'),
(80, 25, 70, '2017-07-02 14:26:00', '2017-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `lux`
--

CREATE TABLE `lux` (
  `Counter` int(11) NOT NULL,
  `lux` int(16) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lux`
--

INSERT INTO `lux` (`Counter`, `lux`, `timestamp`, `date`) VALUES
(1, 65000, '2017-07-02 10:39:36', '2017-07-02'),
(2, 60000, '2017-07-02 10:39:41', '2017-07-02'),
(3, 62000, '2017-07-02 10:39:50', '2017-07-02'),
(4, 6200, '2017-07-02 10:39:56', '2017-07-02'),
(5, 7900, '2017-07-02 10:40:06', '2017-07-02'),
(6, 12000, '2017-07-02 10:40:13', '2017-07-02'),
(7, 25000, '2017-07-02 10:40:19', '2017-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `soilhumi`
--

CREATE TABLE `soilhumi` (
  `Counter` int(11) NOT NULL,
  `soilHumi` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soilhumi`
--

INSERT INTO `soilhumi` (`Counter`, `soilHumi`, `timestamp`, `date`) VALUES
(1, 0, '2017-07-02 10:40:55', '2017-07-02'),
(2, 1023, '2017-07-02 10:41:26', '2017-07-02'),
(3, 750, '2017-07-02 10:41:35', '2017-07-02'),
(4, 650, '2017-07-02 10:41:39', '2017-07-02'),
(5, 550, '2017-07-02 10:41:42', '2017-07-02'),
(6, 450, '2017-07-02 10:41:47', '2017-07-02'),
(7, 350, '2017-07-02 10:41:51', '2017-07-02'),
(8, 250, '2017-07-02 10:41:55', '2017-07-02'),
(9, 150, '2017-07-02 10:42:01', '2017-07-02'),
(10, 100, '2017-07-02 10:42:08', '2017-07-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airdata`
--
ALTER TABLE `airdata`
  ADD PRIMARY KEY (`Counter`);

--
-- Indexes for table `lux`
--
ALTER TABLE `lux`
  ADD PRIMARY KEY (`Counter`);

--
-- Indexes for table `soilhumi`
--
ALTER TABLE `soilhumi`
  ADD PRIMARY KEY (`Counter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airdata`
--
ALTER TABLE `airdata`
  MODIFY `Counter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `lux`
--
ALTER TABLE `lux`
  MODIFY `Counter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `soilhumi`
--
ALTER TABLE `soilhumi`
  MODIFY `Counter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
