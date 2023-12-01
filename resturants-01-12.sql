-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2023 at 10:05 AM
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
-- Database: `resturants`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$23VuFKXVhY0JfwHlkyvYT.QDWyRBatkP8uLEORqM8b/J43zy1DR3.');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'raydah'),
(3, 'Jedah');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Customer_id` int(11) NOT NULL,
  `Customer_name` varchar(250) NOT NULL,
  `Customer_username` varchar(250) NOT NULL,
  `Customer_password` varchar(100) NOT NULL,
  `Customer_address` varchar(250) NOT NULL,
  `Customer_phone` varchar(50) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Customer_id`, `Customer_name`, `Customer_username`, `Customer_password`, `Customer_address`, `Customer_phone`, `city_id`) VALUES
(1, 'mohamed', 'mohamed', '$2y$10$OxKkqJRxeDhu/cZNZcOiDePeNU1myEivPJh6Lf7rQDInzfim9CiAq', 'sheben', '01095081882', 1),
(4, 'Mohamed Gamal', 'admin@admin.com2', '$2y$10$OxKkqJRxeDhu/cZNZcOiDePeNU1myEivPJh6Lf7rQDInzfim9CiAq', '123456', '01020304050', 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `delivery_name` varchar(250) NOT NULL,
  `delivery_username` varchar(250) NOT NULL,
  `delivery_password` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `delivery_phone` varchar(50) NOT NULL,
  `delivery_address` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `delivery_name`, `delivery_username`, `delivery_password`, `city_id`, `delivery_phone`, `delivery_address`) VALUES
(2, 'sayed', 'sayed', '$2y$10$.hl18sTw18IET6vhUnKuO.cryxUixzEkQCoM/Us1FU5z9seKuff5W', 1, '01020304050', 'losangelos memo');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(250) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `cat_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`cat_id`, `cat_name`, `restaurant_id`, `cat_image`) VALUES
(1, 'Desert', 1, 'uploads/categories/cat1.png');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `item_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_description` text NOT NULL,
  `item_price` double NOT NULL,
  `item_ingredients` text NOT NULL,
  `item_image` varchar(500) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`item_id`, `restaurant_id`, `item_name`, `item_description`, `item_price`, `item_ingredients`, `item_image`, `cat_id`) VALUES
(1, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(2, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(3, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(4, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(5, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(7, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1),
(8, 1, 'Fattoush Salad', 'Fattoush salad is a fresh and vibrant Middle Eastern salad known for its combination of crisp vegetables and toasted pita bread. It\'s a light and refreshing dish with a lemony, tangy dressing that\'s perfect for warm weather. Fattoush is not only delicious but also a celebration of colors, textures, and flavors.', 15.5, 'Vegetables,Pita Bread\r\n', 'uploads/products/pro2.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `order_status` enum('new','accepted','refused','on_way','ended','delivery_accepted') DEFAULT 'new',
  `address` varchar(1000) DEFAULT NULL,
  `order_total_price` double(10,4) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `order_status`, `address`, `order_total_price`, `customer_id`, `restaurant_id`, `delivery_id`) VALUES
(3, '2023-11-30', 'ended', 'الرياض', 31.0000, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `item_id`, `qty`, `price`, `total`) VALUES
(4, 3, 1, 2, 15.5, 31);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(11) NOT NULL,
  `restaurant_name` varchar(200) NOT NULL,
  `restaurant_address` text NOT NULL,
  `restaurant_phone` varchar(100) NOT NULL,
  `restaurant_username` varchar(250) NOT NULL,
  `restaurant_password` varchar(250) NOT NULL,
  `city_id` int(11) NOT NULL,
  `restaurant_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `restaurant_name`, `restaurant_address`, `restaurant_phone`, `restaurant_username`, `restaurant_password`, `city_id`, `restaurant_image`) VALUES
(1, 'Le Jardin Enchanté22', '23 Main Street, New York, NY', '845120', 'first res', '$2y$10$Lo5mwLqbSeZ7IPYgqLr3J.NtuRtbMsjW7WovvRbKIiLSCVv7.fYHS', 3, 'uploads/restaurants/3402593786.jpg'),
(11, 'dalyceqy', 'kuhaq', '28', 'rijatiry', '$2y$10$Od7H6aMV5J4vscwCLayGYO4yysc65EtzcG9Ho6zsOO1b17wBU7nja', 1, 'uploads/restaurants/3402748232.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_customer_id` (`customer_id`),
  ADD KEY `cart_item_id` (`item_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Customer_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `menu_cat_rest_fk` (`restaurant_id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `menu_item_restaurants` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`),
  ADD KEY `rest_cities_fk` (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `Customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`Customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_id` FOREIGN KEY (`item_id`) REFERENCES `menu_item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD CONSTRAINT `menu_cat_rest_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `menu_categories` (`cat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_item_restaurants` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`Customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`Delivery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `rest_cities_fk` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
