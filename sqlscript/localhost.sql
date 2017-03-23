-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2012 at 08:01 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chat`
--
CREATE DATABASE `chat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chat`;

-- --------------------------------------------------------

--
-- Table structure for table `redotable`
--

CREATE TABLE IF NOT EXISTS `redotable` (
  `name` varchar(20) DEFAULT NULL,
  `data` mediumtext,
  `shape` varchar(100) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT NULL,
  `sessionid` varchar(20) DEFAULT NULL,
  `dataid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`dataid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `redotable`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(20) DEFAULT NULL,
  `sessionid` varchar(20) DEFAULT NULL,
  `lastacttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `sessionid`, `lastacttime`) VALUES
('jkdlfjl', '23', '2012-05-01 23:22:38'),
('dfj', '23', '2012-05-01 23:22:15');
