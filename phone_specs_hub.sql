-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2023 at 06:16 PM
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
(1, 'Samsung', 'A leading mobile phone manufacturer known for innovative technology.', 'samsung_logo.png'),
(2, 'Apple', 'The maker of the iconic iPhone and iOS devices.', 'apple_logo.png'),
(3, 'Google', 'Known for the Pixel series with pure Android experience.', 'google_logo.png'),
(4, 'LG', 'Offering a range of smartphones with unique features.', 'lg_logo.png'),
(5, 'OnePlus', 'Focused on flagship killers with premium features.', 'oneplus_logo.png');

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
