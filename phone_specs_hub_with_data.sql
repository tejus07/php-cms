-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2023 at 05:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_specs_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `logo_url`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'Known for its iPhone series and other innovative tech products.', 'https://example.com/apple_logo.png', '2023-11-15 03:28:19', '2023-11-21 03:40:06'),
(2, 'Samsung', 'Produces a wide range of smartphones and electronic devices.', 'https://example.com/samsung_logo.png', '2023-11-15 03:28:19', '2023-11-15 03:28:19'),
(3, 'Google', 'Develops the Pixel series of smartphones and other technology products.', 'https://example.com/google_logo.png', '2023-11-15 03:28:19', '2023-11-15 03:28:19'),
(4, 'Huawei', 'A global provider of information and communications technology (ICT) infrastructure and smart devices.', 'https://example.com/huawei_logo.png', '2023-11-15 03:28:19', '2023-11-15 03:28:19'),
(5, 'OnePlus', 'Focuses on high-performance smartphones with a loyal fan base.', 'https://example.com/oneplus_logo.png', '2023-11-15 03:28:19', '2023-11-15 03:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `brand_id`, `name`, `description`, `release_date`, `image_url`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'iPhone 13', '<p><em>The latest iPhone with advanced features.s</em></p>', '2022-09-15', 'uploads/6568bff29ef24_71GLMJ7TQiL._SX679_.jpg', 1, '2023-11-15 03:29:35', '2023-11-30 17:01:38'),
(2, 2, 'Galaxy S21', '<p>Flagship smartphone with powerful performance.</p>', '2021-01-29', 'uploads/6568cce5e85e6_samsung-galaxy-s21-5g-r.jpg', 1, '2023-11-15 03:29:35', '2023-11-30 17:56:53'),
(3, 3, 'Pixel 6', '<p>Google\'s latest Pixel phone with impressive camera capabilities.</p>', '2021-10-19', 'uploads/6568ccf182fd0_pixel6.png', 1, '2023-11-15 03:29:35', '2023-11-30 17:57:05'),
(4, 4, 'Mate 40 Pro', '<p>Huawei\'s flagship with cutting-edge technology.</p>', '2020-10-22', 'uploads/6568cd248e6cc_huaweimate40pro.jpg', 1, '2023-11-15 03:29:35', '2023-11-30 17:57:56'),
(5, 5, 'OnePlus 9', 'High-performance smartphone for enthusiasts.', '2021-03-23', NULL, 1, '2023-11-15 03:29:35', '2023-11-21 03:53:51'),
(6, 1, 'iPhone 14', 'The next generation iPhone with advanced features.', '2023-09-20', NULL, 1, '2023-11-15 03:29:35', '2023-11-21 03:53:54'),
(7, 2, 'Galaxy S22', '<p>Flagship smartphone with enhanced performance.</p>', '2023-01-30', NULL, 1, '2023-11-15 03:29:35', '2023-11-30 17:55:50'),
(8, 3, 'Pixel 7', 'Google\'s latest Pixel phone with cutting-edge technology.', '2023-10-25', NULL, 1, '2023-11-15 03:29:35', '2023-11-21 03:53:56'),
(9, 4, 'Mate 50 Pro', '<p>Huawei\'s flagship with innovative features.</p>', '2023-11-01', 'uploads/6568cd4ac59e9_huaweimate50pro.jpg', 1, '2023-11-15 03:29:35', '2023-11-30 17:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `phone_specs`
--

CREATE TABLE `phone_specs` (
  `id` int(11) NOT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `RAM` int(11) DEFAULT NULL,
  `storage` int(11) DEFAULT NULL,
  `camera` varchar(255) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL,
  `battery` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phone_specs`
--

INSERT INTO `phone_specs` (`id`, `phone_id`, `processor`, `RAM`, `storage`, `camera`, `display`, `battery`, `operating_system`, `created_at`, `updated_at`) VALUES
(1, 1, 'A15 Bionics', 6, 128, 'Dual 12MP system', '6.1-inch Super Retina XDR', 'Non-removable Li-Ion 3520 mAh', 'iOS 16', '2023-11-15 03:29:50', '2023-11-16 16:39:00'),
(2, 2, 'Exynos 2100', 8, 128, 'Triple 12MP system', '6.2-inch Dynamic AMOLED 2X', 'Non-removable Li-Ion 4000 mAh', 'Android 11, One UI 3.1', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(3, 3, 'Tensor', 8, 128, 'Dual 50MP system', '6.4-inch AMOLED', 'Non-removable Li-Ion 4600 mAh', 'Android 12', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(4, 4, 'Kirin 9000', 8, 256, 'Triple 50MP system', '6.76-inch OLED', 'Non-removable Li-Po 4400 mAh', 'Android 10, EMUI 11', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(5, 5, 'Snapdragon 888', 8, 128, 'Triple 48MP system', '6.55-inch Fluid AMOLED', 'Non-removable Li-Po 4500 mAh', 'Android 11, OxygenOS 11', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(6, 6, 'A16 Bionic', 6, 128, 'Dual 12MP system', '6.2-inch Super Retina XDR', 'Non-removable Li-Ion 3600 mAh', 'iOS 16', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(7, 7, 'Exynos 2200', 8, 256, 'Quad 108MP system', '6.3-inch Dynamic AMOLED 2X', 'Non-removable Li-Ion 4200 mAh', 'Android 12, One UI 4.0', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(8, 8, 'Tensor 2', 12, 256, 'Penta 108MP system', '6.5-inch AMOLED', 'Non-removable Li-Ion 5000 mAh', 'Android 13', '2023-11-15 03:29:50', '2023-11-15 03:29:50'),
(9, 9, 'Kirin 9100', 6, 128, 'Triple 64MP system', '6.5-inch OLED', 'Non-removable Li-Po 4000 mAh', 'Android 11, EMUI 12', '2023-11-15 03:29:50', '2023-11-15 03:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'john', '$2y$10$NLHbx2n1z8muJE.A0qBPGOWYDdpELiJFTxsS8KNMTH3hD61bFwEJK', 'john@gmail.com', 1, '2023-11-15 03:30:10', '2023-11-17 04:35:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_id` (`phone_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `phone_specs`
--
ALTER TABLE `phone_specs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_id` (`phone_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `phone_specs`
--
ALTER TABLE `phone_specs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `phones_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `phone_specs`
--
ALTER TABLE `phone_specs`
  ADD CONSTRAINT `phone_specs_ibfk_1` FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
