CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255),
  `password` varchar(255),
  `email` varchar(255),
  `role` int
);

CREATE TABLE `brands` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `description` text,
  `logo_url` varchar(255)
);

CREATE TABLE `phones` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `brand_id` int,
  `name` varchar(255),
  `description` text,
  `release_date` date,
  `image_url` varchar(255),
  `user_id` int
);

CREATE TABLE `phone_specs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `phone_id` int,
  `processor` varchar(255),
  `RAM` int,
  `storage` int,
  `camera` varchar(255),
  `display` varchar(255),
  `battery` varchar(255),
  `operating_system` varchar(255)
);

CREATE TABLE `comments` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `phone_id` int,
  `user_id` int,
  `comment_text` text,
  `created_at` timestamp
);

ALTER TABLE `phones` ADD FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

ALTER TABLE `phones` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `phone_specs` ADD FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
