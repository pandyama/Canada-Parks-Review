-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2016 at 09:51 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mapleleaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `object`
--

CREATE TABLE `object` (
  `id` int(11) NOT NULL,
  `obj_name` varchar(256) NOT NULL,
  `lat` decimal(10,7) NOT NULL,
  `lon` decimal(10,7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `object`
--

INSERT INTO `object` (`id`, `obj_name`, `lat`, `lon`) VALUES
(1, 'Banff National Park', '51.4968460', '-115.9280560'),
(2, 'Algonquin National Park', '45.8371590', '-78.3791240'),
(3, 'Bruce Peninsula', '44.0286080', '-82.3001300'),
(4, 'Aulavik National Park', '73.6019490', '-119.4042400'),
(5, 'Cape Breton Highlands', '46.7382850', '-60.6509770'),
(6, 'Jasper National Park', '52.8733830', '-117.9542940'),
(7, 'Elk Island', '53.6767069', '-112.6760250');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `objectid` int(11) NOT NULL,
  `user` varchar(256) CHARACTER SET utf16 NOT NULL,
  `comment` varchar(256) NOT NULL,
  `rating` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `objectid`, `user`, `comment`, `rating`) VALUES
(1, 1, 'jess1', 'Banff is by far the best place on earth. The peace of mind achieved there cannot be acheived anywhere else', '5 Star'),
(2, 1, 'luke1', 'Banff National Park is the most beautiful place on earth. Hands Down!!', '5 Star'),
(3, 1, 'matt1', 'Banff is a must visit place. Either in winter or summer, its beautiful thorughout the year', '5 Star'),
(4, 2, 'adam1', 'Its a great place for camping in summer', '4 Star'),
(5, 1, 'alicia1', 'Its like Heaven on Earth', '5 Star'),
(6, 2, 'jess1', 'Best place to take kids and family in summer ', '5 Star'),
(7, 3, 'luke1', 'Best Vacation ever!!', '3 Star'),
(8, 4, 'matt1', 'Best place to visit after graduation with friends', '3 Star');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `salt` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `salt`) VALUES
(1, 'Jessica', 'Jones', 'jess1', '9d53d235844ed6811680e2e9e4baf813cc42bb9a8cb638cc1374ee0f974dd924', 'j@j.com', '5ŠMhd`UµµQØ	À2å(m>'),
(2, 'Luke', 'Cage', 'luke1', 'ce8aa489da248e991d188575c462d977f30782699c273ef9970f1260cf6df712', 'l@l.com', '‹äG	[¢Æ¡Õt;…OÜyJ"'),
(3, 'Matt', 'Murdock', 'matt1', '6df05f253cac95a49abb6f8c37e48dade87f7942e72cd4ec34861ec49af2c3c6', 'm@m.com', '5‡ÓN‘DÂV…Ñø2`\nî›TR'),
(4, 'Adam', 'Warlock', 'adam1', '9d985c90e921526dffc4d461cc50a159b997ea55a78b9cef4ca8c1bbc9cb4b00', 'a@a.com', '÷1¡#h{Ç†òÙz¥÷5ò+DÈ	'),
(5, 'Alicia', 'Masters', 'alicia1', 'a057cb8ac563054729c7130baba9d862513e9542428596673db0a926003ca5fd', 'al@al.com', 'ÇÒ”Hø…|BÔ%qŸžô-"gg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
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
-- AUTO_INCREMENT for table `object`
--
ALTER TABLE `object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
