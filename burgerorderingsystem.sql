-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 22, 2024 at 05:15 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `burgerorderingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `fooditems`
--

DROP TABLE IF EXISTS `fooditems`;
CREATE TABLE IF NOT EXISTS `fooditems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(255) NOT NULL,
  `itemType` varchar(10) NOT NULL,
  `price` int(11) NOT NULL,
  `discountedPrice` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fooditems`
--

INSERT INTO `fooditems` (`id`, `itemName`, `itemType`, `price`, `discountedPrice`) VALUES
(1, 'Whopper', 'Veg', 150, 120),
(2, 'Whopper', 'Non-Veg', 180, 0),
(3, 'Whopper Jr.', 'Veg', 100, 0),
(4, 'Whopper Jr.', 'Non-Veg', 120, 0),
(5, 'King', 'Veg', 180, 10),
(6, 'King', 'Non-Veg', 200, 0),
(13, 'Paneer Burger', 'Veg', 300, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loginform`
--

DROP TABLE IF EXISTS `loginform`;
CREATE TABLE IF NOT EXISTS `loginform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` varchar(3) NOT NULL DEFAULT 'NO',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loginform`
--

INSERT INTO `loginform` (`id`, `fullname`, `username`, `email`, `password`, `admin`, `created_at`) VALUES
(1, 'Admin', 'admin', 'admin@obos.com', '$2y$10$SWWKKsCCjtAT6P0okscHaeyAeuFf8Jr2J3l7tnnTiKlf39fI8B6Wi', 'YES', '2021-11-25 16:20:53'),
(2, 'Dev', 'dev123', 'dev@gmail.com', '$2y$10$MrLtJmOPl5DSbJSG199jSeA09Z1dICF.S9E1l94rSOJkXa79Z7S8e', 'NO', '2024-09-21 19:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `item` varchar(50) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `details` varchar(50) NOT NULL DEFAULT 'Confirmed',
  `order_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `username`, `order_id`, `item`, `quantity`, `email`, `address`, `details`, `order_time`, `price`) VALUES
(1, 'dev Patel', 'dev123', '21092024035252', 'Whopper Non-Veg, Whopper Veg, ', '10, 1, ', 'dev@gmail.com', '123 Patel Street Navsari', 'Delivered', '2024-09-21 21:22:52', 2106);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
