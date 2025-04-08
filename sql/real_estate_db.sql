-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 05:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `contactInfo` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `admin` (`AdminID`, `name`, `username`, `contactInfo`, `password`) VALUES
(1, 'Admin User', 'admin', 'admin@example.com', '0192023a7bbd73250516f069df18b500');


CREATE TABLE `agent` (
  `AgentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `agent` (`AgentID`, `Name`, `ContactInfo`, `username`, `password`) VALUES
(16, 'agentName', '123', 'agent1', '202cb962ac59075b964b07152d234b70'),
(17, 'agentName', '123', 'agent2', '202cb962ac59075b964b07152d234b70');


CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `client` (`ClientID`, `Name`, `ContactInfo`, `username`, `password`) VALUES
(7, 'clientName', '123', 'client1', '202cb962ac59075b964b07152d234b70'),
(8, 'clientName', '123', 'client2', '202cb962ac59075b964b07152d234b70');


CREATE TABLE `listing` (
  `ListingID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `ListingDate` date DEFAULT curdate(),
  `ApprovedByAdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `listing` (`ListingID`, `PropertyID`, `AgentID`, `ListingDate`, `ApprovedByAdminID`) VALUES
(19, 41, 16, '2025-04-08', NULL),
(20, 42, 16, '2025-04-08', NULL);


CREATE TABLE `owner` (
  `OwnerID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ContactInfo` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `owner` (`OwnerID`, `Name`, `username`, `ContactInfo`, `password`) VALUES
(2, 'ownerName', 'owner1', '123', '202cb962ac59075b964b07152d234b70'),
(3, 'ownerName', 'owner2', '123', '202cb962ac59075b964b07152d234b70');


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


INSERT INTO `property` (`PropertyID`, `AgentID`, `Address`, `Type`, `Size`, `Price`, `Status`, `ImageURL`, `OwnerID`) VALUES
(41, 16, 'address1', 'Villa', 120, 150000.00, '', 'uploads/67f5375218ea2_vila1.jpg', NULL),
(42, 16, 'address2', 'Villa', 120, 140000.00, '', 'uploads/67f53771bb826_vila2.jpg', NULL),
(43, 0, 'address3', 'Apartment', 125, 160000.00, 'For Sale', 'uploads/67f5394f0ccbd_house3.jpg', 2),
(44, 0, 'address4', 'House', 120, 170000.00, 'For Sale', 'uploads/67f53969e31fd_house4.jpg', 2);



CREATE TABLE `rentaldetails` (
  `TransactionID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `rentaldetails` (`TransactionID`, `StartDate`, `EndDate`) VALUES
(10, '2025-04-03', '2025-04-25');


CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `TransactionDate` date DEFAULT curdate(),
  `Type` enum('Sale','Rent') NOT NULL,
  `FinalPrice` decimal(10,2) NOT NULL,
  `AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `transaction` (`TransactionID`, `PropertyID`, `ClientID`, `AgentID`, `TransactionDate`, `Type`, `FinalPrice`, `AdminID`) VALUES
(9, 41, 7, 16, '2025-04-08', 'Sale', 150000.00, NULL),
(10, 42, 7, 16, '2025-04-08', 'Rent', 140000.00, NULL);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `agent`
  ADD PRIMARY KEY (`AgentID`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `listing`
  ADD PRIMARY KEY (`ListingID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `AgentID` (`AgentID`),
  ADD KEY `fk_listing_admin` (`ApprovedByAdminID`);


ALTER TABLE `owner`
  ADD PRIMARY KEY (`OwnerID`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `property`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `fk_owner` (`OwnerID`);


ALTER TABLE `rentaldetails`
  ADD PRIMARY KEY (`TransactionID`);


ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `AgentID` (`AgentID`),
  ADD KEY `fk_transaction_admin` (`AdminID`);


ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `agent`
  MODIFY `AgentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;


ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `listing`
  MODIFY `ListingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;


ALTER TABLE `owner`
  MODIFY `OwnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `property`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;


ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `listing`
  ADD CONSTRAINT `fk_listing_admin` FOREIGN KEY (`ApprovedByAdminID`) REFERENCES `admin` (`AdminID`) ON DELETE SET NULL,
  ADD CONSTRAINT `listing_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_ibfk_2` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE;


ALTER TABLE `property`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`OwnerID`) REFERENCES `owner` (`OwnerID`) ON DELETE SET NULL;


ALTER TABLE `rentaldetails`
  ADD CONSTRAINT `rentaldetails_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `transaction` (`TransactionID`) ON DELETE CASCADE;


ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_transaction_admin` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`AgentID`) ON DELETE CASCADE;
COMMIT;


