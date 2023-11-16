-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 09:45 PM
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
-- Database: `winnipegcookingdiariesdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Appetizers'),
(2, 'Main Courses'),
(3, 'Desserts'),
(4, 'Salads'),
(5, 'Soups'),
(6, 'Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(400) NOT NULL,
  `preparation_time` int(11) DEFAULT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `servings` int(11) DEFAULT NULL,
  `difficulty_level` enum('Easy','Medium','Hard') DEFAULT NULL,
  `cuisine` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `description`, `image_url`, `preparation_time`, `cooking_time`, `servings`, `difficulty_level`, `cuisine`, `course`, `instructions`, `ingredients`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Beef Stroganoff', 'Beef Stroganoff is a hearty Russian dish made with tender beef, onions, mushrooms, and a creamy sauce. Serve it over egg noodles for a comforting meal.', 'uploads/images/Beef-stroganoff-2 (1).jpg', 30, 30, 4, 'Medium', 'Russian', 'Main Course', '1. Cut beef into thin strips and season with salt and pepper.\r\n      2. In a skillet, heat butter and brown the beef. Remove and set aside.\r\n      3. In the same skillet, sauté onions and mushrooms until tender.\r\n      4. Return the beef to the skillet and stir in sour cream and Dijon mustard.\r\n      5. Simmer until the sauce thickens.\r\n      6. Serve Beef Stroganoff over cooked egg noodles.', '500g beef sirloin, 1 onion, 200g mushrooms, 1 cup sour cream, 1 tbsp Dijon mustard, 2 tbsp butter, Salt, Black pepper, Egg noodles', 1, 2, '2023-11-09 05:57:53', '2023-11-16 20:29:51'),
(2, 'Lemon Garlic Shrimp Scampi', 'Lemon Garlic Shrimp Scampi is a quick and flavorful seafood pasta dish. Shrimp are sautéed in a lemon garlic butter sauce and tossed with linguine for a zesty meal.', 'uploads/images/lemon-garlic-shrimp-scampi.webp', 15, 15, 2, 'Easy', 'Italian', 'Main Course', '1. Cook linguine according to package instructions. Drain and set aside.\r\n      2. In a skillet, melt butter and sauté garlic and red pepper flakes until fragrant.\r\n      3. Add shrimp and cook until pink and opaque.\r\n      4. Stir in lemon juice and zest, white wine, and fresh parsley.\r\n      5. Toss cooked linguine with the shrimp and sauce.\r\n      6. Season with salt and black pepper.\r\n      7. Serve hot with a sprinkle of Parmesan cheese.', '250g linguine, 300g large shrimp, 4 cloves garlic, 1 lemon (juice and zest), 1/2 cup white wine, 2 tbsp butter, Red pepper flakes, Salt, Black pepper, Fresh parsley, Parmesan cheese', 2, 3, '2023-11-09 05:57:53', '2023-11-16 20:30:32'),
(3, 'Mango Salsa', '<p>Mango Salsa is a refreshing and tropical condiment that pairs well with grilled chicken, fish, or as a snack with tortilla chips.</p>', 'uploads/images/mango-salsa.jpg', 10, 0, 6, 'Easy', 'Mexicano', 'Appetizererrerer', '1. Dice mango, red onion, and red bell pepper.\r\n      2. Chop fresh cilantro and jalapeño.\r\n      3. Combine all ingredients in a bowl.\r\n      4. Squeeze lime juice over the mixture and stir to combine.\r\n      5. Refrigerate for at least 30 minutes before serving.', '2 ripe mangoes, 1/2 red onion, 1 red bell pepper, 1/4 cup fresh cilantro, 1 jalapeño, 1 lime, Salt', 1, 1, '2023-11-09 05:57:53', '2023-11-16 20:36:26'),
(4, 'Creamy Tomato Basil Soup', 'Creamy Tomato Basil Soup is a classic comfort food. It combines the richness of cream with the bright flavors of tomatoes and fresh basil.', 'uploads/images/8530112959_5515654e3c-2.jpg', 20, 25, 4, 'Medium', 'American', 'Soup', '1. In a large pot, sauté onions and garlic in olive oil until soft.\r\n      2. Add canned tomatoes, chicken broth, and fresh basil.\r\n      3. Simmer for 15 minutes.\r\n      4. Use an immersion blender to purée the soup.\r\n      5. Stir in heavy cream and season with salt and pepper.\r\n      6. Garnish with fresh basil leaves before serving.', '2 cans of whole tomatoes, 1 onion, 3 cloves garlic, 1/2 cup fresh basil, 2 cups chicken broth, 1 cup heavy cream, Olive oil, Salt, Black pepper', 4, 5, '2023-11-09 05:57:53', '2023-11-16 20:32:13'),
(5, 'Mushroom Risotto', 'Mushroom Risotto is a creamy and earthy Italian rice dish. Arborio rice is slowly cooked with mushrooms, white wine, and Parmesan cheese.', 'uploads/images/85389-gourmet-mushroom-risotto-86-7a2d218f53e94ccfaecc69b6fd93cab8.jpg', 35, 30, 4, 'Medium', 'Italian', 'Side Dish', '1. Sauté onions and garlic in a large skillet until translucent.\r\n      2. Add Arborio rice and cook for a few minutes.\r\n      3. Stir in white wine and allow it to be absorbed.\r\n      4. Add chicken broth gradually while stirring.\r\n      5. Add sliced mushrooms and continue to cook until rice is creamy.\r\n      6. Stir in grated Parmesan cheese and butter.\r\n      7. Season with salt and black pepper.', '1 1/2 cups Arborio rice, 1 onion, 2 cloves garlic, 200g mushrooms, 1/2 cup white wine, 4 cups chicken broth, 1/2 cup grated Parmesan cheese, 2 tbsp butter, Salt, Black pepper', 2, 1, '2023-11-09 05:57:53', '2023-11-16 20:32:33'),
(6, 'Greek Salad', 'Greek Salad is a fresh and colorful Mediterranean salad made with cucumbers, tomatoes, olives, feta cheese, and a zesty vinaigrette.', 'uploads/images/Greek-Salad-main.webp', 15, 0, 4, 'Easy', 'Greek', 'Salad', '1. Dice cucumbers, tomatoes, red onion, and bell pepper.\r\n      2. Combine vegetables in a bowl.\r\n      3. Add Kalamata olives and crumbled feta cheese.\r\n      4. Drizzle with olive oil and red wine vinegar.\r\n      5. Season with oregano, salt, and black pepper.\r\n      6. Toss to combine and serve.', '2 cucumbers, 4 tomatoes, 1/2 red onion, 1 red bell pepper, 1 cup Kalamata olives, 1/2 cup feta cheese, Olive oil, Red wine vinegar, Dried oregano, Salt, Black pepper', 3, 2, '2023-11-09 05:57:53', '2023-11-16 20:32:51'),
(7, 'Chocolate Lava Cake', 'Chocolate Lava Cake is a decadent dessert with a molten chocolate center. Serve it warm with a scoop of vanilla ice cream for the ultimate indulgence.', 'uploads/images/Chocolate-Lava-Cake-Recipe.jpg', 15, 15, 4, 'Medium', 'Dessert', 'Dessert', '1. Preheat the oven to 425°F (220°C).\r\n      2. In a microwave-safe bowl, melt chocolate and butter.\r\n      3. Stir in sugar, eggs, and vanilla extract.\r\n      4. Gradually add flour and mix until smooth.\r\n      5. Grease ramekins and pour in the batter.\r\n      6. Bake for 12-15 minutes.\r\n      7. Serve immediately with a dusting of powdered sugar and vanilla ice cream.', '4 oz dark chocolate, 1/2 cup unsalted butter, 1/4 cup sugar, 2 eggs, 1 tsp vanilla extract, 1/4 cup all-purpose flour, Powdered sugar, Vanilla ice cream', 4, 3, '2023-11-09 05:57:53', '2023-11-16 20:33:15'),
(8, 'Mango Lassi', 'Mango Lassi is a popular Indian yogurt-based drink. It combines ripe mangoes, yogurt, and a touch of cardamom for a refreshing beverage.', 'uploads/images/mango-lassi-2.webp', 10, 0, 2, 'Easy', 'Indian', 'Beverage', '1. Peel and chop ripe mangoes.\r\n      2. Blend mangoes, yogurt, sugar, and cardamom until smooth.\r\n      3. Chill the Mango Lassi and serve in glasses with a pinch of ground cardamom for garnish.', '2 ripe mangoes, 1 cup yogurt, 2 tbsp sugar, 1/4 tsp ground cardamom', 5, 5, '2023-11-09 05:57:53', '2023-11-16 20:33:43'),
(9, 'Caprese Salad', 'Caprese Salad is a simple and elegant Italian salad made with fresh tomatoes, mozzarella cheese, basil leaves, and a drizzle of balsamic glaze.', 'uploads/images/Caprese-Salad-main-1.webp', 10, 0, 2, 'Easy', 'Italian', 'Salad', '1. Slice tomatoes and mozzarella cheese.\r\n      2. Arrange tomato and mozzarella slices with fresh basil leaves.\r\n      3. Drizzle with balsamic glaze.\r\n      4. Season with salt and black pepper.\r\n      5. Serve as an appetizer or side dish.', '4 ripe tomatoes, 8 oz mozzarella cheese, Fresh basil leaves, Balsamic glaze, Salt, Black pepper', 3, 4, '2023-11-09 05:57:53', '2023-11-16 20:34:09'),
(10, 'Spaghetti Carbonara', 'Spaghetti Carbonara is a classic Italian pasta dish made with eggs, cheese, pancetta, and black pepper. This creamy and savory pasta is a crowd-pleaser and a go-to recipe for a quick and delicious meal. Follow these steps to make a perfect Spaghetti Carbonara.', 'uploads/images/carbonara-horizontal-threeByTwoMediumAt2X-v2.jpg', 20, 15, 4, 'Easy', 'Italian', 'Main Course', '1. Bring a large pot of salted water to a boil.\r\n      2. Cook spaghetti according to package instructions until al dente. Reserve some pasta water.\r\n      3. In a skillet, cook pancetta until crispy.\r\n      4. In a bowl, whisk eggs and mix in grated Pecorino Romano cheese.\r\n      5. Drain cooked spaghetti and immediately transfer it to the skillet with pancetta.\r\n      6. Toss the spaghetti with pancetta, allowing it to cool slightly.\r\n      7. Quickly pour the egg and cheese mixture over the spaghetti, tossing it continuously.\r\n      8. Add reserved pasta water as needed to create a creamy sauce.\r\n      9. Season with black pepper and serve hot.', '200g spaghetti, 100g pancetta, 2 large eggs, 50g Pecorino Romano cheese, Salt, Black pepper', 1, 1, '2023-11-09 05:58:05', '2023-11-16 20:34:57'),
(11, 'Chicken Alfredo', 'Chicken Alfredo is a rich and creamy pasta dish that combines fettuccine, chicken, and a luxurious Alfredo sauce. This Italian-American classic is comfort food at its finest. Learn how to make Chicken Alfredo with this easy recipe.', '', 25, 20, 4, 'Medium', 'Italian', 'Main Course', '1. Season chicken breast with salt and pepper.\r\n      2. In a large skillet, heat olive oil and cook chicken until golden brown and cooked through. Set aside.\r\n      3. Cook fettuccine pasta according to package instructions. Drain.\r\n      4. In the same skillet, melt butter and sauté garlic until fragrant.\r\n      5. Stir in heavy cream and Parmesan cheese. Simmer until the sauce thickens.\r\n      6. Slice cooked chicken and add it to the sauce.\r\n      7. Season with salt and pepper.\r\n      8. Serve the creamy Alfredo sauce over cooked fettuccine and garnish with chopped parsley.', '300g fettuccine pasta, 2 boneless chicken breasts, 2 tbsp olive oil, 2 cloves garlic, 1 cup heavy cream, 1 cup grated Parmesan cheese, 2 tbsp butter, Salt, Black pepper, Fresh parsley', 2, 2, '2023-11-09 05:58:05', '2023-11-09 05:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'john_doe', 'john.doe@example.com', 'password1', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(2, 'jane_smith', 'jane.smith@example.com', 'password2', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(3, 'michael_johnson', 'michael.johnson@example.com', 'password3', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(4, 'susan_williams', 'susan.williams@example.com', 'password4', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(5, 'robert_brown', 'robert.brown@example.com', 'password5', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(6, 'lisa_davis', 'lisa.davis@example.com', 'adminpassword1', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(7, 'mark_miller', 'mark.miller@example.com', 'adminpassword2', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(8, 'emily_wilson', 'emily.wilson@example.com', 'editorpassword1', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(9, 'david_martin', 'david.martin@example.com', 'editorpassword2', '2023-11-09 05:57:40', '2023-11-09 05:57:40'),
(10, 'linda_jackson', 'linda.jackson@example.com', 'contributorpassword1', '2023-11-09 05:57:40', '2023-11-09 05:57:40');

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
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `category_id` (`category_id`),
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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
