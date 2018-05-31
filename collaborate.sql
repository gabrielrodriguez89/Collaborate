-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2018 at 11:01 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `uid` varchar(32) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `date_posted` date NOT NULL,
  `description` text,
  `image_url` text NOT NULL,
  `img_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `uid`, `username`, `date_posted`, `description`, `image_url`, `img_id`) VALUES
(17, NULL, 'grod', '2018-01-03', NULL, 'uploads/userdata/user_photos/nXKuW0H7fkoABIY/inauguration.jpg', 'a26b78e8ea11ed75217b9f8a7103eca3'),
(18, NULL, 'buster', '2018-01-10', NULL, 'uploads/userdata/user_photos/nHmAy5PUKs1o2Qt/trump2.jpg', 'd0f12109795c86085ccaace2eebd0457');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `date_added` date NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `user_posted_to` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `project_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `type_of_project` text COLLATE utf8_unicode_ci NOT NULL,
  `state` text COLLATE utf8_unicode_ci NOT NULL,
  `city` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `attachment` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `pvt_messages` (
  `id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `opened` enum('0','1') NOT NULL,
  `recipientDelete` enum('0','1') NOT NULL,
  `senderDelete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
  `background` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `sign_up_date`, `activated`, `bio`, `interest`, `hobbies`, `profile_pic`, `age`, `city`, `state`, `background`) VALUES
(6, 'grod', 'Gabriel', 'Rodriguez', 'gabrielrodriguez89@outlook.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-23', '0', 'do it', 'coding', 'sex', 0x2e2f2e2e2f75706c6f6164732f75736572646174612f757365725f70686f746f732f49676558304a5456685a484d5145362f416e6e69655f31362e6a7067, '0000-00-00', 'Denver', 'Colorado', ''),
(7, 'buster', 'dave', 'buster', 'bust@me.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-01-10', '0', 'hfgshs', 'sghsgh', 'sghsgh', '', '0000-00-00', 'Denver', 'Colorado', ''),
(8, 'adams', 'John', 'Adams', 'johnadams@yahoo.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-01-25', '0', 'i like to move it move it', 'something', 'i like to move it', '', '0000-00-00', 'denver', 'colorado', ''),
(11, 'grod', 'Gabriel', 'Rodriguez', 'gabriel@yahoo.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-05-08', '0', 'do it', 'coding', 'sex', 0x2e2f2e2e2f75706c6f6164732f75736572646174612f757365725f70686f746f732f584e45466b6156667065535a4349742f416e6e69655f31362e6a7067, '0000-00-00', 'Denver', 'Colorado', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pvt_messages`
--
ALTER TABLE `pvt_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pvt_messages`
--
ALTER TABLE `pvt_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
