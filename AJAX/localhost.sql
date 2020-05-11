-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2020 at 08:33 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kailash`
--
CREATE DATABASE `kailash` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `kailash`;

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE IF NOT EXISTS `user_detail` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(245) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `message` blob NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`auto_id`, `name`, `email`, `mobile`, `message`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Kailash', 'Kailashkumar2013@gmail.com', '9941656985', 0x4d6573736167652063616e20626520656e74657265642068657265, 1, '2020-05-12 01:58:31', '2020-05-12 01:59:41'),
(2, 'Ajay', 'ajay@gmail.com', '9382329174', 0x616e797468696e6720636f756c642062652068657265, 1, '2020-05-12 02:00:16', '0000-00-00 00:00:00');
