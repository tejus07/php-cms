-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 08:11 AM
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
-- Database: `pizzaPals`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `title`) VALUES
(1, 'country12'),
(3, 'Margherita'),
(4, 'Pepperoni'),
(5, 'Vegetarian'),
(6, 'Hawaiian'),
(7, 'Meat Lovers');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizzarecipes`
--

CREATE TABLE `pizzarecipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pizzarecipes`
--

INSERT INTO `pizzarecipes` (`recipe_id`, `title`, `ingredients`, `instructions`, `image_url`, `created_at`, `user_id`, `category_id`) VALUES
(12, 'Margherita Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Fresh Basil, Olive Oil', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Bake for 12-15 minutes. 6. Top with fresh basil leaves, salt, and pepper.', 'uploads/images/margarita.jpg', '2023-11-17 01:59:01', 4, 3),
(13, 'Pepperoni Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Pepperoni', '1. Preheat oven to 450°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Arrange pepperoni slices. 6. Bake for 12-15 minutes or until crust is golden and cheese is bubbly.', 'uploads/images/pepperoni.jpg', '2023-11-17 01:59:01', 6, 3),
(14, 'Vegetarian Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Bell Peppers, Red Onion, Mushrooms, Black Olives', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Top with bell peppers, red onion, mushrooms, and black olives. 6. Bake for 12-15 minutes.', 'uploads/images/vegeterian.jpg', '2023-11-17 01:59:01', 3, 3),
(15, 'Hawaiian Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Ham, Pineapple', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Top with ham and pineapple. 6. Bake for 12-15 minutes.', 'uploads/images/hawaiian.jpg', '2023-11-17 02:00:16', 6, 4),
(16, 'Meat Lovers Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Pepperoni, Sausage, Bacon, Ground Beef', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Top with pepperoni, sausage, bacon, and ground beef. 6. Bake for 12-15 minutes or until meat is cooked through.', 'uploads/images/meat_lovers.jpg', '2023-11-17 02:00:16', 5, 3),
(17, 'BBQ Chicken Pizza', 'Dough, BBQ Sauce, Mozzarella Cheese, Grilled Chicken, Red Onion, Cilantro', '1. Preheat oven to 450°F. 2. Roll out the pizza dough. 3. Spread BBQ sauce evenly. 4. Add mozzarella cheese. 5. Top with grilled chicken, red onion, and cilantro. 6. Bake for 12-15 minutes.', 'uploads/images/bbq_chicken.jpeg', '2023-11-17 02:00:16', 3, 3),
(18, 'Four Cheese Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Gouda, Parmesan, Ricotta', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella, gouda, parmesan, and ricotta cheese. 5. Bake for 12-15 minutes or until cheese is melted and bubbly.', 'uploads/images/four_cheese.jpg', '2023-11-17 02:00:16', 4, 6),
(23, 'Supreme Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Pepperoni, Sausage, Bell Peppers, Red Onion, Black Olives, Mushrooms', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Top with pepperoni, sausage, bell peppers, red onion, black olives, and mushrooms. 6. Bake for 12-15 minutes.', 'uploads/images/supreme.jpg', '2023-11-17 12:22:36', 1, 5),
(24, 'Mushroom and Spinach Pizza', 'Dough, Tomato Sauce, Mozzarella Cheese, Mushrooms, Spinach, Garlic, Olive Oil', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Spread marinara sauce evenly. 4. Add mozzarella cheese. 5. Top with mushrooms, spinach, garlic, and a drizzle of olive oil. 6. Bake for 12-15 minutes.', 'uploads/images/mushroom_and_spinach.jpg', '2023-11-17 12:22:36', 3, 3),
(25, 'White Pizza', 'Dough, Olive Oil, Mozzarella Cheese, Ricotta Cheese, Garlic, Basil, Salt, Black Pepper', '1. Preheat oven to 475°F. 2. Roll out the pizza dough. 3. Brush dough with olive oil. 4. Spread mozzarella cheese evenly. 5. Add dollops of ricotta cheese. 6. Sprinkle minced garlic, basil, salt, and black pepper. 7. Bake for 12-15 minutes or until crust is golden.', 'uploads/images/white.jpg', '2023-11-17 12:23:23', 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `pizzeriaexperience`
--

CREATE TABLE `pizzeriaexperience` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pizzeria_name` varchar(255) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `loaction` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `is_admin`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 1),
(3, 'user', 'user', 'user@user.com', 0),
(4, 'john_doe', 'password', 'john@example.com', 1),
(5, 'jane_smith', 'password', 'jane@example.com', 0),
(6, 'admin_user', 'password', 'admin@example.com', 1),
(7, 'regular_user', 'password', 'user@example.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `pizzarecipes`
--
ALTER TABLE `pizzarecipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `pizzeriaexperience`
--
ALTER TABLE `pizzeriaexperience`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizzarecipes`
--
ALTER TABLE `pizzarecipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pizzeriaexperience`
--
ALTER TABLE `pizzeriaexperience`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `pizzarecipes` (`recipe_id`);

--
-- Constraints for table `pizzarecipes`
--
ALTER TABLE `pizzarecipes`
  ADD CONSTRAINT `pizzarecipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `pizzarecipes_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `pizzeriaexperience`
--
ALTER TABLE `pizzeriaexperience`
  ADD CONSTRAINT `pizzeriaexperience_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
