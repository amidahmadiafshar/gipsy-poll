-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2013 at 01:56 PM
-- Server version: 5.5.32-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wtoolsir_cp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pro_admin` int(1) NOT NULL DEFAULT '0',
  `super_admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`, `fname`, `lname`, `pro_admin`, `super_admin`) VALUES
(1, 'admin', 'info@wtools.ir', '4e9252286bd50df532e3506b71c21a7c', 'Admin', 'Administrator', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int(1) NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poll_id` int(255) NOT NULL,
  `votes` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `poll_id` int(255) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `multi_select` int(1) NOT NULL DEFAULT '0',
  `view_result` int(1) NOT NULL DEFAULT '0',
  `views` int(255) NOT NULL DEFAULT '0',
  `votes` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vote_id` int(255) NOT NULL AUTO_INCREMENT,
  `vote_note` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_id` int(1) NOT NULL,
  `answer_id` int(1) NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(255) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
