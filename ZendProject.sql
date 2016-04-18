-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2016 at 07:39 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ZendProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_user_id` int(10) unsigned DEFAULT NULL,
  `cat_time` date DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_user_id` (`cat_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `reply_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply_body` varchar(255) NOT NULL,
  `reply_user_id` int(10) unsigned DEFAULT NULL,
  `reply_time` date DEFAULT NULL,
  `thread_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `reply_user_id` (`reply_user_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_category` (
  `sub_cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_cat_title` varchar(255) NOT NULL,
  `sub_cat_body` varchar(255) DEFAULT NULL,
  `sub_cat_user_id` int(10) unsigned DEFAULT NULL,
  `cat_id` int(10) unsigned DEFAULT NULL,
  `sub_cat_time` date DEFAULT NULL,
  `ban_thread` int(10) NOT NULL,
  PRIMARY KEY (`sub_cat_id`),
  KEY `sub_cat_user_id` (`sub_cat_user_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thread_title` varchar(255) NOT NULL,
  `thread_body` varchar(255) NOT NULL,
  `thread_user_id` int(10) unsigned DEFAULT NULL,
  `thread_time` date DEFAULT NULL,
  `sticky` int(10) NOT NULL,
  `sub_cat_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`thread_id`),
  KEY `thread_user_id` (`thread_user_id`),
  KEY `sub_cat_id` (`sub_cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `signatuer` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `ban` int(10) NOT NULL,
  `admin` int(10) NOT NULL,
  `systemclosed` int(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`cat_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`reply_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`sub_cat_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_category_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`thread_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`sub_cat_id`) REFERENCES `sub_category` (`cat_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
