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

-- Database: `real_estate_db`
CREATE DATABASE IF NOT EXISTS `real_estate_db`;
USE `real_estate_db`;

-- Table structure for table `agent`
CREATE TABLE `agent` (
  `AgentID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`AgentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `agent` (`Name`, `ContactInfo`) VALUES
('Amar Hadžić', 'amar@example.com'),
('Sara Kovač', 'sara@example.com');

-- Table structure for table `client`
CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `ClientType` enum('Buyer','Renter') NOT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `client` (`Name`, `ContactInfo`, `ClientType`) VALUES
('Faris Mehmedović', 'faris@example.com', 'Buyer'),
('Lejla Hasić', 'lejla@example.com', 'Renter');

-- Table structure for table `property`
CREATE TABLE `property` (
  `PropertyID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` varchar(255) NOT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Status` ENUM('For Sale', 'For Rent') DEFAULT 'For Sale',
  PRIMARY KEY (`PropertyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `property` (`Address`, `Type`, `Size`, `Price`, `Status`) VALUES
('Zmaja od Bosne 45, Sarajevo', 'Apartment', 85, 150000.00, 'For Sale'),
('Titova 12, Sarajevo', 'Apartment', 60, 700.00, 'For Rent'),
('Obala Kulina Bana 30, Sarajevo', 'House', 200, 400000.00, 'For Sale'),
('Alipašina 10, Sarajevo', 'Apartment', 95, 170000.00, 'For Sale'),
('Stup 3, Sarajevo', 'Apartment', 80, 120000.00, 'For Sale'),
('Ilidža 18, Sarajevo', 'House', 150, 220000.00, 'For Rent'),
('Dobrinja 5, Sarajevo', 'Studio', 45, 60000.00, 'For Rent'),
('Bistrik 7, Sarajevo', 'House', 180, 300000.00, 'For Sale');

-- Table structure for table `listing`
CREATE TABLE `listing` (
  `ListingID` int(11) NOT NULL AUTO_INCREMENT,
  `PropertyID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `ListingDate` date DEFAULT curdate(),
  PRIMARY KEY (`ListingID`),
  FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `listing` (`PropertyID`, `AgentID`, `ListingDate`) VALUES
(1, 1, '2025-03-28'),
(2, 2, '2025-03-28');

-- Table structure for table `transaction`
CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
  `PropertyID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `TransactionDate` date DEFAULT curdate(),
  `Type` ENUM('Sale','Rent') NOT NULL,
  `FinalPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`TransactionID`),
  FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`) ON DELETE CASCADE,
  FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `transaction` (`PropertyID`, `ClientID`, `AgentID`, `TransactionDate`, `Type`, `FinalPrice`) VALUES
(1, 1, 1, '2025-03-28', 'Sale', 150000.00),
(2, 2, 2, '2025-03-28', 'Rent', 700.00);

-- Table structure for table `rentaldetails`
CREATE TABLE `rentaldetails` (
  `TransactionID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  PRIMARY KEY (`TransactionID`),
  FOREIGN KEY (`TransactionID`) REFERENCES `transaction` (`TransactionID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rentaldetails` (`TransactionID`, `StartDate`, `EndDate`) VALUES
(2, '2025-04-01', '2025-10-01');

COMMIT;
