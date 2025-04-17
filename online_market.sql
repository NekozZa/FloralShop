-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 01:58 AM
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
-- Database: `online_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Address` text DEFAULT NULL,
  `Role` enum('Customer','Admin','Seller') DEFAULT 'Customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`UserID`, `Username`, `Password`, `Address`, `Role`) VALUES
(1, 'alice', '123', '123 Maple St, CityA', 'Customer'),
(2, 'bob', '234', '456 Oak St, CityB', 'Seller'),
(3, 'admin1', 'admin_pw', 'Admin Office', 'Admin'),
(9, 'Tun', '1234', '2A, District 7', 'Seller'),
(13, 'robin', '12345', '65 Đ. Mai Chí Thọ, An Phú, Thủ Đức, Hồ Chí Minh', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`) VALUES
(1, 1),
(2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `CartItemID` int(11) NOT NULL,
  `CartID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitem`
--

INSERT INTO `cartitem` (`CartItemID`, `CartID`, `ProductID`, `Quantity`) VALUES
(75, 1, 1, 1),
(81, 2, 1, 1),
(82, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`) VALUES
(1, 'Electronics'),
(2, 'Clothing'),
(3, 'Books'),
(4, 'Home Appliances'),
(5, 'Toys & Games'),
(6, 'Sports Equipment'),
(7, 'Beauty & Personal Care'),
(8, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `Status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `PaymentMethod` varchar(100) DEFAULT NULL,
  `ShippingType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `UserID`, `OrderDate`, `Status`, `TotalAmount`, `Address`, `PaymentMethod`, `ShippingType`) VALUES
(1, 1, '2025-04-07 07:36:28', 'Processing', 999.97, '69 Mai Chi Tho, TP.HCM', NULL, NULL),
(14, 1, '2025-04-09 19:56:46', 'Pending', 1559.97, '123', NULL, NULL),
(15, 1, '2025-04-10 07:01:11', 'Pending', 1709.96, 'Nguyen Huu Tho', NULL, NULL),
(24, 1, '2025-04-11 19:21:49', 'Pending', 929.96, '123', 'Paypal', 'Regular'),
(29, 13, '2025-04-17 22:55:48', 'Pending', 854.98, '65 Đ. Mai Chí Thọ, An Phú, Thủ Đức, Hồ Chí Minh', 'Paypal', 'Regular'),
(30, 13, '2025-04-17 22:57:19', 'Pending', 854.98, '65 Đ. Mai Chí Thọ, An Phú, Thủ Đức, Hồ Chí Minh', 'Paypal', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Route` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`OrderItemID`, `OrderID`, `ProductID`, `Quantity`, `Price`, `Route`) VALUES
(1, 1, 1, 1, 699.99, ''),
(2, 1, 2, 2, 149.99, ''),
(3, 24, 1, 1, 699.99, ''),
(12, 30, 1, 1, 699.99, '106.688067,10.766781;106.753047,10.798109'),
(13, 30, 2, 1, 149.99, '106.688067,10.766781;106.753047,10.798109');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `PaymentDate` datetime DEFAULT current_timestamp(),
  `Amount` decimal(10,2) NOT NULL,
  `IsPaid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `OrderID`, `PaymentDate`, `Amount`, `IsPaid`) VALUES
(1, 1, '2025-04-07 07:36:28', 999.97, 1),
(2, 14, '2025-04-09 19:56:46', 1559.97, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ShopID` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `StockQuantity` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ShopID`, `Name`, `Description`, `Price`, `StockQuantity`, `CategoryID`, `ImageURL`) VALUES
(1, 1, 'Smartphone X', 'Latest model smartphone with 128GB storage', 699.99, 20, 1, 'public/images/smartphone.jpg'),
(2, 1, 'Bluetooth Headphones A', 'Noise-canceling over-ear headphones', 149.99, 50, 1, 'public/images/headphones.jpg'),
(3, 1, 'Denim Jacket', 'Stylish unisex denim jacket', 89.99, 15, 2, 'public/images/jacket.jpg'),
(4, 1, '4K Smart TV', 'Ultra HD Smart TV with voice control', 499.99, 10, 1, 'public/images/4ktv.jpg'),
(5, 1, 'Wireless Charger', 'Fast wireless charging pad for smartphones', 29.99, 50, 1, 'public/images/charger.jpg'),
(6, 1, 'Running Shoes', 'Lightweight breathable running shoes', 59.99, 25, 2, 'public/images/shoes.jpg'),
(7, 1, 'Casual T-Shirt', 'Cotton unisex T-shirt', 19.99, 100, 2, 'public/images/tshirt.jpg'),
(8, 1, 'The Alchemist', 'Best-selling novel by Paulo Coelho', 14.99, 40, 3, 'public/images/alchemist.jpg'),
(9, 1, 'Clean Code', 'Book on software craftsmanship by Robert C. Martin', 39.99, 15, 3, 'public/images/cleancode.jpg'),
(10, 1, 'Blender 900W', 'Multi-speed blender with glass jar', 89.99, 12, 4, 'public/images/blender.jpg'),
(11, 1, 'Microwave Oven', 'Compact microwave with digital timer', 109.99, 9, 4, 'public/images/microwave.jpg'),
(12, 1, 'Remote Control Car', 'High-speed rechargeable RC car', 44.99, 35, 5, 'public/images/rccar.jpg'),
(13, 1, 'Puzzle Game 1000pcs', 'Beautiful landscape puzzle for adults', 17.99, 60, 5, 'public/images/puzzle.jpg'),
(14, 1, 'Basketball', 'Official size and weight', 25.99, 20, 6, 'public/images/basketball.jpg'),
(15, 1, 'Tennis Racket', 'Lightweight racket with carry bag', 69.99, 15, 6, 'public/images/tennisracket.jpg'),
(16, 1, 'Shampoo & Conditioner Set', 'For all hair types, sulfate-free', 18.99, 30, 7, 'public/images/shampoo.jpg'),
(17, 1, 'Electric Hair Trimmer', 'Cordless rechargeable grooming kit', 34.99, 18, 7, 'public/images/trimmer.jpg'),
(18, 1, 'Foldable Study Desk', 'Compact desk for small spaces', 89.99, 7, 8, 'public/images/studydesk.jpg'),
(19, 1, 'Bookshelf 5-Tier', 'Modern wooden bookshelf', 129.99, 6, 8, 'public/images/bookshelf.jpg'),
(20, 1, 'Air Fryer Pro', 'Healthier frying with little to no oil', 129.99, 10, 4, 'public/images/airfryer.jpg'),
(21, 1, 'LEGO Creator Set', 'Build multiple models with one LEGO set', 59.99, 30, 5, 'public/images/lego.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
--

CREATE TABLE `productreview` (
  `ReviewID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comment` text DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productreview`
--

INSERT INTO `productreview` (`ReviewID`, `ProductID`, `UserID`, `Rating`, `Comment`, `CreateDate`) VALUES
(1, 1, 1, 5, 'Amazing phone, very fast and sleek!', '2025-04-07 07:36:28'),
(2, 2, 1, 4, 'Good sound quality but a bit tight on the head.', '2025-04-07 07:36:28'),
(7, 1, 1, 4, 'This item is really GOOD!!', '2025-04-09 09:52:22'),
(8, 1, 1, 5, 'This phone is too STRONG!!!', '2025-04-11 19:40:03'),
(9, 2, 1, 2, 'The sound quality is extremely bad!!!', '2025-04-15 21:00:01'),
(10, 2, 1, 1, 'The ear cups are too heavy. How can people use it?', '2025-04-15 21:00:53'),
(11, 2, 1, 3, 'It is not too good for the price.', '2025-04-15 21:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `ShippingID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ShippedDate` datetime DEFAULT NULL,
  `DeliveryDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`ShippingID`, `OrderID`, `ShippedDate`, `DeliveryDate`) VALUES
(1, 1, '2025-04-07 07:36:28', '2025-04-12 07:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `ShopID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`ShopID`, `UserID`, `Name`, `Description`, `Address`) VALUES
(1, 2, 'HotMate', 'Small Shop', '1189C Cống Quỳnh Street, Nguyễn Cư Trinh Ward, District 1'),
(3, 9, 'CellphoneX', 'Better Phones', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`CartItemID`),
  ADD KEY `CartID` (`CartID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `ShopID` (`ShopID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`ShippingID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`ShopID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cartitem`
--
ALTER TABLE `cartitem`
  MODIFY `CartItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `ShippingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `ShopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`);

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`),
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`),
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`ShopID`) REFERENCES `shop` (`ShopID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `productreview_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `productreview_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
