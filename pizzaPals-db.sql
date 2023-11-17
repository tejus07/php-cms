CREATE TABLE `users` (
  `user_id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255),
  `password` varchar(255),
  `email` varchar(255),
  `is_admin` boolean
);

CREATE TABLE `pizzeriaExperience` (
  `review_id` integer PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `pizzeria_name` varchar(255),
  `review` text,
  `image_url` varchar(255),
  `loaction` varchar(255),
  `rating` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `pizzaRecipes` (
  `recipe_id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255),
  `ingredients` text,
  `instructions` text,
  `image_url` varchar(255),
  `created_at` datetime,
  `user_id` int,
  `category_id` int
);

CREATE TABLE `comments` (
  `comments_id` integer PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `recipe_id` int,
  `description` text,
  `created_at` timestamp
);

CREATE TABLE `categories` (
  `category_id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255)
);

ALTER TABLE `pizzeriaExperience` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `pizzaRecipes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `pizzaRecipes` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`recipe_id`) REFERENCES `pizzaRecipes` (`recipe_id`);
