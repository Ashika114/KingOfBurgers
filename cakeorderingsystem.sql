-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 03:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakeorderingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `fooditems`
--

CREATE TABLE `fooditems` (
  `id` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemType` varchar(10) NOT NULL,
  `price` int(11) NOT NULL,
  `discountedPrice` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fooditems`
--

INSERT INTO `fooditems` (`id`, `itemName`, `itemType`, `price`, `discountedPrice`, `filePath`) VALUES
(16, 'Whopper', 'Veg', 200, 0, 'uploads/Whopper.png'),
(17, 'Whopper', 'Non-Veg', 400, 0, 'uploads/Whopper Jr.png');

-- --------------------------------------------------------

--
-- Table structure for table `loginform`
--

CREATE TABLE `loginform` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` varchar(3) NOT NULL DEFAULT 'NO',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `item` varchar(50) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `details` varchar(50) NOT NULL DEFAULT 'Confirmed',
  `order_time` datetime NOT NULL DEFAULT current_timestamp(),
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `username`, `order_id`, `item`, `quantity`, `email`, `address`, `details`, `order_time`, `price`) VALUES
(1, 'dev Patel', 'dev123', '21092024035252', 'Whopper Non-Veg, Whopper Veg, ', '10, 1, ', 'dev@gmail.com', '123 Patel Street Navsari', 'Delivered', '2024-09-21 21:22:52', 2106),
(2, 'dev', 'dev123', '22092024123918', 'Whopper, ', '1, ', 'patel.ashika28@yahoo.in', '123 Patel Street Navsari', 'Confirmed', '2024-09-22 03:39:18', 216);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fooditems`
--
ALTER TABLE `fooditems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginform`
--
ALTER TABLE `loginform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fooditems`
--
ALTER TABLE `fooditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `loginform`
--
ALTER TABLE `loginform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
