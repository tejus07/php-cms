-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 05:10 PM
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
  `logo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `logo_url`) VALUES
(1, 'Apple', 'Known for its iPhone series and other innovative tech products.', 'https://example.com/apple_logo.png'),
(2, 'Samsung', 'Produces a wide range of smartphones and electronic devices.', 'https://example.com/samsung_logo.png'),
(3, 'Google', 'Develops the Pixel series of smartphones and other technology products.', 'https://example.com/google_logo.png'),
(4, 'Huawei', 'A global provider of information and communications technology (ICT) infrastructure and smart devices.', 'https://example.com/huawei_logo.png'),
(5, 'OnePlus', 'Focuses on high-performance smartphones with a loyal fan base.', 'https://example.com/oneplus_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `brand_id`, `name`, `description`, `release_date`, `image_url`, `user_id`) VALUES
(1, 1, 'iPhone 13', 'The latest iPhone with advanced features.', '2022-09-14', 'https://example.com/iphone13_image.png', 1),
(2, 2, 'Galaxy S21', 'Flagship smartphone with powerful performance.', '2021-01-29', 'https://example.com/galaxyS21_image.png', 1),
(3, 3, 'Pixel 6', 'Google\'s latest Pixel phone with impressive camera capabilities.', '2021-10-19', 'https://example.com/pixel6_image.png', 1),
(4, 4, 'Mate 40 Pro', 'Huawei\'s flagship with cutting-edge technology.', '2020-10-22', 'https://example.com/mate40pro_image.png', 1),
(5, 5, 'OnePlus 9', 'High-performance smartphone for enthusiasts.', '2021-03-23', 'https://example.com/oneplus9_image.png', 1),
(6, 1, 'iPhone 14', 'The next generation iPhone with advanced features.', '2023-09-20', 'https://example.com/iphone14_image.png', 1),
(7, 2, 'Galaxy S22', 'Flagship smartphone with enhanced performance.', '2023-01-30', 'https://example.com/galaxyS22_image.png', 1),
(8, 3, 'Pixel 7', 'Google\'s latest Pixel phone with cutting-edge technology.', '2023-10-25', 'https://example.com/pixel7_image.png', 1),
(9, 4, 'Mate 50 Pro', 'Huawei\'s flagship with innovative features.', '2023-11-01', 'https://example.com/mate50pro_image.png', 1),
(10, 5, 'OnePlus 10', 'High-performance smartphone with a sleek design.', '2023-04-02', 'https://example.com/oneplus10_image.png', 1);

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
  `operating_system` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phone_specs`
--

INSERT INTO `phone_specs` (`id`, `phone_id`, `processor`, `RAM`, `storage`, `camera`, `display`, `battery`, `operating_system`) VALUES
(1, 1, 'A15 Bionic', 6, 128, 'Dual 12MP system', '6.1-inch Super Retina XDR', 'Non-removable Li-Ion 3520 mAh', 'iOS 15'),
(2, 2, 'Exynos 2100', 8, 128, 'Triple 12MP system', '6.2-inch Dynamic AMOLED 2X', 'Non-removable Li-Ion 4000 mAh', 'Android 11, One UI 3.1'),
(3, 3, 'Tensor', 8, 128, 'Dual 50MP system', '6.4-inch AMOLED', 'Non-removable Li-Ion 4600 mAh', 'Android 12'),
(4, 4, 'Kirin 9000', 8, 256, 'Triple 50MP system', '6.76-inch OLED', 'Non-removable Li-Po 4400 mAh', 'Android 10, EMUI 11'),
(5, 5, 'Snapdragon 888', 8, 128, 'Triple 48MP system', '6.55-inch Fluid AMOLED', 'Non-removable Li-Po 4500 mAh', 'Android 11, OxygenOS 11'),
(6, 6, 'A16 Bionic', 6, 128, 'Dual 12MP system', '6.2-inch Super Retina XDR', 'Non-removable Li-Ion 3600 mAh', 'iOS 16'),
(7, 7, 'Exynos 2200', 8, 256, 'Quad 108MP system', '6.3-inch Dynamic AMOLED 2X', 'Non-removable Li-Ion 4200 mAh', 'Android 12, One UI 4.0'),
(8, 8, 'Tensor 2', 12, 256, 'Penta 108MP system', '6.5-inch AMOLED', 'Non-removable Li-Ion 5000 mAh', 'Android 13'),
(9, 9, 'Kirin 9100', 6, 128, 'Triple 64MP system', '6.5-inch OLED', 'Non-removable Li-Po 4000 mAh', 'Android 11, EMUI 12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'tejus07', NULL, 'tejussahi07@gmail.com', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `phone_specs`
--
ALTER TABLE `phone_specs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
