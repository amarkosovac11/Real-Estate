-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 03:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `AgentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`AgentID`, `Name`, `ContactInfo`) VALUES
(1, 'Amar Hadžić', 'amar@example.com'),
(2, 'Sara Kovač', 'sara@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `ClientType` enum('Buyer','Renter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `Name`, `ContactInfo`, `ClientType`) VALUES
(1, 'Faris Mehmedović', 'faris@example.com', 'Buyer'),
(2, 'Lejla Hasić', 'lejla@example.com', 'Renter');

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
(1, 1, 1, '2025-03-28'),
(2, 2, 2, '2025-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `PropertyID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Status` enum('Available','Sold','Rented') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`PropertyID`, `Address`, `Type`, `Size`, `Price`, `Status`) VALUES
(1, 'Zmaja od Bosne 45, Sarajevo', 'Apartment', 85, 150000.00, 'Available'),
(2, 'Titova 12, Sarajevo', 'Apartment', 60, 700.00, 'Available'),
(3, 'Zmaja od Bosne 45, Sarajevo', 'Apartment', 85, 150000.00, 'Available'),
(4, 'Titova 12, Sarajevo', 'Apartment', 60, 700.00, 'Available');

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
(2, '2025-04-01', '2025-10-01');

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
(1, 1, 1, 1, '2025-03-28', 'Sale', 150000.00),
(2, 2, 2, 2, '2025-03-28', 'Rent', 700.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`AgentID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`ListingID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `AgentID` (`AgentID`);

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
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `AgentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `ListingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
