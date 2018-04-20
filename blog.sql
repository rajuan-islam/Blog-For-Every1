-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2016 at 04:56 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Uncategorised'),
(2, 'Personal'),
(3, 'Schools'),
(4, 'Non-profits'),
(5, 'Politics'),
(6, 'Military'),
(7, 'Private'),
(8, 'Sports'),
(9, 'How-to, tips and reviews'),
(10, 'SEO blogs'),
(11, 'Affiliate marketing blogs'),
(12, 'Book tour blogs'),
(13, 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `comment_time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `user_name`, `comment`, `comment_time`) VALUES
(1, 13, 5, 'ayesha126', 'this post is good....learned the basics about SEO', '2016-02-13 20:30:23'),
(2, 13, 5, 'ayesha126', 'can you help us by giving more info?', '2016-02-13 20:31:09'),
(3, 12, 7, 'Mahmud95', 'nice blog', '2016-02-15 13:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `like` int(11) NOT NULL,
  `unlike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_time` datetime NOT NULL,
  `p_img_name` varchar(500) NOT NULL,
  `p_img_path` varchar(500) NOT NULL,
  `p_img_type` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `cat_id`, `title`, `content`, `user_id`, `post_time`, `p_img_name`, `p_img_path`, `p_img_type`) VALUES
(8, 1, 'Ishmam&#039;s Blog', 'this is the first blog.Posted By Tonmoy Hossain', 4, '2016-02-08 20:47:30', '1454960851.jpg', 'photo/1454960851.jpg', 'image/jpeg'),
(9, 13, 'this is noyjin', 'business', 4, '2016-02-08 20:57:45', '1454961466.jpg', 'photo/1454961466.jpg', 'image/jpeg'),
(10, 5, 'Obama Got Fired!!', 'content of the post is presented here', 6, '2016-02-08 21:56:35', '1454964995.jpg', 'photo/1454964995.jpg', 'image/jpeg'),
(11, 8, 'Bangladesh Reached Semi-Finals In U-19 WC', 'Bangladesh reached semi-finals in wc u-19. they will face WI.Hope they will b in finals.....\r\nhave a great day', 5, '2016-02-11 16:23:52', '1455204232.jpg', 'photo/1455204232.jpg', 'image/jpeg'),
(12, 8, 'India reached finals', 'India beat sri-lanka by big margin.they will face WI in the finals......', 5, '2016-02-11 16:26:13', '1455204374.jpg', 'photo/1455204374.jpg', 'image/jpeg'),
(13, 10, 'This blog will help you in SEO', 'seo means search engine optimization.its a must in web development.\r\ndfsdfdsgfbvvfcgbhtfdyhtrtertewrqweqwed', 7, '2016-02-13 07:37:53', '1455345474.jpg', 'photo/1455345474.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `u_img_name` varchar(500) NOT NULL,
  `u_img_path` varchar(500) NOT NULL,
  `u_img_type` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `email`, `phone`, `type`, `status`, `u_img_name`, `u_img_path`, `u_img_type`) VALUES
(1, 'rezakhan995', 'bb98b1d0b523d5e783f931550d7702b6', 'rezaul islam khan', 'rezakhan995@gmail.com', '01689514252', 'admin', 1, '1454874137.jpg', 'photo/1454874137.jpg', 'image/jpeg'),
(3, 'fahim995', 'dcbb9006afaee1296ff36eabe1cddb28', 'fahim dhruba', 'fahim@gmail.com', '090909', 'user', 0, '', '', ''),
(4, 'tonmoy513', 'cfd118a5df7225dd407e95e1fc6e5fab', 'ishmam hossain', 'tonmoy513@gmail.com', '01688552200', 'admin', 1, '1454873841.jpg', 'photo/1454873841.jpg', 'image/jpeg'),
(5, 'ayesha126', 'cec9818936add98229817fb432540b18', 'ayesha sharmin', 'ayesha126@yahoo.com', '123123098', 'user', 1, '1454873722.jpeg', 'photo/1454873722.jpeg', 'image/jpeg'),
(6, 'nudrat93', 'e35faaeed7922fa1c172363ff51a7146', 'nudrat nawal saber', 'saber007@gmail.com', '0196655874', 'user', 1, '1454874324.jpg', 'photo/1454874324.jpg', 'image/jpeg'),
(7, 'Mahmud95', 'e1aa6aa12922a1275c9c8f8e54bac8d6', 'mahmudul hassan', 'mzishan95@yahoo.com', '01750537963', 'user', 1, '1455210178.jpg', 'photo/1455210178.jpg', 'image/jpeg'),
(8, 'fayza58', 'f42d5f88dd7f235cf7ff3bd3c3b76ff7', 'fayza amreen', 'fayza58@ymail.com', '016806060000', 'user', 1, '', '', ''),
(9, 'asif123', '6f3c4bd06e7c378d955b9901c6b0c537', 'asif mahmud', 'asif123@gmail.com', '029664853', 'user', 1, '1455538014.jpg', 'photo/1455538014.jpg', 'image/jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`), ADD KEY `post_id` (`post_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`), ADD KEY `cat_id` (`cat_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
