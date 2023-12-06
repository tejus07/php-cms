-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 06:18 PM
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
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Toyota'),
(2, 'Honda'),
(3, 'Ford'),
(4, 'Chevrolet'),
(5, 'BMW'),
(6, 'Volkswagen'),
(7, 'Mazda'),
(8, 'Mercedes-Benz'),
(9, 'Audi'),
(10, 'Dodge'),
(13, 'Tesla'),
(14, 'Porsche'),
(15, 'Range Rover');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(201, 'Sedan', 'Four-door car with a closed roof'),
(202, 'Hatchback', 'Compact car with a rear door that opens upwards'),
(203, 'SUV', 'Sport Utility Vehicle designed for off-road use'),
(204, 'Convertible', 'Car with a folding or retractable roof'),
(205, 'Truck', 'Vehicle typically used for transporting goods');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `vehicle_id`, `user_id`, `comment_text`, `comment_date`) VALUES
(1, 1, 3, 'Great choice! The Toyota Camry is a smooth ride.', '2023-11-10 21:27:48'),
(2, 2, 3, 'The Honda CR-V is perfect for family adventures!', '2023-11-10 21:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `renter_id` int(11) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `vehicle_id`, `renter_id`, `start_datetime`, `end_datetime`, `duration`, `status`, `message`, `request_date`) VALUES
(1, 1, 3, '2023-11-10 21:27:48', '2023-11-13 21:27:48', 3, 'approved', 'Looking forward to the trip!', '2023-11-10 21:27:48'),
(2, 2, 3, '2023-11-10 21:27:48', '2023-11-15 21:27:48', 5, 'pending', 'Considering this for a family trip', '2023-11-10 21:27:48');

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

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `license_plate` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rental_rate` decimal(10,2) DEFAULT NULL,
  `availability_status` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `owner_id`, `category_id`, `brand_id`, `model`, `license_plate`, `description`, `rental_rate`, `availability_status`, `image_url`, `created_at`) VALUES
(1, 101, 201, 1, 'Toyota Camry', 'ABC123', '<p>Blue sedan</p>', 50.00, 'Available', 'uploads/images/6559197652b28_Toyota_Camry.jpg', '2023-11-19 10:00:00'),
(2, 102, 202, 2, 'Honda Civic', 'XYZ456', '<p>Red hatchback</p>', 45.00, 'Available', 'uploads/images/655916ea4c26c_Honda_Civic.jpg', '2023-11-18 15:30:00'),
(3, 103, 201, 3, 'Ford Mustang', 'DEF789', '<p>Yellow sports car</p>', 80.00, 'Available', 'uploads/images/655916f377380_Ford_Mustang_GT.jpg', '2023-11-17 09:45:00'),
(4, 104, 203, 4, 'Chevrolet Tahoe', 'GHI012', '<p>Black SUV</p>', 100.00, 'Available', 'uploads/images/655916fd62c39_Chevrolet_Tahoe.jpg', '2023-11-16 14:20:00'),
(5, 105, 202, 5, 'BMW 3 Series', 'JKL345', '<p>Silver luxury sedan</p>', 75.00, 'Available', 'uploads/images/65591708c7f6c_BMW 3 Series.jpg', '2023-11-15 11:10:00'),
(6, 106, 203, 9, 'Audi Q5', 'MNO678', '<p>White SUV</p>', 95.00, 'Available', 'uploads/images/655917123b69c_Audi_Q5.jpg', '2023-11-14 17:55:00'),
(7, 107, 201, 13, 'Tesla Model S', 'PQR901', '<p>Electric sedan</p>', 120.00, 'Available', 'uploads/images/6559171c98f12_Tesla_Model_S.jpg', '2023-11-13 08:30:00'),
(8, 108, 202, 8, 'Mercedes-Benz E-Class', 'STU234', '<p>Black luxury sedan</p>', 85.00, 'Available', 'uploads/images/65591759625b2_Mercedes-Benz E-Class.jpg', '2023-11-12 12:45:00'),
(9, 109, 203, 15, 'Range Rover Sport', 'VWX567', '<p>Green SUV</p>', 110.00, 'Available', 'uploads/images/655917275b129_Range Rover Sport.jpg', '2023-11-11 09:20:00'),
(10, 110, 201, 14, 'Porsche 911', 'YZA890', '<p>Red sports car</p>', 150.00, 'Available', 'uploads/images/65591732a4281_Porsche 911.jpg', '2023-11-10 14:15:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_vehicle_comments` (`vehicle_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `renter_id` (`renter_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_vehicle_comments` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`renter_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
