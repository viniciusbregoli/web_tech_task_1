-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 07:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
(1, 'Samsung', 'https://cdn.icon-icons.com/icons2/3914/PNG/512/samsung_logo_icon_248596.png'),
(2, 'Apple', 'https://cdn-icons-png.flaticon.com/512/0/747.png'),
(3, 'Google', 'https://brandlogo.org/wp-content/uploads/2024/05/Google-Pixel-Logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `brand_id`) VALUES
(1, 'Galaxy Note', 1),
(2, 'Galaxy Z Flip', 1),
(3, 'iPhone PRO', 2),
(4, 'iPhone SE', 2),
(5, 'iPhone MINI', 2),
(6, 'Pixel', 3),
(7, 'Pixel PRO', 3);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `submitted_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`, `submitted_date`) VALUES
(1, 'teste', 'teste@hotmail.com', 'very good :)', '2024-12-15 18:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('new','in_process','shipped','finished','canceled','rejected') NOT NULL DEFAULT 'new',
  `rejection_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `username`, `total_price`, `order_date`, `status`, `rejection_reason`) VALUES
(72, 'Teste', 11888.10, '2024-12-15 18:14:43', 'finished', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_with_tax` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `price_with_tax`) VALUES
(71, 72, 5, 10, 999.00, 1188.81);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `brand_id`, `data`) VALUES
(1, 'Galaxy Note 10', 212, 1, 1, '{\"description\": [\"<strong>6.3″ Full Rectangle Display</strong></br></br>Dynamic AMOLED</br>\",                          \"<strong>Octa-Core CPU</strong>\", \"<strong>Auto Focus</strong>\", \"<strong>Optical Zoom at 2x, Digital Zoom up to 10x</strong>\", \"<strong>UHD 4K (3840 x 2160)@60fps Video Recording Resolution</strong>\"], \"imagepath\": \"https://m.media-amazon.com/images/I/51NrtwFcK0L.jpg\", \"colors\": [\"Aura Black\", \"Aura Glow\", \"Aura White\", \"Aura Pink\"], \"storage\": [128, 256, 512]}'),
(2, 'Galaxy Note 20', 352, 1, 1, '{\"description\": [\"<strong>6.9″ Full Rectangle Display</strong></br></br>Dynamic AMOLED 2X</br>\", \"<strong>Octa-Core CPU</strong>\", \"<strong>Auto Focus</strong>\", \"<strong>Optical Zoom at 5x, Digital Zoom up to 50x</strong>\", \"<strong>UHD 8K (7680 x 4320)@24fps Video Recording Resolution</strong>\"], \"imagepath\": \"https://www.backmarket.de/cdn-cgi/image/format%3Dauto%2Cquality%3D75%2Cwidth%3D1080/https://d2e6ccujb3mkqf.cloudfront.net/e92a33f6-6986-4703-9ebf-e98cdb364a80-1_a215923e-d826-4d87-a739-8023efadd638.jpg\", \"colors\": [\"Mystic Bronze\", \"Mystic Black\", \"Mystic White\"], \"storage\": [128, 256, 512]}'),
(3, 'Galaxy Z Flip 5', 456, 2, 1, '{\"description\": [\"<strong>6.7″ Full Rectangle Display 6.6″ Rounded Corners</strong></br></br>Dynamic AMOLED 2X</br>\", \"<strong>Octa-Core CPU</strong>\", \"<strong>Auto Focus</strong>\", \"<strong>Digital Zoom up to 10x</strong>\", \"<strong>UHD 4K (3840 x 2160)@60fps Video Recording Resolution</strong>\"], \"imagepath\": \"https://www.dimprice.de/image/cache/catalog/Samsung/samsung-galaxy-z-flip5-de-lavender-1-843x1080.png\", \"colors\": [\"Gray\", \"Green\", \"Blue\", \"Yellow\", \"Mint\", \"Cream\"], \"storage\": [256, 512]}'),
(4, 'Galaxy Z Flip 6', 832, 2, 1, '{\"description\": [\"<strong>6.7″ Full Rectangle Display 6.6″ Rounded Corners</strong></br></br>Dynamic AMOLED 2X</br>\", \"<strong>Octa-Core CPU</strong>\", \"<strong>Auto Focus</strong>\", \"<strong>Optical Zoom 2x</strong>\", \"<strong>UHD 4K (3840 x 2160)@60fps</strong>\"], \"imagepath\": \"https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQEI1Isb8GLyPXnGI8wTSz9l7ysnH7yHbyQsMusOMHC6H_aY4wif7vdwY8Q7-PDDemln6vp5WHgvvf1P7s8Lkl0KwbNSSbB71Mhg4XS38mTi4vUlN4lUlySZDk\", \"colors\": [\"Silver Shadow\", \"Mint\", \"Blue\", \"Yellow\", \"Peach\", \"White\"], \"storage\": [256, 512]}'),
(5, 'iPhone 16 Pro', 999, 3, 2, '{\"description\": [\"<strong>6.3″ Display</strong></br></br>Super Retina XDR display\", \"<strong>A18 Pro chip with 6-core GPU</strong>\", \"<strong>Pro camera system</strong>\", \"<strong>Dynamic Island</strong>\", \"<strong>Up to 33 hours video playback</strong>\"], \"imagepath\": \"https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcQ8a7NqYSDPGwgUbSVPIFTuxZJ5vMGV_Ol9mw2cxvVxgpZ3vt68mKnV9QrpKIX21VztP52lbIoDSKlVvfYvwC45Yq9Mx5GoplMOgyw-lG8\", \"colors\": [\"Desert Titanium\", \"Natural Titanium\", \"White Titanium\", \"Black Titanium\"], \"storage\": [128, 256, 512, 1000]}'),
(6, 'iPhone 16 Pro Max', 1199, 3, 2, '{\"description\": [\"<strong>6.9″ Display</strong></br></br>Super Retina XDR display</br>ProMotion technology</br>Always-On display\", \"<strong>A18 Pro chip with 6-core GPU</strong>\", \"<strong>Camera Control</strong></br></br>Easier way to capture</br>Faster access to photo and video tools</br>\", \"<strong>Pro camera system</strong></br></br>48MP Fusion | 48MP Ultra Wide | Telephoto</br>Super-high-resolution photos</br>(24MP and 48MP)</br>Next-generation portraits with Focus and Depth Control</br>48MP macro photography</br>Dolby Vision up to 4K at 120 fps</br>Spatial photos and videos</br>Latest-generation Photographic Styles\", \"<strong>Up to 10x optical zoom range</strong>\", \"<strong>Dynamic Island</strong></br></br>A magical way to interact with iPhone</br>\", \"<strong>Up to 33 hours video playback</strong>\", \"<strong>USB‑C Supports USB 3</strong>\", \"<strong>Face ID</strong>\"], \"imagepath\": \"https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone-16-pro-storage-select-202409-6-9inch-whitetitanium?wid=5120&hei=2880&fmt=webp&qlt=70&.v=cHljZ3VQbTFnaDEvbFVKOExvRXVPbEIvTXY5NjBUQVhVcnFORUt4SFI2QjZWa0tEKzJJVCt5eTJFK2JJWGNCaSs0TUpxVnlUVzdUUzFWcnFmdUNUYVNSTUMybCtXNXZpclhWeFpYZUcvRk80dEcwRGlZdHZNUlUyQVJ1QXFtSFFyMHcrM3ZYajViVWN1YS9acllvclpn&traceId=1\", \"price\": 1199, \"colors\": [\"Desert Titanium\", \"Natural Titanium\", \"White Titanium\", \"Black Titanium\"], \"storage\": [128, 256, 512, 1000]}'),
(7, 'iPhone SE', 429, 4, 2, '{\"description\": [\"<strong>4.7″ Display</strong></br></br>Retina HD display</br>\", \"<strong>A15 Bionic chip with 4-core GPU</strong>\", \"<strong>Single-camera system</strong></br></br>12MP Main</br>Portrait mode with Depth Control\", \"<strong>1x optical zoom range</strong>\", \"<strong>Up to 15 hours video playback</strong>\", \"<strong>Lightning Supports USB 2</strong>\", \"<strong>Touch ID</strong>\"], \"imagepath\": \"https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone-se-finish-unselect-gallery-1-202207?wid=5120&hei=2880&fmt=webp&qlt=70&.v=VEhreGxMWU8vckorVEJ3dVU2RjJZZFgrSXpWVEhWaW9YTGlWRHFoSHU0L3R6NnhRaHBRWDl3NFJZMDZlMGtTTWd2S3NaRzcrU0dmYjNHTUFiMnlsWFRocXAvNjVVaCtjTTZGTUNzOU8wNkdHQitiblNSUmw5N2I0WHR6NmEySjM&traceId=1\", \"price\": 429, \"colors\": [\"Midnight\", \"Starlight\", \"Red\"], \"storage\": [64, 128, 256]}'),
(8, 'iPhone SE 2', 472, 4, 2, '{\"description\": [\"<strong>4.7″ Display</strong></br></br>Retina HD display</br>\", \"<strong>A13 Bionic chip with 4-core GPU</strong>\", \"<strong>Single-camera system</strong></br></br>12MP Main</br>Portrait mode advanced bokeh and Depth Control\", \"<strong>Digital zoom up to 5x</strong>\", \"<strong>Up to 13 hours video playback</strong>\", \"<strong>Touch ID</strong>\"], \"imagepath\": \"https://cdn.alloallo.media/catalog/product/apple/iphone/iphone-se/iphone-se-white.jpg\", \"price\": 472, \"colors\": [\"Black\", \"White\", \"Red\"], \"storage\": [64, 128, 256]}'),
(9, 'iPhone MINI 12', 278, 5, 2, '{\"description\": [\"<strong>5.4″ Display</strong></br></br>Super Retina XDR display</br>\", \"<strong>A14 Bionic chip with 4-core GPU</strong>\", \"<strong>Wide and Ultra Wide cameras</strong></br></br>Dual 12MP</br>Portrait mode advanced bokeh and Depth Control\", \"<strong>Digital zoom up to 5x</strong>\", \"<strong>Up to 15 hours video playback</strong>\", \"<strong>Face ID</strong>\"], \"imagepath\": \"https://m.media-amazon.com/images/I/71sNNCTfMuL.jpg\", \"price\": 278, \"colors\": [\"Black\", \"White\", \"Red\", \"Green\", \"Blue\", \"Purple\"], \"storage\": [64, 128, 256]}'),
(10, 'iPhone MINI 13', 376, 5, 2, '{\"description\": [\"<strong>5.4″ Display</strong></br></br>Super Retina XDR display</br>\", \"<strong>A15 Bionic chip with 4-core GPU</strong>\", \"<strong>Main and Ultra Wide cameras</strong></br></br>Dual 12MP</br>Portrait mode with advanced bokeh and Depth Control\", \"<strong>Digital zoom up to 5x</strong>\", \"<strong>Up to 17 hours video playback</strong>\", \"<strong>Face ID</strong>\"], \"imagepath\": \"https://i.ebayimg.com/images/g/kXQAAOSwJB9ijDsk/s-l400.jpg\", \"price\": 376, \"colors\": [\"Starlight\", \"Midnight\", \"Red\", \"Blue\", \"Green\", \"Pink\"], \"storage\": [128, 256, 512]}'),
(11, 'Google Pixel 8', 448, 6, 3, '{\"description\": [\"<strong>6.2″-Vollbild-Display(157 mm) display</strong></br></br>Actua-Display</br>\", \"<strong>Google Tensor G3</strong></br></br>Titan M2 security chip</br>\", \"<strong>Smooth display (60–120 Hz)</strong>\", \"<strong>Fast wireless charging (Qi certified)</strong>\", \"<strong>More than 24 hours of battery life</strong></br></br>Up to 72 hours of battery life when using Extreme Power Saving Mode immediately after charging</br>\", \"<strong>Always-on display with live display and now playing</strong>\"], \"imagepath\": \"https://priceinto.pk/wp-content/uploads/2024/09/Google-Pixel-8-Price-in-Pakistan-2.webp\", \"price\": 448, \"colors\": [\"Hazel\", \"Mint\", \"Obsidian\", \"Rose\"], \"storage\": [128, 256]}'),
(12, 'Google Pixel 9', 560, 6, 3, '{\"description\": [\"<strong>1080×2424 with OLED at 422ppi</strong></br></br>160mm Actua full-screen display</br>\", \"<strong>Google Tensor G4</strong></br></br>Titan M2 security chip</br>\", \"<strong>Smooth display (60–120 Hz)</strong>\", \"<strong>Fast wireless charging (Qi certified)</strong>\", \"<strong>More than 24 hours of battery life</strong></br></br>Up to 100 hours of battery life when using Extreme Power Saving Mode immediately after charging</br>\", \"<strong>VPN from Google at no extra charge</strong>\"], \"imagepath\": \"https://lh3.googleusercontent.com/5AWVOm4Mr9WJjInCyKJByw9bFVC0N8XL1D-M0SQx7BohDYYjpXap_LY8MBN2f3qBPp62HxyEyCZioMEEYeTSjA6Av6RUJZFVlQ\", \"price\": 560, \"colors\": [\"Peony\", \"Wintergreen\", \"Porcelain\", \"Obsidian\"], \"storage\": [128, 256]}'),
(13, 'Google Pixel 9 Pro', 999, 7, 3, '{\"description\": [\"<strong>1280×2856 LTPO OLED at 495ppi</strong></br></br>161mm Super Actua display (LTPO)</br>\", \"<strong>Google Tensor G4</strong></br></br>Titan M2 security chip</br>\", \"<strong>Smooth display (1–120 Hz)</strong>\", \"<strong>Fast wireless charging (Qi certified)</strong>\", \"<strong>More than 24 hours of battery life</strong></br></br>Up to 100 hours of battery life when using Extreme Power Saving Mode immediately after charging</br>\", \"<strong>VPN from Google at no extra charge</strong>\"], \"imagepath\": \"https://cdn.movertix.com/media/catalog/product/cache/image/1200x/g/o/google-pixel-9-pro-xl-5g-rose-quartz-256gb.jpg\", \"price\": 999, \"colors\": [\"Porcelain\", \"Rose Quartz\", \"Hazel\", \"Obsidian\"], \"storage\": [128, 256, 512, 1000]}'),
(14, 'Google Pixel 9 Pro Fold', 1399, 7, 3, '{\"description\": [\"<strong>2076×2152 with OLED at 373ppi</strong></br></br>204 mm Super Actua-Flex full-screen display (LTPO)</br>\", \"<strong>Google Tensor G4</strong></br></br>Titan M2 security chip</br>\", \"<strong>Smooth display (60–120 Hz)</strong>\", \"<strong>Multi-alloy steel with a cover made of a high-strength aluminum alloy in aviation quality</strong>\", \"<strong>More than 24 hours of battery life</strong></br></br>Up to 72 hours of battery life when using Extreme Power Saving Mode immediately after charging</br>\", \"<strong>VPN from Google at no extra charge</strong>\"], \"imagepath\": \"https://mobile.1und1.de/_catalog/images/f5e37fc1fd35eb2e7208ee6e0d1b4fc4-img-google-pixel-9-Pro-Fold-obsidian-rechts.png\", \"price\": 1399, \"colors\": [\"Porcelain\", \"Obsidian\"], \"storage\": [256, 512]}');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `username`, `rating`, `review`, `review_date`) VALUES
(1, 5, 'Teste', 5, 'very good', '2024-12-15 18:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `user_order_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `blocked`, `is_admin`, `user_order_count`) VALUES
('admin', '$2y$10$3JsmX69rKqV78.if6iWZnubwnjTn/RPmdkwbgHpDa6IDz3tNQPeNa', 0, 1, 0),
('asdfA', '$2y$10$LQ3wyvmtGPOFHfzNBtCq7esnwjDlg40S4.rrsPoYveonO.P9FKFLS', 0, 0, 0),
('Teste', '$2y$10$K3greMpTb7wvZSUaUZSXPu.t1ofLsv2xzleekisp/o7HFV/ksjk0y', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
