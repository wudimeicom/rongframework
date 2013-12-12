-- phpMyAdmin SQL Dump
-- version 3.3.7-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2010 at 02:06 PM
-- Server version: 5.1.46
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rong_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT ' ',
  `content` text NOT NULL,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `add_time`) VALUES
(1, 'title mysql', 'content', '2010-10-03 15:06:14'),
(2, 'title mysql', 'content', '2010-10-03 15:06:17'),
(3, 'how to learn rong?', 'It''s a problem.', '2010-10-03 15:10:21'),
(5, 'new title', 'model content', '2010-10-03 15:27:38'),
(6, 'new title', 'model content', '2010-10-03 15:27:45'),
(7, 'new title', 'model content', '2010-10-03 15:28:15'),
(8, 'new title', 'model content', '2010-10-03 15:28:34'),
(9, 'new title', 'model content', '2010-10-03 15:28:39'),
(10, 'how to learn rong?', 'It''s a problem.', '2010-10-07 15:37:34'),
(11, 'how to learn rong?', 'It''s a problem.', '2010-10-07 17:05:11');
