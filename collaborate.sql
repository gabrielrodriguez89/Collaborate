-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 01:47 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collaborate`
--
CREATE DATABASE IF NOT EXISTS `collaborate` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `collaborate`;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `date_added` date NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `user_posted_to` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `posts`
--

TRUNCATE TABLE `posts`;
-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `project_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `type_of_project` text COLLATE utf8_unicode_ci NOT NULL,
  `state` text COLLATE utf8_unicode_ci NOT NULL,
  `city` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `attachment` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `projects`
--

TRUNCATE TABLE `projects`;
--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `username`, `project_name`, `description`, `type_of_project`, `state`, `city`, `date`, `attachment`) VALUES
(1, 'grod', 'Collaborate', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo cons', 'Apps', 'Colorado', 'Denver', '2018-01-09', 0x75706c6f6164732f75736572646174612f757365725f70686f746f732f53736365426a4357557a70484c45312f7472756d702e6a7067),
(2, 'grod', 'gadhbash', 'fihfslkjdaflksdjfkjds', 'Art', 'Colorado', 'Denver', '2018-03-08', 0x75706c6f6164732f75736572646174612f757365725f70686f746f732f6f667651656b5933704f5464507a712f7472756d70322e6a706567);

-- --------------------------------------------------------

--
-- Table structure for table `pvt_messages`
--

DROP TABLE IF EXISTS `pvt_messages`;
CREATE TABLE IF NOT EXISTS `pvt_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user` varchar(50) NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `draft` enum('0','1') NOT NULL,
  `opened` enum('0','1') NOT NULL,
  `recipientDelete` enum('0','1','2') NOT NULL,
  `senderDelete` enum('0','1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `pvt_messages`
--

TRUNCATE TABLE `pvt_messages`;
--
-- Dumping data for table `pvt_messages`
--

INSERT INTO `pvt_messages` (`id`, `to_user`, `from_user`, `date`, `subject`, `message`, `draft`, `opened`, `recipientDelete`, `senderDelete`) VALUES
(12, 'buster', 'grod', '2018-06-06', '', 'bro it worked', '1', '0', '0', '2'),
(13, 'buster', 'grod', '2018-06-07', '', 'bro it worked', '1', '0', '0', '2'),
(14, 'buster', 'grod', '2018-06-07', '', 'yo', '0', '0', '0', '2'),
(15, 'buster', 'grod', '2018-06-08', '', 'hello kitty', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `sign_up_date` date NOT NULL,
  `activated` enum('0','1') NOT NULL,
  `bio` text,
  `interest` varchar(225) DEFAULT NULL,
  `hobbies` varchar(225) DEFAULT NULL,
  `profile_pic` mediumblob,
  `age` date NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  `background` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `sign_up_date`, `activated`, `bio`, `interest`, `hobbies`, `profile_pic`, `age`, `city`, `state`, `background`) VALUES
(6, 'grod', 'Gabriel', 'Rodriguez', 'gabrielrodriguez89@outlook.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-23', '0', 'do it', 'coding', 'sex', 0x2e2f2e2e2f75706c6f6164732f75736572646174612f757365725f70686f746f732f49676558304a5456685a484d5145362f416e6e69655f31362e6a7067, '1989-05-20', 'Denver', 'Colorado', ''),
(7, 'buster', 'dave', 'buster', 'bust@me.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-01-10', '0', 'hfgshs', 'sghsgh', 'sghsgh', '', '0000-00-00', 'Denver', 'Colorado', ''),
(8, 'adams', 'John', 'Adams', 'johnadams@yahoo.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-01-25', '0', 'i like to move it move it', 'something', 'i like to move it', '', '0000-00-00', 'denver', 'colorado', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
