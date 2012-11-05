-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2012 at 12:33 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `rating` double NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
