-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 06:12 PM
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
-- Database: `rentandgodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `phone_number`, `registration_date`) VALUES
(1, 'John', 'admin_password', 'administrator', '1234567890', '2023-11-10 21:27:48'),
(2, 'Janet', 'owner1_password', 'vehicle_owner', '9876543210', '2023-11-10 21:27:48'),
(3, 'Julian', 'renter1_password', 'renter', '5551234567', '2023-11-10 21:27:48'),
(101, 'john_doe', 'password123', 'user', '+1234567890', '2023-11-01 00:00:00'),
(102, 'jane_smith', 'pass456word', 'user', '+1987654321', '2023-10-28 00:00:00'),
(103, 'alex_brown', 'abc@9876', 'user', '+1555123456', '2023-10-25 00:00:00'),
(104, 'emily_wilson', 'strongPass789', 'admin', '+1666777888', '2023-10-22 00:00:00'),
(105, 'mike_jones', 'mikepass', 'user', '+1444333222', '2023-10-19 00:00:00'),
(106, 'sara_adams', 'saraPass321', 'user', '+1777888999', '2023-10-15 00:00:00'),
(107, 'chris_evans', 'captain@america', 'user', '+18889990000', '2023-10-12 00:00:00'),
(108, 'lisa_jackson', 'lisaPass456', 'admin', '+1999111222', '2023-10-08 00:00:00'),
(109, 'david_miller', 'davidPass789', 'user', '+1888777666', '2023-10-05 00:00:00'),
(110, 'sophia_roberts', 'sophia123', 'user', '+1777666555', '2023-10-01 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
