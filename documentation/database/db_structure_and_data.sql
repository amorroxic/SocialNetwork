-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2012 at 12:41 PM
-- Server version: 5.5.9
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webres`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `age` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` VALUES(1, 'Paul', 'Crowe', '28', 1, 'paul-crowe');
INSERT INTO `accounts` VALUES(2, 'Rob', 'Fitz', '23', 1, 'rob-fitz');
INSERT INTO `accounts` VALUES(3, 'Ben', 'O''Carolan', '', 1, 'ben-o-carolan');
INSERT INTO `accounts` VALUES(4, 'Victor', '', '28', 1, 'victor');
INSERT INTO `accounts` VALUES(5, 'Peter', 'Mac', '29', 1, 'peter-mac');
INSERT INTO `accounts` VALUES(6, 'John', 'Barry', '18', 1, 'john-barry');
INSERT INTO `accounts` VALUES(7, 'Sarah', 'Lane', '30', 2, 'sarah-lane');
INSERT INTO `accounts` VALUES(8, 'Susan', 'Downe', '28', 2, 'susan-downe');
INSERT INTO `accounts` VALUES(9, 'Jack', 'Stam', '28', 1, 'jack-stam');
INSERT INTO `accounts` VALUES(10, 'Amy', 'Lane', '24', 2, 'amy-lane');
INSERT INTO `accounts` VALUES(11, 'Sandra', 'Phelan', '28', 2, 'sandra-phelan');
INSERT INTO `accounts` VALUES(12, 'Laura', 'Murphy', '33', 2, 'laura-murphy');
INSERT INTO `accounts` VALUES(13, 'Lisa', 'Daly', '28', 2, 'lisa-daly');
INSERT INTO `accounts` VALUES(14, 'Mark', 'Johnson', '28', 1, 'mark-johnson');
INSERT INTO `accounts` VALUES(15, 'Seamus', 'Crowe', '24', 1, 'seamus-crowe');
INSERT INTO `accounts` VALUES(16, 'Daren', 'Slater', '28', 1, 'daren-slater');
INSERT INTO `accounts` VALUES(17, 'Dara', 'Zoltan', '48', 1, 'dara-zoltan');
INSERT INTO `accounts` VALUES(18, 'Marie', 'D', '28', 2, 'marie-d');
INSERT INTO `accounts` VALUES(19, 'Catriona', 'Long', '28', 2, 'catriona-long');
INSERT INTO `accounts` VALUES(20, 'Katy', 'Couch', '28', 2, 'katy-couch');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_connections`
--

CREATE TABLE `accounts_connections` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `account_id` mediumint(9) NOT NULL,
  `friend_id` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=52 ;

--
-- Dumping data for table `accounts_connections`
--

INSERT INTO `accounts_connections` VALUES(1, 1, 2);
INSERT INTO `accounts_connections` VALUES(2, 2, 1);
INSERT INTO `accounts_connections` VALUES(3, 2, 3);
INSERT INTO `accounts_connections` VALUES(4, 3, 2);
INSERT INTO `accounts_connections` VALUES(5, 3, 4);
INSERT INTO `accounts_connections` VALUES(6, 3, 5);
INSERT INTO `accounts_connections` VALUES(7, 3, 7);
INSERT INTO `accounts_connections` VALUES(8, 4, 3);
INSERT INTO `accounts_connections` VALUES(9, 5, 3);
INSERT INTO `accounts_connections` VALUES(10, 5, 6);
INSERT INTO `accounts_connections` VALUES(11, 5, 11);
INSERT INTO `accounts_connections` VALUES(12, 5, 10);
INSERT INTO `accounts_connections` VALUES(13, 5, 7);
INSERT INTO `accounts_connections` VALUES(14, 6, 5);
INSERT INTO `accounts_connections` VALUES(15, 7, 3);
INSERT INTO `accounts_connections` VALUES(16, 7, 5);
INSERT INTO `accounts_connections` VALUES(17, 7, 20);
INSERT INTO `accounts_connections` VALUES(18, 7, 12);
INSERT INTO `accounts_connections` VALUES(19, 7, 8);
INSERT INTO `accounts_connections` VALUES(20, 8, 7);
INSERT INTO `accounts_connections` VALUES(21, 9, 12);
INSERT INTO `accounts_connections` VALUES(22, 10, 5);
INSERT INTO `accounts_connections` VALUES(23, 10, 11);
INSERT INTO `accounts_connections` VALUES(24, 11, 5);
INSERT INTO `accounts_connections` VALUES(25, 11, 10);
INSERT INTO `accounts_connections` VALUES(26, 11, 19);
INSERT INTO `accounts_connections` VALUES(27, 11, 20);
INSERT INTO `accounts_connections` VALUES(28, 12, 7);
INSERT INTO `accounts_connections` VALUES(29, 12, 9);
INSERT INTO `accounts_connections` VALUES(30, 12, 13);
INSERT INTO `accounts_connections` VALUES(31, 12, 20);
INSERT INTO `accounts_connections` VALUES(32, 13, 12);
INSERT INTO `accounts_connections` VALUES(33, 13, 14);
INSERT INTO `accounts_connections` VALUES(34, 13, 20);
INSERT INTO `accounts_connections` VALUES(35, 14, 13);
INSERT INTO `accounts_connections` VALUES(36, 14, 15);
INSERT INTO `accounts_connections` VALUES(37, 15, 14);
INSERT INTO `accounts_connections` VALUES(38, 16, 18);
INSERT INTO `accounts_connections` VALUES(39, 16, 20);
INSERT INTO `accounts_connections` VALUES(40, 17, 18);
INSERT INTO `accounts_connections` VALUES(41, 17, 20);
INSERT INTO `accounts_connections` VALUES(42, 18, 17);
INSERT INTO `accounts_connections` VALUES(43, 19, 11);
INSERT INTO `accounts_connections` VALUES(44, 19, 20);
INSERT INTO `accounts_connections` VALUES(45, 20, 7);
INSERT INTO `accounts_connections` VALUES(46, 20, 11);
INSERT INTO `accounts_connections` VALUES(47, 20, 12);
INSERT INTO `accounts_connections` VALUES(48, 20, 13);
INSERT INTO `accounts_connections` VALUES(49, 20, 16);
INSERT INTO `accounts_connections` VALUES(50, 20, 17);
INSERT INTO `accounts_connections` VALUES(51, 20, 19);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `rating` double NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` VALUES(1, 'Dublin', 73.3333333333);
INSERT INTO `cities` VALUES(2, 'New York', 98);
INSERT INTO `cities` VALUES(3, 'Paris', 85);
INSERT INTO `cities` VALUES(4, 'Madrid', 77.5);
INSERT INTO `cities` VALUES(5, 'London', 83);
INSERT INTO `cities` VALUES(6, 'Barcelona', 87.5);
INSERT INTO `cities` VALUES(7, 'Moscow', 53.8888888889);
INSERT INTO `cities` VALUES(8, 'Chicago', 60);

-- --------------------------------------------------------

--
-- Table structure for table `cities_ratings`
--

CREATE TABLE `cities_ratings` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `account_id` mediumint(9) NOT NULL,
  `city_id` mediumint(9) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=51 ;

--
-- Dumping data for table `cities_ratings`
--

INSERT INTO `cities_ratings` VALUES(1, 1, 1, 80);
INSERT INTO `cities_ratings` VALUES(2, 2, 1, 40);
INSERT INTO `cities_ratings` VALUES(3, 5, 1, 60);
INSERT INTO `cities_ratings` VALUES(4, 8, 1, 80);
INSERT INTO `cities_ratings` VALUES(5, 11, 1, 75);
INSERT INTO `cities_ratings` VALUES(6, 12, 1, 75);
INSERT INTO `cities_ratings` VALUES(7, 13, 1, 80);
INSERT INTO `cities_ratings` VALUES(8, 14, 1, 80);
INSERT INTO `cities_ratings` VALUES(9, 20, 1, 90);
INSERT INTO `cities_ratings` VALUES(10, 1, 2, 100);
INSERT INTO `cities_ratings` VALUES(11, 2, 2, 100);
INSERT INTO `cities_ratings` VALUES(12, 5, 2, 100);
INSERT INTO `cities_ratings` VALUES(13, 7, 2, 100);
INSERT INTO `cities_ratings` VALUES(14, 14, 2, 90);
INSERT INTO `cities_ratings` VALUES(15, 1, 3, 95);
INSERT INTO `cities_ratings` VALUES(16, 2, 3, 65);
INSERT INTO `cities_ratings` VALUES(17, 3, 3, 90);
INSERT INTO `cities_ratings` VALUES(18, 4, 3, 80);
INSERT INTO `cities_ratings` VALUES(19, 5, 3, 75);
INSERT INTO `cities_ratings` VALUES(20, 10, 3, 95);
INSERT INTO `cities_ratings` VALUES(21, 16, 3, 95);
INSERT INTO `cities_ratings` VALUES(22, 1, 4, 100);
INSERT INTO `cities_ratings` VALUES(23, 2, 4, 90);
INSERT INTO `cities_ratings` VALUES(24, 3, 4, 40);
INSERT INTO `cities_ratings` VALUES(25, 4, 4, 80);
INSERT INTO `cities_ratings` VALUES(26, 1, 5, 80);
INSERT INTO `cities_ratings` VALUES(27, 3, 5, 85);
INSERT INTO `cities_ratings` VALUES(28, 4, 5, 80);
INSERT INTO `cities_ratings` VALUES(29, 6, 5, 80);
INSERT INTO `cities_ratings` VALUES(30, 20, 5, 90);
INSERT INTO `cities_ratings` VALUES(31, 1, 6, 100);
INSERT INTO `cities_ratings` VALUES(32, 3, 6, 90);
INSERT INTO `cities_ratings` VALUES(33, 4, 6, 80);
INSERT INTO `cities_ratings` VALUES(34, 10, 6, 80);
INSERT INTO `cities_ratings` VALUES(35, 1, 7, 20);
INSERT INTO `cities_ratings` VALUES(36, 3, 7, 80);
INSERT INTO `cities_ratings` VALUES(37, 4, 7, 40);
INSERT INTO `cities_ratings` VALUES(38, 10, 7, 100);
INSERT INTO `cities_ratings` VALUES(39, 11, 7, 70);
INSERT INTO `cities_ratings` VALUES(40, 12, 7, 75);
INSERT INTO `cities_ratings` VALUES(41, 14, 7, 50);
INSERT INTO `cities_ratings` VALUES(42, 16, 7, 20);
INSERT INTO `cities_ratings` VALUES(43, 17, 7, 30);
INSERT INTO `cities_ratings` VALUES(44, 7, 8, 70);
INSERT INTO `cities_ratings` VALUES(45, 8, 8, 70);
INSERT INTO `cities_ratings` VALUES(46, 9, 8, 70);
INSERT INTO `cities_ratings` VALUES(47, 11, 8, 60);
INSERT INTO `cities_ratings` VALUES(48, 16, 8, 80);
INSERT INTO `cities_ratings` VALUES(49, 18, 8, 30);
INSERT INTO `cities_ratings` VALUES(50, 19, 8, 40);
