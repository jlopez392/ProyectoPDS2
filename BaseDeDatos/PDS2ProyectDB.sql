-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2015 at 07:20 PM
-- Server version: 5.5.40
-- PHP Version: 5.4.36-0+deb7u3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `PDS2ProyectDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedroom`
--

CREATE TABLE IF NOT EXISTS `bedroom` (
  `bedroomId` int(11) NOT NULL AUTO_INCREMENT,
  `zone` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `ownerId` varchar(50) NOT NULL,
  `available` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bedroomId`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `bedroom`
--

INSERT INTO `bedroom` (`bedroomId`, `zone`, `price`, `ownerId`, `available`) VALUES
(27, 'zone1', 1, 'owner1', 1),
(28, 'zone2', 2, 'owner1', 1),
(30, 'zone3', 3, 'owner1', 1),
(31, 'zone4', 4, 'owner1', 0),
(32, 'zone5', 5, 'owner1', 1),
(33, 'zone6', 6, 'owner1', 1),
(34, 'zone7', 7, 'owner1', 1),
(35, 'zone8', 8, 'owner1', 0),
(36, 'zone9', 9, 'owner1', 1),
(37, 'zone10', 10, 'owner1', 0),
(39, 'zone2', 2, 'owner2', 1),
(40, 'zone1', 1, 'owner2', 1),
(41, 'zone3', 3, 'owner2', 1),
(42, 'zone4', 4, 'owner2', 1),
(43, 'zone5', 5, 'owner2', 1),
(44, 'zone6', 6, 'owner2', 1),
(45, 'zone7', 7, 'owner2', 1),
(46, 'zone8', 8, 'owner2', 1),
(47, 'zone9', 9, 'owner2', 1),
(48, 'zone10', 10, 'owner2', 1),
(49, 'zone897', 8.5, 'owner1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bedroomRequest`
--

CREATE TABLE IF NOT EXISTS `bedroomRequest` (
  `bedroomRequestId` int(11) NOT NULL AUTO_INCREMENT,
  `bedroomId` int(11) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `advancePayment` tinyint(4) NOT NULL DEFAULT '0',
  `isConfirmed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bedroomRequestId`),
  UNIQUE KEY `bedroomId` (`bedroomId`,`userId`),
  KEY `roomId` (`bedroomId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `bedroomRequest`
--

INSERT INTO `bedroomRequest` (`bedroomRequestId`, `bedroomId`, `userId`, `advancePayment`, `isConfirmed`) VALUES
(28, 27, 'user1', 0, 0),
(29, 31, 'user1', 0, 1),
(30, 35, 'user1', 0, 1),
(31, 42, 'user1', 0, 0),
(32, 45, 'user1', 0, 0),
(33, 48, 'user1', 0, 0),
(37, 39, 'user1', 0, 0),
(38, 32, 'user1', 0, 0),
(42, 37, 'user2', 0, 1),
(43, 44, 'user2', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`username`, `password`) VALUES
('owner1', '1111'),
('owner2', '2222');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `roomId` int(11) NOT NULL AUTO_INCREMENT,
  `zone` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `ownerId` varchar(20) NOT NULL,
  `available` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`roomId`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomId`, `zone`, `price`, `ownerId`, `available`) VALUES
(95, 'zone1', 1, 'owner1', 0),
(96, 'zone2', 2, 'owner1', 0),
(97, 'zone3', 3, 'owner1', 1),
(98, 'zone4', 4, 'owner1', 1),
(99, 'zone5', 5, 'owner1', 0),
(100, 'zone6', 6, 'owner1', 1),
(101, 'zone7', 7, 'owner1', 1),
(103, 'zone8', 8, 'owner1', 1),
(104, 'zone9', 9, 'owner1', 0),
(105, 'zone10', 10, 'owner1', 1),
(106, 'zone1', 1, 'owner2', 1),
(107, 'zone2', 2, 'owner2', 1),
(108, 'zone3', 3, 'owner2', 1),
(109, 'zone4', 4, 'owner2', 1),
(110, 'zone5', 5, 'owner2', 1),
(111, 'zone6', 6, 'owner2', 1),
(112, 'zone7', 7, 'owner2', 1),
(113, 'zone8', 8, 'owner2', 1),
(114, 'zone9', 9, 'owner2', 1),
(115, 'zone10', 10, 'owner2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roomRequest`
--

CREATE TABLE IF NOT EXISTS `roomRequest` (
  `roomRequestId` int(11) NOT NULL AUTO_INCREMENT,
  `roomId` int(11) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `advancePayment` tinyint(4) NOT NULL DEFAULT '0',
  `isConfirmed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roomRequestId`),
  UNIQUE KEY `roomId_2` (`roomId`,`userId`),
  KEY `roomId` (`roomId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `roomRequest`
--

INSERT INTO `roomRequest` (`roomRequestId`, `roomId`, `userId`, `advancePayment`, `isConfirmed`) VALUES
(99, 95, 'user1', 0, 1),
(100, 97, 'user1', 0, 0),
(101, 99, 'user1', 0, 1),
(102, 103, 'user1', 0, 0),
(103, 106, 'user1', 0, 0),
(104, 110, 'user1', 0, 0),
(105, 114, 'user1', 0, 0),
(106, 96, 'user1', 0, 1),
(107, 112, 'user1', 0, 0),
(108, 98, 'user2', 0, 0),
(109, 104, 'user2', 0, 1),
(110, 112, 'user2', 0, 0),
(115, 98, 'user1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `numberPhone` int(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `lastname`, `numberPhone`) VALUES
('user1', '1111', 'juan', 'perez', 1111),
('user2', '2222', 'asdasd', 'assss', 22222),
('user3', '3333', 'asdasd', 'sss', 98754);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bedroom`
--
ALTER TABLE `bedroom`
  ADD CONSTRAINT `bedroom_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `owner` (`username`);

--
-- Constraints for table `bedroomRequest`
--
ALTER TABLE `bedroomRequest`
  ADD CONSTRAINT `bedroomRequest_ibfk_3` FOREIGN KEY (`bedroomId`) REFERENCES `bedroom` (`bedroomId`) ON DELETE CASCADE,
  ADD CONSTRAINT `bedroomRequest_ibfk_4` FOREIGN KEY (`userId`) REFERENCES `user` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `owner` (`username`);

--
-- Constraints for table `roomRequest`
--
ALTER TABLE `roomRequest`
  ADD CONSTRAINT `roomRequest_ibfk_1` FOREIGN KEY (`roomId`) REFERENCES `room` (`roomId`),
  ADD CONSTRAINT `roomRequest_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
