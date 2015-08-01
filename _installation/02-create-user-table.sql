-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2015 at 05:29 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igi`
--

-- --------------------------------------------------------

--
-- Table structure for table `igi_files`
--

CREATE TABLE IF NOT EXISTS `igi_files` (
  `fileid` int(11) NOT NULL,
  `filenamae` varchar(300) NOT NULL,
  `filepath` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `keywords` int(11) NOT NULL,
  `tags` varchar(500) NOT NULL,
  `caption` varchar(500) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `moderator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `igi_groups`
--

CREATE TABLE IF NOT EXISTS `igi_groups` (
  `groupid` int(11) NOT NULL,
  `groupname` varchar(400) NOT NULL,
  `description` varchar(500) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `igi_keywords`
--

CREATE TABLE IF NOT EXISTS `igi_keywords` (
  `keyid` int(11) NOT NULL,
  `keywords` varchar(300) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `igi`.`users` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
 `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
 `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
 `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
 `user_firstname` varchar(100) NOT NULL,
 `user_lastname` varchar(100) NOT NULL,
 `user_mobile` varchar(30) NOT NULL,
 `groupid` int(11) NOT NULL,
 `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
 `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
 `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
 `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
 `user_rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
 `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attemps',
 `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
 `user_registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `user_registration_ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `user_name` (`user_name`),
 UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

-- add two more columns is_admin and is_moderator

ALTER TABLE `users` ADD `is_admin` TINYINT NOT NULL DEFAULT '0' COMMENT 'for admin user value will be 1' AFTER `groupid`, ADD `is_moderator` TINYINT NOT NULL DEFAULT '0' COMMENT 'if user is moderator then value will be 1' AFTER `is_admin`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `igi_files`
--
ALTER TABLE `igi_files`
  ADD PRIMARY KEY (`fileid`);

--
-- Indexes for table `igi_groups`
--
ALTER TABLE `igi_groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `igi_keywords`
--
ALTER TABLE `igi_keywords`
  ADD PRIMARY KEY (`keyid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `igi_files`
--
ALTER TABLE `igi_files`
  MODIFY `fileid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `igi_groups`
--
ALTER TABLE `igi_groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `igi_keywords`
--
ALTER TABLE `igi_keywords`
  MODIFY `keyid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
