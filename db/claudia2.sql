-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2024 at 03:08 AM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtech_fall2024_senam_dzomeku`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('customer') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `fname`, `lname`, `email`, `phone`, `address`, `username`, `password`, `created_at`, `updated_at`, `role`) VALUES
(13, 'Senam', 'Dzomeku', 'senam@gmail.com', NULL, NULL, 'seder', '$2y$10$3oSF.Ab2nR/1e6vURbnxkumsOt92OMRQUaCn2zNZcYgod2nGDRJC6', '2024-12-17 20:32:25', '2024-12-17 20:32:25', 'customer'),
(14, 'Newman', 'Blay', 'yellow@gmail.com', '0203040402', 'Banana Avenue', 'blokk2', '$2y$10$GF4ElmD8KHEfERPLYd2e2.66nelsv9I9MguDZnWWsFMh.AgQOgYZq', '2024-12-17 22:15:31', '2024-12-17 22:15:31', 'customer'),
(15, 'Daniel', 'Wor', 'danwor@gmail.com', '+44 07903 630682', 'Safestore Ltd', 'danny3', '$2y$10$fC7evu1eeRqUYAvBcrodG.FF5sagKy1lcO4XYaFXWd3tuvg/HSphi', '2024-12-18 00:24:03', '2024-12-18 00:24:03', 'customer'),
(16, 'Red', 'Blue', 'red@s.com', '+44 07903 630682', 'Safestore Ltd', 'red22', '$2y$10$iTSO/u10emxn0FNLOi11yukinCKqECBEPqOC3iEkgn4I6notS0Rim', '2024-12-18 01:02:54', '2024-12-18 01:02:54', 'customer'),
(17, 'George', 'Brown', 'george-brown@gmail.com', '+44 07903 630682', 'Safestore Ltd', 'geordeee', '$2y$10$cIw3lEUyDeK/gTuHNu51zeuJ0Lkr0KziDOdTg0ZnD95BqXM4zS5h6', '2024-12-18 01:05:47', '2024-12-18 01:05:47', 'customer'),
(18, 'Sheras', 'Boat', 'sheras@t.com', '+321 4949409849', 'Safestore Ltd', NULL, NULL, '2024-12-18 01:57:12', '2024-12-18 01:57:27', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `customer_requests`
--

CREATE TABLE `customer_requests` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fill`
--

CREATE TABLE `form_fill` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fill`
--

INSERT INTO `form_fill` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(4, 'Mark Bow', 'mark@gmail.com', 'I really like your work, and i would like to discuss an opportunity.', '2024-12-18 00:22:53'),
(5, 'Sally Roe', 'reo@gmail.com', 'Hi, i really love your work, can i get a wedding dress?', '2024-12-18 01:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `measurements_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `bust` decimal(5,2) DEFAULT NULL,
  `waist` decimal(5,2) DEFAULT NULL,
  `hips` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `additional_details` text COLLATE utf8mb4_general_ci,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`measurements_id`, `customer_id`, `bust`, `waist`, `hips`, `height`, `additional_details`, `image_url`, `created_at`, `updated_at`) VALUES
(8, 13, 2.00, 2.00, 2.00, -0.01, '2', 'dress1.jpg', '2024-12-17 21:36:48', '2024-12-17 21:59:29'),
(9, 15, 22.00, 22.00, 1.00, 2.00, '2', 'about4.jpeg', '2024-12-18 00:42:24', '2024-12-18 00:50:21'),
(10, 17, 300.00, 200.00, 33.00, 5.50, 'i like green and blue', 'dress6.jpg', '2024-12-18 01:06:48', '2024-12-18 01:06:48'),
(11, 18, 34.00, 32.00, 40.00, 5.60, 'likes green and silk', NULL, '2024-12-18 01:58:46', '2024-12-18 01:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `quantity`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(6, 13, 25, 2, 800.00, 'Confirmed', '2024-12-17 21:59:29', '2024-12-18 01:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_general_ci,
  `product_price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `image_url`, `created_at`, `updated_at`) VALUES
(24, 'Dark Knight', 'Sharp, powerful, and utterly commanding, the BLUE BOSS is more than just a dress—it\'s a statement of professional prowess. In a striking shade of blue that sits between royal and electric, this dress cuts a silhouette that means business', 500.00, 'uploads/6761d6e0943046.12429266.jpg', '2024-12-17 19:54:08', '2024-12-18 00:49:39'),
(25, 'Pink Passion', 'Soft yet fierce, the Pink Passion dress is a love letter to femininity in all its complexity. It\'s not just pink—it\'s a spectrum of emotion, from the palest blush to the most intense fuchsia.', 400.00, 'uploads/6761d715a81bb4.60942235.jpg', '2024-12-17 19:55:01', '2024-12-18 00:49:42'),
(26, 'Bottomless Blue', 'Like the infinite depths of the ocean, this dress captures the many moods of blue. From the lightest azure to the deepest navy, it\'s a journey through color and emotion. ', 700.00, 'uploads/6761d737353903.25069674.jpg', '2024-12-17 19:55:35', '2024-12-18 00:49:52'),
(30, 'Touch of the Sky', 'Ethereal and light as a cloud, this dress seems to float between reality and imagination.', 750.00, 'uploads/67622b4a2915c1.40466996.jpg', '2024-12-18 01:45:32', '2024-12-18 01:54:18'),
(31, 'Raging Gold', 'A nice dress', 200.00, 'uploads/67622aef202a73.62363948.jpg', '2024-12-18 01:52:47', '2024-12-18 01:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `upload_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('admin','superadmin') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `email`, `password_hash`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Claudia', 'admin', 'admin@gmail.com', '$2y$10$/liX8vNvRUhf4D1/4xpDv.mR4iIJmS4XwvXoMD/uL7cJJXt421JuS', '2024-12-16 18:31:50', '2024-12-16 18:58:28', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `form_fill`
--
ALTER TABLE `form_fill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`measurements_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `id` (`order_id`),
  ADD KEY `user_id` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `form_fill`
--
ALTER TABLE `form_fill`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `measurements_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `upload_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
