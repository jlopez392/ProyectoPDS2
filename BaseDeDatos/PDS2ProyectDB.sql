-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2015 at 07:36 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `bedroom`
--

INSERT INTO `bedroom` (`bedroomId`, `zone`, `price`, `ownerId`, `available`) VALUES
(1, 'zone1', 1.5, 'owner1', 1),
(2, 'zone2', 2.5, 'owner2', 1),
(3, 'zone3', 3.5, 'owner3', 1),
(4, 'zone4', 4.5, 'owner4', 1),
(5, 'zone5', 5.5, 'owner5', 1),
(6, 'zone6', 6.5, 'owner6', 1),
(9, 'zone9', 9.5, 'owner9', 1),
(10, 'zone10', 10.5, 'owner1', 1),
(11, 'zone11', 11.5, 'owner2', 1),
(12, 'zone12', 12.5, 'owner3', 1),
(13, 'zone13', 13.5, 'owner4', 1),
(14, 'zone14', 14.5, 'owner5', 1),
(15, 'zone15', 15.5, 'owner6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bedroomRequest`
--

CREATE TABLE IF NOT EXISTS `bedroomRequest` (
  `bedroomRequestId` int(11) NOT NULL AUTO_INCREMENT,
  `bedroomId` int(11) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `advancePayment` float NOT NULL,
  `isConfirmed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bedroomRequestId`),
  KEY `roomId` (`bedroomId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `bedroomRequest`
--

INSERT INTO `bedroomRequest` (`bedroomRequestId`, `bedroomId`, `userId`, `advancePayment`, `isConfirmed`) VALUES
(1, 1, 'user1', 1.5, 1),
(2, 2, 'user1', 2.5, 0),
(3, 4, 'user3', 4.6, 1),
(4, 10, 'user5', 5.5, 0),
(5, 15, 'user5', 45.6, 1),
(7, 1, 'user3', 63.5, 0);

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
('owner2', '2222'),
('owner3', '3333'),
('owner4', '4444'),
('owner5', '5555'),
('owner6', '6666'),
('owner7', '7777'),
('owner8', '8888'),
('owner9', '9999');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomId`, `zone`, `price`, `ownerId`, `available`) VALUES
(11, 'zone11', 11.5, 'owner1', 1),
(22, 'zone22', 22.5, 'owner2', 1),
(33, 'zone33', 33.5, 'owner3', 1),
(44, 'zone44', 44.5, 'owner4', 1),
(55, 'zone55', 55.5, 'owner5', 1),
(66, 'zone66', 66.5, 'owner6', 1),
(77, 'zone77', 77.5, 'owner7', 1),
(88, 'zone88', 88.5, 'owner8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roomRequest`
--

CREATE TABLE IF NOT EXISTS `roomRequest` (
  `roomRequestId` int(11) NOT NULL AUTO_INCREMENT,
  `roomId` int(11) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `advancePayment` float NOT NULL,
  `isConfirmed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roomRequestId`),
  KEY `roomId` (`roomId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `roomRequest`
--

INSERT INTO `roomRequest` (`roomRequestId`, `roomId`, `userId`, `advancePayment`, `isConfirmed`) VALUES
(11, 11, 'user1', 1.5, 1),
(22, 22, 'user2', 2.5, 0),
(33, 33, 'user3', 3.5, 0),
(88, 11, 'user4', 5.8, 0),
(99, 22, 'user5', 6.7, 0);

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
('user1', '1111', 'a', 'aa', 1),
('user2', '2222', 'b', 'bb', 2),
('user3', '3333', 'c', 'cc', 3),
('user4', '4444', 'd', 'dd', 4),
('user5', '5555', 'e', 'ee', 5);

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
  ADD CONSTRAINT `bedroomRequest_ibfk_4` FOREIGN KEY (`userId`) REFERENCES `user` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `bedroomRequest_ibfk_3` FOREIGN KEY (`bedroomId`) REFERENCES `bedroom` (`bedroomId`) ON DELETE CASCADE;

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
