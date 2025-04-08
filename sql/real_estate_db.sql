-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 05:20 PM
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
-- Database: `real_estate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `contactInfo` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `name`, `username`, `contactInfo`, `password`) VALUES
(1, 'Admin User', 'admin', 'admin@example.com', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `AgentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`AgentID`, `Name`, `ContactInfo`, `username`, `password`) VALUES
(16, 'agentName', '123', 'agent1', '202cb962ac59075b964b07152d234b70'),
(17, 'agentName', '123', 'agent2', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `Name`, `ContactInfo`, `username`, `password`) VALUES
(7, 'clientName', '123', 'client1', '202cb962ac59075b964b07152d234b70'),
(8, 'clientName', '123', 'client2', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE `listing` (
  `ListingID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `ListingDate` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing`
--

INSERT INTO `listing` (`ListingID`, `PropertyID`, `AgentID`, `ListingDate`) VALUES
(19, 41, 16, '2025-04-08'),
(20, 42, 16, '2025-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `OwnerID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`OwnerID`, `Name`, `username`, `ContactInfo`, `password`) VALUES
(2, 'ownerName', 'owner1', '123', '202cb962ac59075b964b07152d234b70'),
(3, 'ownerName', 'owner2', '123', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `PropertyID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Status` enum('For Sale','For Rent') DEFAULT 'For Sale',
  `ImageURL` varchar(255) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`PropertyID`, `AgentID`, `Address`, `Type`, `Size`, `Price`, `Status`, `ImageURL`, `OwnerID`) VALUES
(41, 16, 'address1', 'Villa', 120, 150000.00, '', 'uploads/67f5375218ea2_vila1.jpg', NULL),
(42, 16, 'address2', 'Villa', 120, 140000.00, '', 'uploads/67f53771bb826_vila2.jpg', NULL),
(43, 0, 'address3', 'Apartment', 125, 160000.00, 'For Sale', 'uploads/67f5394f0ccbd_house3.jpg', 2),
(44, 0, 'address4', 'House', 120, 170000.00, 'For Sale', 'uploads/67f53969e31fd_house4.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rentaldetails`
--

CREATE TABLE `rentaldetails` (
  `TransactionID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentaldetails`
--

INSERT INTO `rentaldetails` (`TransactionID`, `StartDate`, `EndDate`) VALUES
(10, '2025-04-03', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `TransactionDate` date DEFAULT curdate(),
  `Type` enum('Sale','Rent') NOT NULL,
  `FinalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactionID`, `PropertyID`, `ClientID`, `AgentID`, `TransactionDate`, `Type`, `FinalPrice`) VALUES
(9, 41, 7, 16, '2025-04-08', 'Sale', 150000.00),
(10, 42, 7, 16, '2025-04-08', 'Rent', 140000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`AgentID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`ListingID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `AgentID` (`AgentID`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`OwnerID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`PropertyID`);

--
-- Indexes for table `rentaldetails`
--
ALTER TABLE `rentaldetails`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `AgentID` (`AgentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `AgentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `ListingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `OwnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listing`
--
ALTER TABLE `listing`
  ADD CONSTRAINT `listing_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_ibfk_2` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE;

--
-- Constraints for table `rentaldetails`
--
ALTER TABLE `rentaldetails`
  ADD CONSTRAINT `rentaldetails_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `transaction` (`TransactionID`) ON DELETE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
