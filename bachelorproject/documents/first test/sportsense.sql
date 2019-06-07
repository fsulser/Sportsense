-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2014 at 03:36 PM
-- Server version: 5.5.35-1ubuntu1
-- PHP Version: 5.5.9-1ubuntu2

create database first;
use first;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sportsense`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE IF NOT EXISTS `Admin` (
  `AdminId` int(11) NOT NULL AUTO_INCREMENT,
  `AdminName` varchar(60) DEFAULT NULL,
  `AdminPW` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`AdminId`),
  UNIQUE KEY `AdminId` (`AdminId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminId`, `AdminName`, `AdminPW`) VALUES
(1, 'azureuser', '235a6085e75b0e7c0cdace5f7af2d663723ce6cebfe85108ab94279fd1eb75b682742854c4b1b609a799e57ee091d0e34ddf8cbd208defc5f4c87966db796747');

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE IF NOT EXISTS `Event` (
  `EventId` int(11) NOT NULL AUTO_INCREMENT,
  `TaskId` int(11) NOT NULL,
  `trackedPoint` blob,
  `min` int(11) DEFAULT NULL,
  `sec` int(11) DEFAULT NULL,
  `msec` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `period_id` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  PRIMARY KEY (`EventId`),
  KEY `TaskId` (`TaskId`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

--
-- Dumping data for table `Event`
--

INSERT INTO `Event` (`EventId`, `TaskId`, `trackedPoint`, `min`, `sec`, `msec`, `type_id`, `team_id`, `player_id`, `period_id`, `rating`) VALUES
(3, 4, NULL, 43, 1, 2, 5, 30, NULL, NULL, 1),
(4, 4, NULL, 43, 1, 2, 5, 43, NULL, NULL, 0),
(5, 6, NULL, 43, 2, 0, 4, 43, NULL, NULL, 0),
(6, 6, NULL, 43, 6, 3, 4, 43, NULL, NULL, 1),
(7, 6, NULL, 43, 6, 9, 17, 43, NULL, NULL, 1),
(8, 9, NULL, 43, 6, 0, 4, 30, NULL, NULL, 1),
(9, 17, NULL, 43, 19, 0, 17, 30, NULL, NULL, 1),
(10, 18, NULL, 43, 15, 0, 1, 43, NULL, NULL, 1),
(11, 19, NULL, 43, 16, 0, 1, 30, NULL, NULL, 1),
(12, 20, NULL, 43, 20, 3, 17, 43, NULL, NULL, 2),
(13, 20, NULL, 43, 21, 9, 4, 43, NULL, NULL, -1),
(14, 20, NULL, 43, 17, 8, 15, 30, NULL, NULL, -1),
(15, 28, NULL, 43, 24, 0, 16, 43, NULL, NULL, -1),
(16, 28, NULL, 43, 24, 0, 16, 30, NULL, NULL, -1),
(17, 29, NULL, 43, 29, 2, 1, 30, NULL, NULL, 0),
(18, 30, NULL, 43, 31, 8, 1, 43, NULL, NULL, 0),
(19, 30, NULL, 43, 30, 9, 13, 43, NULL, NULL, -1),
(20, 32, NULL, 43, 33, 7, 1, 43, NULL, NULL, 2),
(21, 33, NULL, 43, 30, 0, 4, 43, NULL, NULL, -1),
(22, 34, NULL, 43, 31, 0, 1, 43, NULL, NULL, 0),
(23, 38, NULL, 43, 36, 5, 16, 30, NULL, NULL, -2),
(24, 36, NULL, 43, 37, 8, 1, 43, NULL, NULL, -1),
(25, 42, NULL, 43, 39, 0, 1, 43, NULL, NULL, 0),
(26, 42, NULL, 43, 39, 0, 1, 43, NULL, NULL, 0),
(27, 42, NULL, 43, 39, 1, 4, 30, NULL, NULL, 2),
(28, 42, NULL, 43, 39, 5, 4, 43, NULL, NULL, -1),
(29, 42, NULL, 43, 44, 0, 17, 30, NULL, NULL, 1),
(30, 42, NULL, 43, 39, 0, 1, 43, NULL, NULL, 0),
(31, 42, NULL, 43, 39, 0, 1, 43, NULL, NULL, 0),
(32, 42, NULL, 43, 39, 1, 4, 30, NULL, NULL, 2),
(33, 42, NULL, 43, 39, 5, 4, 43, NULL, NULL, -1),
(34, 42, NULL, 43, 44, 0, 17, 30, NULL, NULL, 1),
(35, 45, NULL, 43, 42, 0, 1, 30, NULL, NULL, -2),
(36, 44, NULL, 43, 41, 2, 4, 43, NULL, NULL, -1),
(37, 46, NULL, 43, 43, 0, 1, 30, NULL, NULL, 0),
(38, 46, NULL, 43, 43, 0, 13, 43, NULL, NULL, 0),
(39, 46, NULL, 43, 43, 0, 17, 30, NULL, NULL, 0),
(40, 46, NULL, 43, 43, 0, 4, 30, NULL, NULL, 0),
(41, 46, NULL, 43, 43, 0, 4, 43, NULL, NULL, 0),
(42, 46, NULL, 43, 44, 2, 17, 30, NULL, NULL, 0),
(43, 52, NULL, 43, 49, 0, 1, 30, NULL, NULL, 2),
(44, 53, NULL, 43, 50, 0, 1, 43, NULL, NULL, 0),
(45, 53, NULL, 43, 50, 0, 13, 30, NULL, NULL, 0),
(46, 53, NULL, 43, 50, 0, 16, 43, NULL, NULL, 0),
(47, 53, NULL, 43, 50, 0, 4, 30, NULL, NULL, 0),
(48, 53, NULL, 43, 50, 0, 17, 30, NULL, NULL, 0),
(49, 53, NULL, 43, 50, 0, 6, 43, NULL, NULL, 0),
(50, 53, NULL, 43, 50, 0, 5, 43, NULL, NULL, 0),
(51, 54, NULL, 43, 53, 3, 4, 30, NULL, NULL, 1),
(52, 62, NULL, 43, 59, 0, 17, 30, NULL, NULL, -1),
(53, 62, NULL, 43, 59, 0, 16, 43, NULL, NULL, NULL),
(54, 62, NULL, 43, 59, 0, 13, 43, NULL, NULL, NULL),
(55, 62, NULL, 43, 59, 0, 5, 43, NULL, NULL, NULL),
(56, 66, NULL, 44, 3, 0, 1, 43, NULL, NULL, -2),
(57, 66, NULL, 44, 3, 0, 1, 30, NULL, NULL, -2),
(58, 66, NULL, 44, 6, 6, 13, 43, NULL, NULL, -2),
(59, 69, NULL, 44, 6, 0, 15, 30, NULL, NULL, -2),
(60, 70, NULL, 44, 11, 0, 15, 43, NULL, NULL, -1),
(61, 71, NULL, 44, 8, 0, 16, 43, NULL, NULL, -2),
(62, 76, NULL, 44, 17, 5, 15, 43, NULL, NULL, 0),
(63, 79, NULL, 44, 15, 0, 15, 30, NULL, NULL, 0),
(64, 85, NULL, 44, 26, 0, 5, 30, NULL, NULL, -2),
(65, 87, NULL, 44, 28, 5, 1, 30, NULL, NULL, 1),
(66, 88, NULL, 44, 30, 0, 15, 30, NULL, NULL, 0),
(67, 90, NULL, 44, 27, 0, 1, 43, NULL, NULL, 0),
(68, 90, NULL, 44, 27, 1, 1, 43, NULL, NULL, 0),
(69, 90, NULL, 44, 27, 1, 13, 43, NULL, NULL, NULL),
(70, 90, NULL, 44, 27, 0, 16, 30, NULL, NULL, NULL),
(71, 90, NULL, 44, 27, 1, 13, 30, NULL, NULL, NULL),
(72, 90, NULL, 44, 27, 2, 16, 43, NULL, NULL, NULL),
(73, 90, NULL, 44, 27, 3, 1, 43, NULL, NULL, NULL),
(74, 90, NULL, 44, 27, 4, 13, 43, NULL, NULL, NULL),
(75, 90, NULL, 44, 27, 5, 15, 30, NULL, NULL, NULL),
(76, 90, NULL, 44, 27, 6, 13, 30, NULL, NULL, NULL),
(77, 90, NULL, 44, 27, 7, 13, 30, NULL, NULL, NULL),
(78, 90, NULL, 44, 27, 8, 13, 30, NULL, NULL, NULL),
(79, 90, NULL, 44, 27, 9, 13, 30, NULL, NULL, NULL),
(80, 90, NULL, 44, 28, 0, 13, 30, NULL, NULL, NULL),
(81, 90, NULL, 44, 28, 1, 13, 30, NULL, NULL, NULL),
(82, 90, NULL, 44, 28, 2, 13, 30, NULL, NULL, NULL),
(83, 90, NULL, 44, 28, 3, 13, 30, NULL, NULL, NULL),
(84, 90, NULL, 44, 28, 4, 13, 30, NULL, NULL, NULL),
(85, 90, NULL, 44, 28, 5, 1, 30, NULL, NULL, NULL),
(86, 90, NULL, 44, 28, 6, 13, 30, NULL, NULL, NULL),
(87, 90, NULL, 44, 28, 7, 13, 30, NULL, NULL, NULL),
(88, 90, NULL, 44, 28, 8, 13, 43, NULL, NULL, NULL),
(89, 90, NULL, 44, 28, 9, 13, 30, NULL, NULL, NULL),
(90, 90, NULL, 44, 29, 0, 5, 30, NULL, NULL, NULL),
(91, 90, NULL, 44, 29, 1, 5, 30, NULL, NULL, NULL),
(92, 90, NULL, 44, 29, 3, 5, 30, NULL, NULL, NULL),
(93, 90, NULL, 44, 29, 5, 5, 30, NULL, NULL, NULL),
(94, 90, NULL, 44, 29, 8, 1, 30, NULL, NULL, NULL),
(95, 90, NULL, 44, 30, 0, 1, 30, NULL, NULL, NULL),
(96, 90, NULL, 44, 30, 3, 1, 30, NULL, NULL, NULL),
(97, 90, NULL, 44, 30, 6, 1, 30, NULL, NULL, NULL),
(98, 90, NULL, 44, 30, 9, 1, 30, NULL, NULL, NULL),
(99, 90, NULL, 44, 31, 2, 1, 30, NULL, NULL, NULL),
(100, 90, NULL, 44, 31, 5, 1, 30, NULL, NULL, NULL),
(101, 90, NULL, 44, 31, 8, 15, 30, NULL, NULL, NULL),
(102, 90, NULL, 44, 31, 9, 13, 30, NULL, NULL, NULL),
(103, 90, NULL, 44, 32, 0, 15, 30, NULL, NULL, NULL),
(104, 90, NULL, 44, 27, 0, 1, 43, NULL, NULL, NULL),
(105, 90, NULL, 44, 27, 1, 1, 43, NULL, NULL, NULL),
(106, 90, NULL, 44, 27, 1, 13, 43, NULL, NULL, NULL),
(107, 90, NULL, 44, 27, 0, 16, 30, NULL, NULL, NULL),
(108, 90, NULL, 44, 27, 1, 13, 30, NULL, NULL, NULL),
(109, 90, NULL, 44, 27, 2, 16, 43, NULL, NULL, NULL),
(110, 90, NULL, 44, 27, 3, 1, 43, NULL, NULL, NULL),
(111, 90, NULL, 44, 27, 4, 13, 43, NULL, NULL, NULL),
(112, 90, NULL, 44, 27, 5, 15, 30, NULL, NULL, NULL),
(113, 90, NULL, 44, 27, 6, 13, 30, NULL, NULL, NULL),
(114, 90, NULL, 44, 27, 7, 13, 30, NULL, NULL, NULL),
(115, 90, NULL, 44, 27, 8, 13, 30, NULL, NULL, NULL),
(116, 90, NULL, 44, 27, 9, 13, 30, NULL, NULL, NULL),
(117, 90, NULL, 44, 28, 0, 13, 30, NULL, NULL, NULL),
(118, 90, NULL, 44, 28, 1, 13, 30, NULL, NULL, NULL),
(119, 90, NULL, 44, 28, 2, 13, 30, NULL, NULL, NULL),
(120, 90, NULL, 44, 28, 3, 13, 30, NULL, NULL, NULL),
(121, 90, NULL, 44, 28, 4, 13, 30, NULL, NULL, NULL),
(122, 90, NULL, 44, 28, 5, 1, 30, NULL, NULL, NULL),
(123, 90, NULL, 44, 28, 6, 13, 30, NULL, NULL, NULL),
(124, 90, NULL, 44, 28, 7, 13, 30, NULL, NULL, NULL),
(125, 90, NULL, 44, 28, 8, 13, 43, NULL, NULL, NULL),
(126, 90, NULL, 44, 28, 9, 13, 30, NULL, NULL, NULL),
(127, 90, NULL, 44, 29, 0, 5, 30, NULL, NULL, NULL),
(128, 90, NULL, 44, 29, 1, 5, 30, NULL, NULL, NULL),
(129, 90, NULL, 44, 29, 3, 5, 30, NULL, NULL, NULL),
(130, 90, NULL, 44, 29, 5, 5, 30, NULL, NULL, NULL),
(131, 90, NULL, 44, 29, 8, 1, 30, NULL, NULL, NULL),
(132, 90, NULL, 44, 30, 0, 1, 30, NULL, NULL, NULL),
(133, 90, NULL, 44, 30, 3, 1, 30, NULL, NULL, NULL),
(134, 90, NULL, 44, 30, 6, 1, 30, NULL, NULL, NULL),
(135, 90, NULL, 44, 30, 9, 1, 30, NULL, NULL, NULL),
(136, 90, NULL, 44, 31, 2, 1, 30, NULL, NULL, NULL),
(137, 90, NULL, 44, 31, 5, 1, 30, NULL, NULL, NULL),
(138, 90, NULL, 44, 31, 8, 15, 30, NULL, NULL, NULL),
(139, 90, NULL, 44, 31, 9, 13, 30, NULL, NULL, NULL),
(140, 90, NULL, 44, 32, 0, 15, 30, NULL, NULL, NULL),
(141, 92, NULL, 44, 34, 0, 16, 30, NULL, NULL, 2),
(142, 94, NULL, 44, 31, 0, 15, 43, NULL, NULL, -1),
(143, 95, NULL, 44, 32, 0, 1, 30, NULL, NULL, 2),
(144, 96, NULL, 44, 33, 0, 1, 43, NULL, NULL, 0),
(145, 96, NULL, 44, 33, 0, 13, 43, NULL, NULL, 0),
(146, 96, NULL, 44, 33, 0, 13, 43, NULL, NULL, 0),
(147, 97, NULL, 44, 34, 0, 1, 43, NULL, NULL, -1),
(148, 97, NULL, 44, 37, 2, 15, 30, NULL, NULL, 0),
(149, 98, NULL, 44, 36, 2, 16, 30, NULL, NULL, 1),
(150, 99, NULL, 44, 36, 0, 16, 30, NULL, NULL, 1),
(151, 102, NULL, 44, 39, 0, 13, 30, NULL, NULL, -1),
(152, 103, NULL, 44, 39, 0, 6, 30, NULL, NULL, -2),
(153, 103, NULL, 44, 39, 1, 13, 30, NULL, NULL, -2),
(154, 103, NULL, 44, 39, 2, 13, 43, NULL, NULL, -2),
(155, 103, NULL, 44, 39, 7, 13, 43, NULL, NULL, -2),
(156, 103, NULL, 44, 39, 7, 1, 43, NULL, NULL, 0),
(157, 103, NULL, 44, 44, 0, 1, 30, NULL, NULL, 0),
(158, 103, NULL, 44, 39, 0, 6, 30, NULL, NULL, 0),
(159, 103, NULL, 44, 39, 1, 13, 30, NULL, NULL, 0),
(160, 103, NULL, 44, 39, 2, 13, 43, NULL, NULL, 0),
(161, 103, NULL, 44, 39, 7, 13, 43, NULL, NULL, 0),
(162, 103, NULL, 44, 39, 7, 1, 43, NULL, NULL, 0),
(163, 103, NULL, 44, 44, 0, 1, 30, NULL, NULL, 0),
(164, 107, NULL, 44, 44, 0, 4, 30, NULL, NULL, 1),
(165, 107, NULL, 44, 44, 0, 4, 30, NULL, NULL, 0),
(166, 110, NULL, 44, 47, 0, 15, 43, NULL, NULL, -2),
(167, 121, NULL, 44, 58, 0, 4, 43, NULL, NULL, NULL),
(168, 127, NULL, 45, 4, 0, 4, 43, NULL, NULL, NULL),
(169, 129, NULL, 45, 6, 0, 1, 43, NULL, NULL, NULL),
(170, 129, NULL, 45, 6, 0, 1, 43, NULL, NULL, NULL),
(171, 131, NULL, 45, 8, 0, 1, 43, NULL, NULL, NULL),
(172, 131, NULL, 45, 9, 2, 1, 30, NULL, NULL, NULL),
(173, 133, NULL, 45, 10, 0, 1, 30, NULL, NULL, NULL),
(174, 140, NULL, 45, 17, 0, 4, 43, NULL, NULL, NULL),
(175, 149, NULL, 45, 26, 0, 16, 43, NULL, NULL, NULL),
(176, 149, NULL, 45, 26, 0, 16, 43, NULL, NULL, NULL),
(177, 150, NULL, 45, 27, 0, 4, 30, NULL, NULL, NULL),
(178, 152, NULL, 45, 29, 0, 15, 43, NULL, NULL, NULL),
(179, 154, NULL, 45, 34, 0, 4, 43, NULL, NULL, 1),
(180, 159, NULL, 45, 36, 0, 1, 43, NULL, NULL, -2),
(181, 157, NULL, 45, 38, 9, 4, 43, NULL, NULL, NULL),
(182, 157, NULL, 45, 35, 0, 4, 43, NULL, NULL, NULL),
(183, 160, NULL, 45, 37, 9, 4, 43, NULL, NULL, NULL),
(184, 161, NULL, 45, 40, 1, 4, 30, NULL, NULL, NULL),
(185, 164, NULL, 45, 41, 4, 1, 43, NULL, NULL, NULL),
(186, 166, NULL, 45, 43, 2, 4, 43, NULL, NULL, -1),
(187, 166, NULL, 45, 43, 2, 4, 43, NULL, NULL, -1),
(188, 168, NULL, 45, 45, 0, 1, 43, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `EventNames`
--

CREATE TABLE IF NOT EXISTS `EventNames` (
  `EventNamesId` int(11) NOT NULL,
  `ListId` int(11) NOT NULL,
  `EventName` varchar(60) DEFAULT NULL,
  `EventDescription` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`EventNamesId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EventNames`
--

INSERT INTO `EventNames` (`EventNamesId`, `ListId`, `EventName`, `EventDescription`) VALUES
(1, 0, 'Pass', 'When the player in possession kicks the ball to a teammate'),
(4, 12, 'Foul', 'A foul is an unfair act by a player which is deemed by the referee'),
(5, 14, 'Out', 'The ball is out if he goes over the outside line with his full volume'),
(6, 15, 'Corner Kick', 'A corner cick is when the game is restartet from a corner of the outer field by foot'),
(13, 6, 'Shot off target', 'A player shoots and the ball misses the target'),
(15, 7, 'Shot on target', 'A player shoots and the ball has the direction of the target'),
(16, 8, 'Goal', 'A goal is scored when the entire ball crosses the whole of the goal line between the goalposts and the crossbar'),
(17, 13, 'Card', 'A player is shown a card by the referee. This can be a yellow or a red one.');

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE IF NOT EXISTS `Task` (
  `TaskId` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `sequenceStart` int(11) DEFAULT NULL,
  `token` varchar(1000) NOT NULL,
  `taskToken` varchar(1000) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `finished` int(11) DEFAULT NULL,
  `isRated` int(11) DEFAULT NULL,
  PRIMARY KEY (`TaskId`),
  KEY `UID` (`UID`),
  KEY `VideoId` (`VideoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`TaskId`, `UID`, `VideoId`, `sequenceStart`, `token`, `taskToken`, `rating`, `finished`, `isRated`) VALUES
(3, 2, 1, 2580, 'mw-50b07811106577be61832550b07309de8f9f922af5cb165a08868338870b06e8', 'ae48131e7517', NULL, 0, 0),
(4, 5, 1, 2581, 'mw-98b8bff47998cb99ef5e04759519090e46d6101c4eb3815480691627dc5e332d', 'ae48131e7517', NULL, 1, 0),
(5, 4, 1, 2582, 'mw-f7fa8d78233d5e17117ed5969600ebf31f762fc29b51dde7d2a1b92942ebd7ba', 'ae48131e7517', NULL, 0, 0),
(6, 6, 1, 2583, 'mw-fe48f795a224693cf781a4f3d301cffdf74aa74b93a7aab4e912bf16536cced8', 'ae48131e7517', NULL, 1, 0),
(7, 9, 1, 2584, 'mw-86319c3befe5c1d8f5ef3bb749f44685cf01b3e2814f14376b063cb22525fc3d', 'ae48131e7517', NULL, 0, 0),
(8, 10, 1, 2585, 'mw-acc71afd416b7b4f5ad69245aafc2c1338ba26570e0eef6bc918abc52dd41ee6', 'ae48131e7517', NULL, 1, 0),
(9, 11, 1, 2586, 'mw-153807e03bb35ec4cc06396c5ee67c758ddcaabd873afe3d11c8134c1a79aedc', 'ae48131e7517', NULL, 1, 0),
(10, 12, 1, 2587, 'mw-8ead27fd9bcaca307d702d1a31ab03acbd4c27e1ab0e1596a5373f9bc98cb0ba', 'ae48131e7517', NULL, 0, 0),
(11, 13, 1, 2588, 'mw-22326600786b8acb301f37bf146e1935d1bfe07af075661ba10a7975f84b833a', 'ae48131e7517', NULL, 0, 0),
(12, 15, 1, 2589, 'mw-a01bf898cb062b617f171a01d92ae64dec7574dad02925fa1d0dee2c33100342', 'ae48131e7517', NULL, 1, 0),
(13, 14, 1, 2590, 'mw-0a468471e93b0da5d81c5fe87332088090c103ec12d5c3440c2af0b591c07ac3', 'ae48131e7517', NULL, 1, 0),
(14, 17, 1, 2591, 'mw-34ce1bbf4ca0dc463efc5aea37305c991bd731995144a48b63dfbf12a1218404', 'ae48131e7517', NULL, 0, 0),
(15, 16, 1, 2592, 'mw-2eed8ab25d798aa757e7bd6e8f46a98b95fc2da65f447b7090084c2ed0945693', 'ae48131e7517', NULL, 0, 0),
(16, 18, 1, 2593, 'mw-fc53a12cbba9947d35a10750c74971d2b36e68ebe64506775bfd4ad8d1c7de0b', 'ae48131e7517', NULL, 0, 0),
(17, 20, 1, 2594, 'mw-32bbcf24c31de78ac2ee729d3fa358753d953dcc1c33443be1ebf9878029a65a', 'ae48131e7517', NULL, 1, 0),
(18, 22, 1, 2595, 'mw-d4c3563b9bc375e624b5ce7bd04f2498ec91b93b4f8267069c4fd85667df494e', 'ae48131e7517', NULL, 1, 0),
(19, 23, 1, 2596, 'mw-97a2adfc6af6ad7da6089b745bd3a1cc4dd5c0ff0cc33a14580669aa9749d655', 'ae48131e7517', NULL, 1, 0),
(20, 24, 1, 2597, 'mw-662f2a773029f8cbdd451aab679ff8b0f49a71252fc9a9fcd7cde00a6def31b0', 'ae48131e7517', NULL, 1, 0),
(21, 25, 1, 2598, 'mw-76c660ac8f5b7f90bfc34fdce806db2aa7c9f7cbaa67f0abcf01ef01f155c9f6', 'ae48131e7517', NULL, 1, 0),
(22, 26, 1, 2599, 'mw-9506771e3ce8dad78278e19289afe1f0db8047d1fe1a206f4bf25589dd026a2b', 'ae48131e7517', NULL, 0, 0),
(23, 27, 1, 2600, 'mw-31ff57c6f3091b880a22f922459ce1b081c57bd3b8a8b5df071731e15be2bd90', 'ae48131e7517', NULL, 0, 0),
(24, 28, 1, 2601, 'mw-71099814b5eb4e2e59bd60a00caf6e32bf0e1d2befe524ed35ea78d923a248a0', 'ae48131e7517', NULL, 0, 0),
(25, 29, 1, 2602, 'mw-1ca045ecbf1efed119f4862a84b1e2eacf3eb7900f5925dce51a7da80dc303af', 'ae48131e7517', NULL, 0, 0),
(26, 31, 1, 2603, 'mw-5967d72af7d6c40a9846a78172a46f5be8ac684164f9fa208baef57f80411a41', 'ae48131e7517', NULL, 1, 0),
(27, 32, 1, 2604, 'mw-4e7f8a800265fe05bbd31171141f72dd937a34267c4d8182ed83a9092283e834', 'ae48131e7517', NULL, 0, 0),
(28, 33, 1, 2605, 'mw-3a8e4291cdad7a8c81e4b99fdbb2887c852a2e6b72a84ce7a5028b74f6f95a91', 'ae48131e7517', NULL, 1, 0),
(29, 34, 1, 2606, 'mw-9abf6b1652a13cfcd837a8a8ac35d07f2cabc0a4fe6b2f124635b3b6a745fc5e', 'ae48131e7517', NULL, 1, 0),
(30, 35, 1, 2607, 'mw-8d474373d1316d9c7f19b4b8fedad2ca8dc9e85fece66dc8a74c30d0a4696eec', 'ae48131e7517', NULL, 1, 0),
(31, 36, 1, 2608, 'mw-c7f6f82b2bdd4215e4218d2bfbbb67ca532fee56242a1997beeb3b11f822eef1', 'ae48131e7517', NULL, 1, 0),
(32, 37, 1, 2609, 'mw-c1f9ff712b2d440dacabfde469d4e063479513776f9c3b73bf37b74c83f2b79f', 'ae48131e7517', NULL, 1, 0),
(33, 38, 1, 2610, 'mw-dd3baf0c339d998414bded7cf9065690ea820d8d5fbc63f4845e087b761a75e2', 'ae48131e7517', NULL, 1, 0),
(34, 39, 1, 2611, 'mw-8ce0ceda1ad52c51d6fcc9be8590b5c8d3a6e1baadc279184f544838847734a1', 'ae48131e7517', NULL, 1, 0),
(35, 39, 1, 2612, 'mw-8ce0ceda1ad52c51d6fcc9be8590b5c8d3a6e1baadc279184f544838847734a1', 'ae48131e7517', NULL, 1, 0),
(36, 42, 1, 2613, 'mw-60c6eba017a00f7feda00f326e18f5693a962b54f7560899fb614c47042f3b28', 'ae48131e7517', NULL, 1, 0),
(37, 41, 1, 2614, 'mw-fc3bfb5c35159de4272e5ab9080a8b1ddc7c79fd27e5866eaa5dc7d394fd0728', 'ae48131e7517', NULL, 0, 0),
(38, 40, 1, 2615, 'mw-0e7568a9a54bbf78b0665f2ef264e425f03cc8f1af2fa258181709dc77fcdd49', 'ae48131e7517', NULL, 1, 0),
(39, 43, 1, 2616, 'mw-65c7f8fe4142e33cbe50f864198c211a7dc2223142cc7e21ce851c8fb0d3e251', 'ae48131e7517', NULL, 0, 0),
(40, 44, 1, 2617, 'mw-1d771ba217405911b793b8db569f1885641d1d8e1c99c97891913bdc7d80fa82', 'ae48131e7517', NULL, 0, 0),
(41, 46, 1, 2618, 'mw-d1edcc44317d958534ea15ab8c54147edc8df86bfbe033ea57326829d5b6a7f2', 'ae48131e7517', NULL, 0, 0),
(42, 47, 1, 2619, 'mw-737923906091082ba0168e519c1514fb2ba188dc51ca76660be71c140c4fd09a', 'ae48131e7517', NULL, 1, 0),
(43, 50, 1, 2620, 'mw-523e64a3726ea52afad553e36c961c88eb4e342e114708729d9e49d7b7581585', 'ae48131e7517', NULL, 0, 0),
(44, 51, 1, 2621, 'mw-ecccb82c394b59ca752586a647d6ca72605ad5bfd593e2e1beea66744a1198a9', 'ae48131e7517', NULL, 1, 0),
(45, 52, 1, 2622, 'mw-0e8dc76fb314fc0c26fabe5a31527161d467002328d950b34db4691043a5812d', 'ae48131e7517', NULL, 1, 0),
(46, 53, 1, 2623, 'mw-3965fcb7dda94743b7a08ca899fa4d959b9a3c4ef856404dc0003f8604145958', 'ae48131e7517', NULL, 1, 0),
(47, 54, 1, 2624, 'mw-1277bf54a69ee6c8bd47450719b90eac6edc07c75a8edc5e25a6311933cbd1ef', 'ae48131e7517', NULL, 1, 0),
(48, 56, 1, 2625, 'mw-3209739d15faaf4bee270a25b19db7fc1f22e703cb9a76dbe9494f301fb53e3d', 'ae48131e7517', NULL, 0, 0),
(49, 57, 1, 2626, 'mw-155ab39951ea07852d05fd8dce7dd85d01e22b239c4bca71c985cea78395b83a', 'ae48131e7517', NULL, 1, 0),
(50, 58, 1, 2627, 'mw-e17bbab5933f00eb6e4717bff9984d79cf43495e0c86648c1cf5fb63f6dac57f', 'ae48131e7517', NULL, 0, 0),
(51, 60, 1, 2628, 'mw-d4247789614b913c92b59e23cf2b3ad17d3db717522bdb1d3997e37e7a87461f', 'ae48131e7517', NULL, 0, 0),
(52, 62, 1, 2629, 'mw-f89288b27ba3138e99ccbf151d1420f0dc34cffbf3e7a3e2c6e766e50f0e74de', 'ae48131e7517', NULL, 1, 0),
(53, 63, 1, 2630, 'mw-be378754a1ed5a02e0c3ceb6074b3f384bcf74d79410b30c5c81b935c906df8a', 'ae48131e7517', NULL, 1, 0),
(54, 64, 1, 2631, 'mw-8ab6a9247d3a37d2c5bbaab002282445a6c59aeff714002b3971788a47d4b41c', 'ae48131e7517', NULL, 1, 0),
(55, 65, 1, 2632, 'mw-f5af3df416ac1c78d70626f7eb9c86cedf695a9035adf9e921cf17cb9eec9be9', 'ae48131e7517', NULL, 0, 0),
(56, 67, 1, 2633, 'mw-0856317e77954ba192fd29f6f79f048b6dc544a7213fc9c8e1397484f2b79879', 'ae48131e7517', NULL, 0, 0),
(57, 68, 1, 2634, 'mw-27fcb97db02988b8419ea30dfcdffa66dbc8e75642fd211859cdf3de639bca10', 'ae48131e7517', NULL, 0, 0),
(58, 70, 1, 2635, 'mw-4510ae148df30b110f711bc4680440643a90b8ae1c3c9ff6d160443c2f1c802d', 'ae48131e7517', NULL, 0, 0),
(59, 72, 1, 2636, 'mw-76531f97cdcaf2c5c3d7d21e7ad3871d342e3aff12ca823e7a6d9e681326a8d8', 'ae48131e7517', NULL, 0, 0),
(60, 74, 1, 2637, 'mw-e61bc81897531ea2cd38f0d2740f06aed69d3d0fa20ecb727db819db42e23f71', 'ae48131e7517', NULL, 1, 0),
(61, 75, 1, 2638, 'mw-7aa5891614d917d221a137f6969d930578b84b5849c53520b5a607409c636da6', 'ae48131e7517', NULL, 0, 0),
(62, 77, 1, 2639, 'mw-d4fb7de9504addadba2efd239644bdd93355bf0636d098a2b7a1f521f07374ee', 'ae48131e7517', NULL, 1, 0),
(63, 78, 1, 2640, 'mw-cf8cd43cd6f38ee412e4e84c2af54f0c514a3b8b956ef54510afbf251428c0e9', 'ae48131e7517', NULL, 1, 0),
(64, 81, 1, 2641, 'mw-408fac395569e1e061fa88911435e9ac9883c83a3f4efd4b3446014428c09297', 'ae48131e7517', NULL, 0, 0),
(65, 69, 1, 2642, 'mw-099d4c533945ddf6b9208743a73bd2ff18d04184f8ed0670eb2a573e6243d233', 'ae48131e7517', NULL, 0, 0),
(66, 83, 1, 2643, 'mw-50130f51f8474ef503f15974e583d5eac65bd3c009e485169a002f4d1884f28f', 'ae48131e7517', NULL, 1, 0),
(67, 84, 1, 2644, 'mw-2c40a3b9d6e16ef859a652356c4d5735499711f73ed16e2759a93d5d4eb86259', 'ae48131e7517', NULL, 1, 0),
(68, 85, 1, 2645, 'mw-43849841ae2ebbb11cd22f7d4745a0202ec590ce8862bbfa41d9e793b3913e01', 'ae48131e7517', NULL, 0, 0),
(69, 86, 1, 2646, 'mw-8e850f55fed525d1aa9f56f1304d05392d1edb005e8e83b4a86a7cd33ecde8d5', 'ae48131e7517', NULL, 1, 0),
(70, 87, 1, 2647, 'mw-b794d561f8f27af40632eaf36fb7c45817c9e0802b5716741f36a8bf0568dfd3', 'ae48131e7517', NULL, 1, 0),
(71, 88, 1, 2648, 'mw-07f1251e10b6f850a66ee0be29d8f350af69d5b96ea49071a4771652de3bec8d', 'ae48131e7517', NULL, 1, 0),
(72, 89, 1, 2649, 'mw-02cbe96877d9ac76b3d11b5ac898a8c49bdd4f75387f266843dd30b682847908', 'ae48131e7517', NULL, 1, 0),
(73, 91, 1, 2650, 'mw-cc208a205688f7224794e488661e768faefdc963ee32db0b13bf554919b094cc', 'ae48131e7517', NULL, 0, 0),
(74, 90, 1, 2651, 'mw-721f1e9222fd1555a836167b9ba799b8e8bf32a18a77e13c2ed7a6d567d8a626', 'ae48131e7517', NULL, 0, 0),
(75, 92, 1, 2652, 'mw-4fc9a3d271d128434f2a5cb6ebf3d51a34c385105bf53594fb236799fcafc631', 'ae48131e7517', NULL, 0, 0),
(76, 94, 1, 2653, 'mw-51d6cda1c5d14d780dd8b651073fe517627bbe2056c8e5d0fc2f5c47ffe0587b', 'ae48131e7517', NULL, 1, 0),
(77, 95, 1, 2654, 'mw-072660a74de0e964ba08a37e146fe2f68990befd876e6b7da634f1d457c1d5bc', 'ae48131e7517', NULL, 0, 0),
(78, 98, 1, 2655, 'mw-8a5bab8fde952bb8e65657b06ac7a34ed529a0702e38eadb531bf5a904212a2a', 'ae48131e7517', NULL, 0, 0),
(79, 97, 1, 2656, 'mw-09d3d0496ddef87982f34ddae0ad47d18c42a110ed13446f001b05d8d640f832', 'ae48131e7517', NULL, 1, 0),
(80, 99, 1, 2657, 'mw-f7fb78e7145475e3cc2753ea3e962f489e7e2b0752d92799cd158760e8adc330', 'ae48131e7517', NULL, 1, 0),
(81, 100, 1, 2658, 'mw-05f7cd8f49e5afb1261dddd8141f7d5122d4959878c348c90f8af69289aae402', 'ae48131e7517', NULL, 0, 0),
(82, 101, 1, 2659, 'mw-0103d5f6d2dd2a965dc86454652c797f707fabccd48c7f2bf3141f885e57463a', 'ae48131e7517', NULL, 0, 0),
(83, 103, 1, 2660, 'mw-7be9902cf9c988df94867af5fb579bc7749182ba9ea927790271249bf6cb62c1', 'ae48131e7517', NULL, 0, 0),
(84, 104, 1, 2661, 'mw-2094ca3013868739469d51e34c93d596ef2fe0b5033ab7c3aabeeb1f4d852a6e', 'ae48131e7517', NULL, 0, 0),
(85, 105, 1, 2662, 'mw-cb0dd1e9e64671fa3872291c72bea0694b0a45c0878d841acbf4e57cfd617d71', 'ae48131e7517', NULL, 1, 0),
(86, 108, 1, 2663, 'mw-3135a299eb3f9816a4eb2b72c3db46ebc6ea5c1cf8c97e4c4d6fb65a0cb0318f', 'ae48131e7517', NULL, 1, 0),
(87, 110, 1, 2664, 'mw-dd88e93890a9d1c4ee23baf3b41eb6dc81cd5b2335059c34b0afe8d80251a0c3', 'ae48131e7517', NULL, 1, 0),
(88, 112, 1, 2665, 'mw-9d806c7b5cd92e17d9ed8a3fa38c8db443ffb145882c628ccb355631832846ed', 'ae48131e7517', NULL, 1, 0),
(89, 113, 1, 2666, 'mw-009d94d9df6ca5e4a6640ee19349ee94c16e7d3e81401d40a0b3a2646b46e4f8', 'ae48131e7517', NULL, 0, 0),
(90, 114, 1, 2667, 'mw-dd5d83472972ee032cd964c3e73035eae26f614a7b87679b7e2881600794ceca', 'ae48131e7517', NULL, 1, 0),
(91, 115, 1, 2668, 'mw-7c2ff00d948d0ebd83e314ad04de5b7ddc7734cf60f64cc31cae3a820343020d', 'ae48131e7517', NULL, 1, 0),
(92, 116, 1, 2669, 'mw-512b0afd84cb5088df041f77930d75a67553fb71d1f0ef35e5dc5d99ff5931a0', 'ae48131e7517', NULL, 1, 0),
(93, 111, 1, 2670, 'mw-90999fce6bad8445b1bfde0524b85d6a842fb4ca69d28ee30d5d9cb92420aa61', 'ae48131e7517', NULL, 0, 0),
(94, 119, 1, 2671, 'mw-fe26c0f927da281b6f36ebcf37756f889a64d50bb1c09b64298aec958022a0dd', 'ae48131e7517', NULL, 1, 0),
(95, 120, 1, 2672, 'mw-a19d19a8c49aa4e341026e621fdada8fa88acc6ebfa5a0e9f7775143145211ca', 'ae48131e7517', NULL, 1, 0),
(96, 122, 1, 2673, 'mw-3e23a1e71dba3ae866cdcec8cb5a8ab7ef86a3d568746acbc73da0132f6093fb', 'ae48131e7517', NULL, 1, 0),
(97, 124, 1, 2674, 'mw-dcc35f0e9f7b6f76716f195a208c26d233a96a62f744f639088771dfb4ad527f', 'ae48131e7517', NULL, 1, 0),
(98, 127, 1, 2675, 'mw-42d18786a8fabc816e9083a58f01d18132a966665199b1ad80b87ab111b37ffa', 'ae48131e7517', NULL, 1, 0),
(99, 128, 1, 2676, 'mw-a524b02849fd6273d6f8c77195a2dcd838c92791983f4034ff43fec9f2c91973', 'ae48131e7517', NULL, 1, 0),
(100, 129, 1, 2677, 'mw-8a503d0fdaa298bdea8f37dfb1af60f4fe0b44f418bddea355120f6960a41710', 'ae48131e7517', NULL, 0, 0),
(101, 131, 1, 2678, 'mw-73c3741150544dde1b6dbe6942d1ad01ad547c633dd1fba6084a4c7a4c54e35d', 'ae48131e7517', NULL, 1, 0),
(102, 132, 1, 2679, 'mw-1fc7eb889cee76bdc9b2bcb590e50e31dbc476499e14a46e82f6ff76523ed18f', 'ae48131e7517', NULL, 1, 0),
(103, 133, 1, 2680, 'mw-00e99fe43d9b432f0e2fe7980153dffb8408422142c119d52d62fc90e022bd64', 'ae48131e7517', NULL, 1, 0),
(104, 135, 1, 2681, 'mw-dd048422ee00d646db7fc419bd3445a2228fe657b7dcdbfb12e1fdb345353bd6', 'ae48131e7517', NULL, 0, 0),
(105, 137, 1, 2682, 'mw-2f50ec851cfea839ffed847db3d2d34bf53888442c4852b4f993630b223196d8', 'ae48131e7517', NULL, 0, 0),
(106, 138, 1, 2683, 'mw-c2bebbcaba43ed4ff811792b4eab631c9df7fafa46256161d863526c19c90a62', 'ae48131e7517', NULL, 0, 0),
(107, 125, 1, 2684, 'mw-82da844121035c68d9e207a0456c5fcc2c4646cf8c613873c05d7d5467248d38', 'ae48131e7517', NULL, 1, 0),
(108, 125, 1, 2685, 'mw-82da844121035c68d9e207a0456c5fcc2c4646cf8c613873c05d7d5467248d38', 'ae48131e7517', NULL, 1, 0),
(109, 139, 1, 2686, 'mw-d1203329679cd1666363adb462e6622da43b76e91d054d099bab37372fb1812f', 'ae48131e7517', NULL, 0, 0),
(110, 140, 1, 2687, 'mw-7ba91cf091981cf371f5278977b3db90673225b35c9e29fec4ab09ed252e86ab', 'ae48131e7517', NULL, 1, 0),
(111, 141, 1, 2688, 'mw-e19138755c1ad8745f450f5b15b885c030133795f599626842371a7ffec84727', 'ae48131e7517', NULL, 0, 0),
(112, 142, 1, 2689, 'mw-8bae82b3b16124a0033426de773820074f4cc77c2b91362afc7bab9c1eea9fc3', 'ae48131e7517', 5, 0, 0),
(113, 143, 1, 2690, 'mw-f6c233935ed30c735600206a2dde4251e025400a406026da3df3cf08e7b94c52', 'ae48131e7517', 5, 0, 0),
(114, 144, 1, 2691, 'mw-ae82a56e13646f438343d8c622ec667ffcba88fc3b641af06ec7c3c1ec79fd77', 'ae48131e7517', 5, 0, 0),
(115, 146, 1, 2692, 'mw-3aa4b013797655db3efbf01f5ec2b0aa53a21164abaa7c430bda2b0a1eeb6d4d', 'ae48131e7517', 5, 0, 0),
(116, 147, 1, 2693, 'mw-ce512fb05c54883f5ff6dfbfc21dd4083007a69a4fee11158e1e0bf986745816', 'ae48131e7517', 5, 1, 0),
(117, 148, 1, 2694, 'mw-170fece6dab9bc287b29707efb836dd10cfd07943cf8aac167536acbb44cac7b', 'ae48131e7517', 5, 0, 0),
(118, 150, 1, 2695, 'mw-80aca358aefaddee84ddb9d80c6e7fe6fc1f2a2dbbcc98da99785c265440f770', 'ae48131e7517', 5, 0, 0),
(119, 151, 1, 2696, 'mw-8cf45b924242e16d30746024565338ddfddbe530e5999950010a6fd77fdac8f6', 'ae48131e7517', 5, 0, 0),
(120, 151, 1, 2697, 'mw-8cf45b924242e16d30746024565338ddfddbe530e5999950010a6fd77fdac8f6', 'ae48131e7517', 5, 0, 0),
(121, 152, 1, 2698, 'mw-50236aa56629e81228b8a0926a8e91cd0196ce1eccc34a0d82e947296173d62e', 'ae48131e7517', 5, 1, 0),
(122, 153, 1, 2699, 'mw-7f47cf68f189b0b464dab135c79cffe3db4eb527db03e187a8154969d294552c', 'ae48131e7517', 5, 0, 0),
(123, 154, 1, 2700, 'mw-9e33d2c26bcae9cf841b14b943b972c48b829eabba3a31f3b8c893cc672dfea4', 'ae48131e7517', 5, 0, 0),
(124, 155, 1, 2701, 'mw-4bb4c56eff61e7d8d0128f2d8396f2de1a467548f6f17c87587a26428f77cac6', 'ae48131e7517', 5, 0, 0),
(125, 156, 1, 2702, 'mw-a4ade79f006ba7dd88d87081ef67e7ec756e7216f54e421e4558d3ad7e070e68', 'ae48131e7517', 5, 0, 0),
(126, 156, 1, 2703, 'mw-a4ade79f006ba7dd88d87081ef67e7ec756e7216f54e421e4558d3ad7e070e68', 'ae48131e7517', 5, 0, 0),
(127, 158, 1, 2704, 'mw-bf024bcea68d58b9e3dba1b68a0f28d528c3c8bae73c129356fdf26e26296dd5', 'ae48131e7517', 5, 1, 0),
(128, 159, 1, 2705, 'mw-dfac1c70d9c37a304e7032c2c54aaad8d3d588b71f16bd527d23b34b2d1906c2', 'ae48131e7517', 5, 0, 0),
(129, 161, 1, 2706, 'mw-f607f98417810059ada5bb27ba4d2c42a627ecb1bbb8248af32ca9adcc4ec8b0', 'ae48131e7517', 5, 1, 0),
(130, 163, 1, 2707, 'mw-f7adf490011884000532a83006a022fffa58d24c2558822920163cdac38c2df3', 'ae48131e7517', 5, 0, 0),
(131, 164, 1, 2708, 'mw-d692447321d958a571546064e4a81c3217577564e9d1e68c8f7e27d7757736a7', 'ae48131e7517', 5, 1, 0),
(132, 165, 1, 2709, 'mw-9eb2e747c388868368cdde524e8b50286466d4c7adb1e1ee7083be83bd5a4019', 'ae48131e7517', 5, 0, 0),
(133, 166, 1, 2710, 'mw-2b76058b2dc0a5999d5b3c5142414ec75106c95fb3890e54b8348c91b372f621', 'ae48131e7517', 5, 1, 0),
(134, 167, 1, 2711, 'mw-906af5c17dcaa8a6e65957c76f7b0013e9765e6e87eff06dc6f7ae90d5dd356c', 'ae48131e7517', 5, 0, 0),
(135, 167, 1, 2712, 'mw-906af5c17dcaa8a6e65957c76f7b0013e9765e6e87eff06dc6f7ae90d5dd356c', 'ae48131e7517', 5, 0, 0),
(136, 169, 1, 2713, 'mw-c351885c4b3c2e39747822afb40054b54f269a39f18a9dd6261409b90640fd41', 'ae48131e7517', 5, 0, 0),
(137, 170, 1, 2714, 'mw-50d5c051268290889a2cadfe11d3b5d37b41a7e858ac9b94751c539ff2d76fa2', 'ae48131e7517', 5, 0, 0),
(138, 172, 1, 2715, 'mw-6940ed4e8e6be3d0fb8a45fd92811aa63bbfe755f120958ff9590a58762c14f3', 'ae48131e7517', 5, 0, 0),
(139, 173, 1, 2716, 'mw-5aeb8a190c1b3a8b3b94d3cc5320e624890118e4fd4f67f573198b6a4d1193e9', 'ae48131e7517', 5, 0, 0),
(140, 174, 1, 2717, 'mw-43b72c1064d811e4d70f5c6249f0972249608f1f01580cdcffd6543e3769d582', 'ae48131e7517', 5, 1, 0),
(141, 175, 1, 2718, 'mw-558960966c2331aac0454e56ffbe8fadc21d4ce375c9af16d2b49a15b4e878ad', 'ae48131e7517', 5, 0, 0),
(142, 178, 1, 2719, 'mw-faa9bf1733c761bcdc63f6e1852a9139f86eb7b308d42899cd20e2db3566b312', 'ae48131e7517', 5, 0, 0),
(143, 179, 1, 2720, 'mw-8c36e5e868e192e3958b6748c763e44ccbace0f5a5572c7dbc24cccb16f721c2', 'ae48131e7517', 5, 1, 0),
(144, 180, 1, 2721, 'mw-02bcf52d3d06e982b83f68a7959f07ea49f3194d98d7d406bb3797c0bdf752f0', 'ae48131e7517', 5, 0, 0),
(145, 180, 1, 2722, 'mw-02bcf52d3d06e982b83f68a7959f07ea49f3194d98d7d406bb3797c0bdf752f0', 'ae48131e7517', 5, 0, 0),
(146, 181, 1, 2723, 'mw-5c64df71947840dda7f9345ed8d297a3a7ebe4a8c0034b8c3474d572f33bedee', 'ae48131e7517', 5, 1, 0),
(147, 183, 1, 2724, 'mw-e5f07e676b25e7367a83cafbb1f4458e44eed150c506867cc1bfb986d9555795', 'ae48131e7517', 5, 0, 0),
(148, 183, 1, 2725, 'mw-e5f07e676b25e7367a83cafbb1f4458e44eed150c506867cc1bfb986d9555795', 'ae48131e7517', 5, 0, 0),
(149, 185, 1, 2726, 'mw-2c54f6b6a78b4ef87a1e9da5050cd8badc5df65a9a4a0d1dc6d977a7a754c7a8', 'ae48131e7517', 5, 1, 0),
(150, 188, 1, 2727, 'mw-0cf472b2007c6b5fa613dcd02a5aa13ee58fbda45b4b2ae32582587fb22f4ab8', 'ae48131e7517', 5, 1, 0),
(151, 189, 1, 2728, 'mw-36c43c94529a33d9debc5293a53fd69452197e0744392b0cc3f926bcb7024494', 'ae48131e7517', 5, 0, 0),
(152, 190, 1, 2729, 'mw-ead4a6f86b1c67794220fda0166e2ab41e662667dff03551cb71f88f3c061fa4', 'ae48131e7517', 5, 1, 0),
(153, 191, 1, 2730, 'mw-26658279c6ddab812689dd709633f1444dbf4c1846e90ab844af0e7327dd2016', 'ae48131e7517', 5, 0, 0),
(154, 192, 1, 2731, 'mw-a8fc4513bdf81ecabf1811e5ec54c15b43b13cb473742339172da132d555cb18', 'ae48131e7517', 5, 1, 0),
(155, 193, 1, 2732, 'mw-dc5c187cc3d2a1b5dd40052b97ca772d40a0e467963ec2d93db86b2559168636', 'ae48131e7517', 5, 0, 0),
(156, 195, 1, 2733, 'mw-a60e841769e569ab78c844a5256f843df0da06945a7cfda116c582b66b356d40', 'ae48131e7517', 5, 0, 0),
(157, 196, 1, 2734, 'mw-66d502c0f7b4720f49150ef991396653b7426143c11163fca4aadef45c72127f', 'ae48131e7517', 5, 1, 0),
(158, 197, 1, 2735, 'mw-0d07e16e697edadead747bf48cb657559a3906b0417fd58737459da8604ba750', 'ae48131e7517', 5, 0, 0),
(159, 198, 1, 2736, 'mw-64471f03234ad1cbdce2b26d1ec00aae9bec4bff65aec5fb19239e93164d737b', 'ae48131e7517', 5, 1, 0),
(160, 199, 1, 2737, 'mw-aca9a82bbce31480a674f4db5537b0a06543ce033276e1fc0c2bc4b5d74303d1', 'ae48131e7517', 5, 1, 0),
(161, 202, 1, 2738, 'mw-7c4ec1d56984e541b73c1212c9fb2892d35c67d1ed80c645dc20acc4933a7a29', 'ae48131e7517', 5, 1, 0),
(162, 203, 1, 2739, 'mw-2aba59f39fe40e11b4fde6d5208079acae614100e9b82ffdca396e458e61213a', 'ae48131e7517', 5, 0, 0),
(163, 204, 1, 2740, 'mw-e0d6b5f04ebd0678d5a9a473ca92f536c0975be12642a04949d81ec5e5b58424', 'ae48131e7517', 5, 0, 0),
(164, 205, 1, 2741, 'mw-d2a62cefdf92ef86a0d6a2f835c345d8655dd8b31b757e4062fbfee70c649ae8', 'ae48131e7517', 5, 1, 0),
(165, 206, 1, 2742, 'mw-96fdc15a593cdc4b0d1c0427d0b5ed4f98f672e1deaa08236ca0bb5be474b88b', 'ae48131e7517', 5, 1, 0),
(166, 207, 1, 2743, 'mw-b7afa7fd3a3a9c7f4771ae5fd207b3d2ae91042a9a862d303404433c82891e4f', 'ae48131e7517', 5, 1, 0),
(167, 19, 1, 2744, 'mw-689b585a2962cf1610d03f9f47e993d90d48a7659d696951482055fa7197cffb', 'ae48131e7517', 5, 0, 0),
(168, 209, 1, 2745, 'mw-0b1a442647077b3f6e26bf87f5e7fa08989396d2b234a39ebc07f0f49f95cf08', 'ae48131e7517', 5, 1, 0),
(169, 208, 1, 2746, 'mw-92951c89482a14a2c218220e01faa11571e6c4e2cb06531e89f306506899b129', 'ae48131e7517', 5, 0, 0),
(170, 210, 1, 2747, 'mw-9604d26789675929a6e3387eb9e2e341574d926a5fde0d2515206b4399bc40fa', 'ae48131e7517', 5, 0, 0),
(171, 212, 1, 2748, 'mw-9c242f4fdc755e53e7ade21b10db445f9b2118abadf2127468b88b41e1413083', 'ae48131e7517', 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Teams`
--

CREATE TABLE IF NOT EXISTS `Teams` (
  `TeamId` int(11) NOT NULL AUTO_INCREMENT,
  `TeamName` varchar(30) DEFAULT NULL,
  UNIQUE KEY `TeamId` (`TeamId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `Teams`
--

INSERT INTO `Teams` (`TeamId`, `TeamName`) VALUES
(30, 'Manchester City'),
(43, 'Bolton Wanderers');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `microworkersId` varchar(300) NOT NULL,
  `userRating` float NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UID`, `microworkersId`, `userRating`) VALUES
(2, '6f937bb9', 5),
(3, '2212a59d', 5),
(4, '1d8b7fdc', 5),
(5, 'aedd3017', 5),
(6, 'ed57bdd7', 5),
(7, 'cee6710e', 5),
(8, '69c66858', 5),
(9, 'c4079d55', 5),
(10, 'f2adeadc', 5),
(11, 'b6b1c2fd', 5),
(12, '726b4cb7', 5),
(13, '18bb80be', 5),
(14, '235a16f9', 5),
(15, '6b9b50df', 5),
(16, 'd9fc3a70', 5),
(17, '19ef7638', 5),
(18, '92a58d3f', 5),
(19, 'a061f5ed', 5),
(20, '18bb80b', 5),
(21, '7233d1eb', 5),
(22, 'a25d3504', 5),
(23, '2e31a2fa', 5),
(24, '9cbf33dc', 5),
(25, '0ebcfbf5', 5),
(26, 'b87b6eaa', 5),
(27, '2f77cc21', 5),
(28, '7283d1f9', 5),
(29, '5b29a570', 5),
(30, 'fe5a5cca', 5),
(31, 'b9a02911', 5),
(32, 'ececde4e', 5),
(33, '82451154', 5),
(34, '66f83207', 5),
(35, '64e15840', 5),
(36, '0f6dc36d', 5),
(37, 'df93ed02', 5),
(38, '8882e362', 5),
(39, '1d290e6c', 5),
(40, '89d24112', 5),
(41, '60715a1e', 5),
(42, '69c1f293', 5),
(43, 'b166fabf', 5),
(44, '99d01ded', 5),
(45, 'f51993c3', 5),
(46, '51966914', 5),
(47, '10b1fdb7', 5),
(48, '3c432626', 5),
(49, '19449e4c', 5),
(50, '7285f9c9', 5),
(51, 'c3f5e65f', 5),
(52, 'e3f7e1ee', 5),
(53, '1c390b35', 5),
(54, 'a305dc2a', 5),
(55, 'f1b5361b', 5),
(56, '53cc5669', 5),
(57, '24a43fc1', 5),
(58, '54db1aaf', 5),
(59, 'e0b3757e', 5),
(60, '5cd6a293', 5),
(61, 'baf52127', 5),
(62, '96d47838', 5),
(63, 'c3c82512', 5),
(64, '2a308850', 5),
(65, 'cbe887a5', 5),
(66, '2156bb8b', 5),
(67, '8a50e1cf', 5),
(68, 'df05fdcc', 5),
(69, '4e5af56c', 5),
(70, '911e79d7', 5),
(71, 'ff0075a9', 5),
(72, 'd44945d1', 5),
(73, '20d88dd1', 5),
(74, '36320019', 5),
(75, 'ea326360', 5),
(76, 'f60b8e36', 5),
(77, '4a678d82', 5),
(78, 'be66c757', 5),
(79, '33b4cb75', 5),
(80, 'd25f5d6e', 5),
(81, '3dfe4e42', 5),
(82, '48646967', 5),
(83, '6e2365d3', 5),
(84, 'd0df97a5', 5),
(85, '34890804', 5),
(86, '12a3493a', 5),
(87, 'd940fd5c', 5),
(88, '74006631', 5),
(89, 'f86d54b3', 5),
(90, 'd4be310b', 5),
(91, '3bbf7570', 5),
(92, '6a1ad86c', 5),
(93, '869643a3', 5),
(94, '31ca2386', 5),
(95, '7f18ca5a', 5),
(96, '918cfa19', 5),
(97, '6348d765', 5),
(98, '80858f4c', 5),
(99, 'a1260d03', 5),
(100, 'f0bfa83c', 5),
(101, '5356b597', 5),
(102, 'f5021225', 5),
(103, '0247282c', 5),
(104, '552c441d', 5),
(105, '15607f8b', 5),
(106, '32e025e4', 5),
(107, '625be592', 5),
(108, '4d2a2af8', 5),
(109, 'ac3023e9', 5),
(110, 'edaade7d', 5),
(111, '8649496a', 5),
(112, '2a28b293', 5),
(113, '60c4b302', 5),
(114, '6a8b52fc', 5),
(115, 'c0898ff5', 5),
(116, 'e890bc10', 5),
(117, 'cc986479', 5),
(118, '3ba72174', 5),
(119, '3e3f16be', 5),
(120, 'e07403a0', 5),
(121, '1be642bf', 5),
(122, 'ac023f3b', 5),
(123, '701b824d', 5),
(124, '3160af50', 5),
(125, 'add67477', 5),
(126, 'f73a9567', 5),
(127, '9277a2aa', 5),
(128, 'eab7e692', 5),
(129, '7d90da0b', 5),
(130, 'e9f8a22c', 5),
(131, '7cffef21', 5),
(132, '2589c6f2', 5),
(133, '32a29ad1', 5),
(134, '1', 5),
(135, '4c630427', 5),
(136, 'd9da20fb', 5),
(137, '7e8d1cc6', 5),
(138, '7e8d1', 5),
(139, '9a3920dc', 5),
(140, '4892dd7d', 5),
(141, 'f057eb49', 5),
(142, '1503008c', 5),
(143, 'c97c506d', 5),
(144, '78f9b194', 5),
(145, 'c62ee599', 5),
(146, 'e44cf03e', 5),
(147, 'f1e62f9a', 5),
(148, 'dc27ec75', 5),
(149, '6f53869f', 5),
(150, 'bc4b58fe', 5),
(151, '8ff7c8d9', 5),
(152, '62ef7a0e', 5),
(153, 'a318ce0d', 5),
(154, 'ef3a08fe', 5),
(155, '927966d3', 5),
(156, '7fe1aab7', 5),
(157, 'e4e60c61', 5),
(158, '1b1820ec', 5),
(159, 'c4d75abe', 5),
(160, 'dd73e2ab', 5),
(161, '55ef595c', 5),
(162, '0c3df622', 5),
(163, '38658117', 5),
(164, '3c605499', 5),
(165, 'a5f39101', 5),
(166, 'd9795ef7', 5),
(167, '5b8deffa', 5),
(168, 'ce7b0187', 5),
(169, 'f3d113c3', 5),
(170, '849605fc', 5),
(171, '990e4956', 5),
(172, '035720bc', 5),
(173, '035720b', 5),
(174, 'ed5f50a1', 5),
(175, 'f07eb2d4', 5),
(176, '8d3b6d16', 5),
(177, '8141c660', 5),
(178, '95616b07', 5),
(179, 'eba0c5c8', 5),
(180, 'c14e2eb6', 5),
(181, '2222e42e', 5),
(182, '90ea33a5', 5),
(183, '35646b15', 5),
(184, '8248839c', 5),
(185, '0a603a55', 5),
(186, '62da48ff', 5),
(187, '8bacf5c7', 5),
(188, 'c3f0d335', 5),
(189, 'ac60b664', 5),
(190, 'cee900b5', 5),
(191, '8f9899c0', 5),
(192, '5f677c22', 5),
(193, 'cff2ece8', 5),
(194, '1ecbccd5', 5),
(195, 'f6e85ec3', 5),
(196, '86d9606f', 5),
(197, '78a99cef', 5),
(198, '8b87544c', 5),
(199, '8c061dc7', 5),
(200, '666e7089', 5),
(201, '79474ec3', 5),
(202, 'a1126e67', 5),
(203, '6816a0e7', 5),
(204, '8d6a1b7e', 5),
(205, 'bdf64dd2', 5),
(206, '8059c782', 5),
(207, '6a6b979c', 5),
(208, 'd4413808', 5),
(209, '0ff51833', 5),
(210, 'c6525423', 5),
(211, 'd9718789', 5),
(212, 'c7e3cf75', 5),
(213, '30c13781', 5),
(214, 'c78ced1e', 5),
(215, '0a07c906', 5),
(216, '030e55c2', 5),
(217, '85d4c909', 5),
(218, '217ef640', 5);

-- --------------------------------------------------------

--
-- Table structure for table `VideoInformations`
--

CREATE TABLE IF NOT EXISTS `VideoInformations` (
  `videoId` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(200) NOT NULL,
  `homeTeam` int(11) NOT NULL,
  `awayTeam` int(11) NOT NULL,
  `homeColor` varchar(30) DEFAULT NULL,
  `awayColor` varchar(30) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `sequenceLength` int(11) NOT NULL,
  `sequenceEnd` int(11) NOT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`videoId`),
  KEY `homeTeam` (`homeTeam`),
  KEY `awayTeam` (`awayTeam`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `VideoInformations`
--

INSERT INTO `VideoInformations` (`videoId`, `link`, `homeTeam`, `awayTeam`, `homeColor`, `awayColor`, `sequence`, `sequenceLength`, `sequenceEnd`, `active`) VALUES
(1, 'videos/medium.mp4', 30, 43, 'white', 'red', 2751, 5, 7000, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Event`
--
ALTER TABLE `Event`
  ADD CONSTRAINT `Event_ibfk_1` FOREIGN KEY (`TaskId`) REFERENCES `Task` (`TaskId`),
  ADD CONSTRAINT `Event_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `EventNames` (`EventNamesId`);

--
-- Constraints for table `Task`
--
ALTER TABLE `Task`
  ADD CONSTRAINT `Task_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `Users` (`UID`),
  ADD CONSTRAINT `Task_ibfk_2` FOREIGN KEY (`VideoId`) REFERENCES `VideoInformations` (`videoId`);

--
-- Constraints for table `VideoInformations`
--
ALTER TABLE `VideoInformations`
  ADD CONSTRAINT `VideoInformations_ibfk_1` FOREIGN KEY (`homeTeam`) REFERENCES `Teams` (`TeamId`),
  ADD CONSTRAINT `VideoInformations_ibfk_2` FOREIGN KEY (`awayTeam`) REFERENCES `Teams` (`TeamId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
