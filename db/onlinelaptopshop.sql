-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 04:14 PM
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
-- Database: `onlinelaptopshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `allorder`
--

CREATE TABLE `allorder` (
  `all_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allorder`
--

INSERT INTO `allorder` (`all_order_id`, `user_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 1, 20, 6, 1, 35.00),
(3, 1, 27, 14, 2, 32.00),
(5, 1, 29, 6, 1, 35.00),
(6, 1, 30, 8, 1, 34222.00),
(7, 1, 31, 6, 1, 35.00),
(8, 1, 32, 6, 1, 34.00),
(9, 1, 33, 6, 1, 34.00),
(46, 1, 70, 23, 3, 35.00),
(47, 1, 71, 23, 3, 35.00),
(48, 1, 72, 23, 5, 35.00),
(49, 1, 73, 6, 1, 34.00),
(50, 1, 74, 25, 1, 15.00),
(51, 14, 75, 6, 2, 34.00),
(52, 14, 76, 6, 1, 34.00),
(53, 14, 77, 29, 2, 1.00),
(54, 1, 79, 29, 2, 1.00),
(55, 1, 80, 24, 1, 543.00);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(8, 1, 6, 7),
(10, 1, 14, 4),
(11, 1, 16, 3),
(14, 1, 8, 2),
(15, 1, 19, 1),
(17, 1, 23, 5),
(18, 13, 6, 1),
(19, 14, 6, 1),
(20, 14, 29, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `attachment_link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `timestamp`, `attachment_link`, `is_read`) VALUES
(2, 2, 1, 'hi harb harb', '2024-12-12 21:38:05', NULL, 1),
(3, 2, 14, 'hi christian', '2024-12-12 21:47:39', NULL, 0),
(5, 1, 2, 'hello kamusta ?', '2024-12-12 22:49:28', NULL, 1),
(6, 1, 2, 'migo ta ha ?', '2024-12-12 22:49:36', NULL, 1),
(12, 2, 1, 'hello, this is admin Chris ano po update ?', '2024-12-13 00:05:33', NULL, 1),
(13, 1, 2, 'Naa diha si Kent ?', '2024-12-13 00:07:07', NULL, 1),
(14, 2, 1, 'wala padaw', '2024-12-13 00:07:19', NULL, 1),
(15, 2, 1, 'ito po ba order nyu ?', '2024-12-13 00:16:36', 'uploads/messagingAttachments/1734020196_Macbook.jpg', 1),
(16, 1, 2, 'Oo po, magkano po ba lahat?', '2024-12-13 00:31:32', NULL, 1),
(17, 2, 1, 'secret imo palang e myday', '2024-12-13 00:33:19', NULL, 1),
(18, 2, 1, 'hello po ?', '2024-12-13 01:00:48', NULL, 1),
(19, 2, 1, 'test', '2024-12-13 01:00:54', NULL, 1),
(20, 2, 1, 'what ?', '2024-12-13 01:03:53', 'uploads/messagingAttachments/1734023033_Dell Vostro.jpg', 1),
(21, 2, 1, 'thus ?', '2024-12-13 01:07:44', 'uploads/messagingAttachments/1734023264_lenovo.jpg', 1),
(22, 2, 1, 'helo', '2024-12-13 01:25:34', NULL, 1),
(31, 1, 2, 'hhh', '2024-12-13 02:10:08', NULL, 1),
(36, 1, 2, 'ito po ?', '2024-12-13 02:12:16', 'uploads/messagingAttachments/1734027136_ROG Strix.jpg', 1),
(38, 1, 2, 'yes po ?', '2024-12-13 03:28:02', 'uploads/messagingAttachments/1734031682_lenovo legion.jpg', 1),
(39, 1, 2, 'Wla po', '2024-12-13 03:28:49', NULL, 1),
(40, 2, 1, 'sige po', '2024-12-13 03:29:20', NULL, 1),
(41, 1, 1, 'Return Request for Order #40 - ASUS TUF\nReason: wow', '2024-12-13 13:55:52', '675bcc6820e0d.jpg', 0),
(42, 1, 2, 'Return Request for Order #40\nReason: wow', '2024-12-13 14:04:50', 'uploads/messagingAttachments/675bce821f09a.jpg', 1),
(43, 1, 2, 'Return Request for Order #40\nReason: ito po siya', '2024-12-13 14:08:06', 'uploads/messagingAttachments/675bcf4652283.jpg', 1),
(44, 2, 1, 'hala maam di nana pwde, sumabagayon ta nlang na', '2024-12-13 14:09:43', NULL, 1),
(45, 1, 2, 'Return Request for Order #40\nReason: may crack sa ulo', '2024-12-13 14:56:20', 'uploads/messagingAttachments/675bda947a578.jpg', 1),
(46, 1, 2, 'Pa check po kung may sakit to ', '2024-12-13 15:22:25', 'uploads/messagingAttachments/1734074545_PXL_20241212_105726098.jpg', 1),
(47, 2, 1, 'anong sira nang 2 order nyo po ?', '2024-12-13 15:23:09', NULL, 1),
(48, 1, 2, 'Wow', '2024-12-13 15:28:04', NULL, 1),
(49, 2, 1, 'huh?', '2024-12-13 15:50:54', NULL, 1),
(50, 1, 2, 'Wala lang', '2024-12-13 15:51:55', NULL, 1),
(51, 2, 1, 'weeeeehh ?', '2024-12-13 15:52:06', NULL, 1),
(52, 13, 2, 'Hello Mr admin', '2024-12-13 15:52:46', NULL, 1),
(53, 2, 13, 'hi', '2024-12-13 15:52:56', NULL, 1),
(54, 13, 2, 'Whahwhwhew', '2024-12-13 15:53:13', 'uploads/messagingAttachments/1734076393_1733934195076.jpg', 1),
(55, 13, 2, 'Hello po?', '2024-12-13 16:08:25', NULL, 1),
(56, 13, 2, 'Hiii', '2024-12-13 16:12:55', NULL, 1),
(57, 13, 2, 'Pa reply maam', '2024-12-13 16:16:01', NULL, 1),
(58, 2, 13, 'ay pasensya po', '2024-12-13 16:22:27', NULL, 1),
(59, 13, 2, 'Okay langs', '2024-12-13 16:23:02', NULL, 1),
(60, 13, 2, 'Hello test 123', '2024-12-13 16:26:25', NULL, 1),
(61, 13, 2, 'Hdcje', '2024-12-13 16:26:43', NULL, 1),
(62, 13, 2, 'Hiiii', '2024-12-13 16:31:47', NULL, 1),
(63, 13, 2, 'Ma\\\'am ?', '2024-12-13 16:31:59', NULL, 1),
(64, 13, 2, '', '2024-12-13 16:32:00', NULL, 1),
(65, 13, 2, 'Ma\\\'am ?', '2024-12-13 16:32:06', NULL, 1),
(66, 13, 2, 'Ma\\\'am ?', '2024-12-13 16:32:11', NULL, 1),
(67, 13, 2, 'Maam ', '2024-12-13 16:32:21', NULL, 1),
(68, 13, 2, 'Djdj fjdj fejjcd', '2024-12-13 16:32:26', NULL, 1),
(69, 1, 2, 'Hello ?', '2024-12-13 16:32:49', NULL, 1),
(70, 1, 2, 'Boss ?', '2024-12-13 16:35:51', NULL, 1),
(71, 2, 1, 'Pre', '2024-12-13 16:47:25', NULL, 1),
(72, 2, 1, 'hi papa carl', '2024-12-13 16:56:18', NULL, 1),
(73, 1, 2, 'Hello', '2024-12-13 16:56:19', NULL, 1),
(74, 2, 1, 'hey ', '2024-12-13 16:56:27', NULL, 1),
(75, 2, 1, 'bayot kaman', '2024-12-13 16:56:33', NULL, 1),
(76, 2, 1, 'Nigga', '2024-12-13 16:59:14', NULL, 1),
(77, 2, 1, 'Boss', '2024-12-13 17:03:22', NULL, 1),
(78, 2, 1, 'Boss ?', '2024-12-13 17:03:57', NULL, 1),
(79, 2, 1, 'Boss?', '2024-12-13 17:07:40', NULL, 1),
(80, 1, 2, 'boss ?', '2024-12-13 17:07:59', NULL, 1),
(81, 2, 1, 'Dskc', '2024-12-13 17:18:24', NULL, 1),
(82, 2, 1, 'Bhgg', '2024-12-13 17:19:27', NULL, 1),
(83, 1, 2, 'boss ?', '2024-12-13 17:29:24', NULL, 1),
(84, 2, 1, 'Yes boss ?', '2024-12-13 17:29:36', NULL, 1),
(124, 2, 1, 'Boss?', '2024-12-13 17:44:00', NULL, 1),
(164, 1, 2, 'Hello boss amo', '2024-12-13 17:53:05', NULL, 1),
(306, 1, 2, 'Boss amo', '2024-12-13 18:00:05', NULL, 1),
(337, 2, 1, 'boss', '2024-12-13 18:01:31', NULL, 1),
(343, 1, 2, 'Wla boss', '2024-12-13 18:01:46', NULL, 1),
(407, 1, 2, 'Hello po', '2024-12-13 19:16:12', NULL, 1),
(411, 2, 1, 'hiii', '2024-12-13 19:17:06', NULL, 1),
(417, 1, 2, 'Wala lang hahaha', '2024-12-13 19:21:38', NULL, 1),
(446, 2, 1, 'uy kasiaw', '2024-12-13 19:41:57', NULL, 1),
(447, 2, 1, 'who u ?', '2024-12-13 19:42:01', NULL, 1),
(449, 2, 13, 'hi ate jamjam', '2024-12-13 19:46:02', NULL, 1),
(450, 2, 1, 'boss ?', '2024-12-13 19:47:16', NULL, 1),
(458, 1, 2, 'Wala lang boss', '2024-12-13 19:47:39', NULL, 1),
(489, 2, 1, 'sige boss hahaha lab u', '2024-12-13 20:18:42', NULL, 1),
(495, 1, 2, 'Sige lab u', '2024-12-13 20:24:50', NULL, 1),
(499, 2, 1, 'what ? u gay homie ?', '2024-12-13 20:25:09', NULL, 1),
(504, 1, 2, 'Hinde ho', '2024-12-13 20:28:23', NULL, 1),
(509, 2, 1, 'ah sige', '2024-12-13 20:28:33', NULL, 1),
(512, 2, 1, 'oks raka ?', '2024-12-13 20:28:44', NULL, 1),
(528, 13, 2, 'Nigga what ?', '2024-12-13 20:30:12', NULL, 1),
(539, 2, 13, 'hey', '2024-12-13 20:41:21', NULL, 1),
(575, 2, 13, 'hello kint', '2024-12-13 20:44:15', NULL, 1),
(579, 13, 2, 'Hallow', '2024-12-13 20:44:25', NULL, 1),
(583, 2, 13, 'bayot', '2024-12-13 20:44:30', NULL, 1),
(585, 13, 2, 'Please help me', '2024-12-13 20:44:35', NULL, 1),
(592, 2, 13, 'no i dont want indians here you are a nigga', '2024-12-13 20:44:48', NULL, 1),
(593, 13, 2, 'I want to buy a laptop', '2024-12-13 20:44:50', NULL, 1),
(598, 2, 13, 'no no no', '2024-12-13 20:44:57', NULL, 1),
(600, 13, 2, 'Uno', '2024-12-13 20:45:00', NULL, 1),
(602, 13, 2, '', '2024-12-13 20:45:01', NULL, 1),
(605, 13, 2, 'Tay pids', '2024-12-13 20:45:05', NULL, 1),
(625, 2, 13, 'bordz', '2024-12-13 20:46:52', NULL, 1),
(645, 2, 13, 'endzil', '2024-12-13 20:47:51', NULL, 1),
(652, 2, 13, 'angel brought me here', '2024-12-13 20:48:26', NULL, 1),
(740, 1, 2, 'Return Request Details:\\r\\n                            Product: ASUS TUF edited\\r\\n                            Reason: Nawa Ang screen', '2024-12-14 00:16:49', 'uploads/messagingAttachments/1734106609_PXL_20241213_192129047.jpg', 1),
(903, 1, 2, 'Return Request Details:\\r\\nProduct: ASUS TUF i7 RTX\\r\\nReason: Test debug /r/n', '2024-12-14 00:25:31', 'uploads/messagingAttachments/1734107131_PXL_20241212_165247098.jpg', 1),
(1093, 1, 2, 'Return Request Details: Product: Macbook Pro M1 | Reason: May basag Ang side', '2024-12-14 00:48:08', 'uploads/messagingAttachments/1734108488_1733934195076.jpg', 1),
(1251, 1, 2, 'Return Request Details: Product: Lenovo Thinkpad | Reason: Nay guba Ang screen', '2024-12-14 01:12:16', 'uploads/messagingAttachments/1734109936_Screenshot_20241212-102130.png', 1),
(1345, 1, 2, 'Hello admin', '2024-12-14 01:22:44', NULL, 1),
(1350, 1, 2, 'May return request ako', '2024-12-14 01:22:53', NULL, 1),
(1356, 1, 2, 'Hello?', '2024-12-14 01:23:06', NULL, 1),
(1359, 2, 1, 'hi po', '2024-12-14 01:23:17', NULL, 1),
(1363, 2, 1, 'hihih', '2024-12-14 01:23:35', NULL, 1),
(1474, 1, 2, 'Return Request Details: Product: Macbook Pro M1 | Reason: may basag sa ulo po, ayaw mag function', '2024-12-16 19:38:25', 'uploads/messagingAttachments/1734349105_lenovo.jpg', 1),
(1483, 2, 1, 'hala bat mo sinira ang ulo? reject ka sakin', '2024-12-16 19:43:32', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `qty` int(255) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `carrier` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `payment_option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `order_date`, `qty`, `total_amount`, `carrier`, `status`, `payment_option`) VALUES
(42, 1, 23, '2024-12-09 22:04:07', 4, 136.00, 'LBC', 'Return Approved', 'Meet Up'),
(43, 1, 6, '2024-12-09 22:10:14', 2, 68.00, 'LBC', 'Canceled', 'Meet Up'),
(74, 1, 25, '2024-12-12 15:38:34', 1, 15.00, 'Lalamove', 'Return Complete', 'Cash on Delivery'),
(75, 14, 6, '2024-12-12 17:30:09', 2, 68.00, 'LBC', 'Complete', 'Cash on Delivery'),
(76, 14, 29, '2024-12-12 17:34:23', 1, 36.00, 'Food Panda', 'Pending', 'Cash on Pickup'),
(77, 14, 29, '2024-12-12 17:34:23', 2, 36.00, 'Food Panda', 'Return Complete', 'Cash on Pickup'),
(79, 1, 29, '2024-12-14 00:46:48', 2, 2.00, 'Lalamove', 'Return Complete', 'Cash on Delivery'),
(80, 1, 24, '2024-12-14 01:10:43', 1, 543.00, 'Ninja Express', 'Pending', 'Cash on Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `cpu` varchar(255) NOT NULL,
  `gpu` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `cpu`, `gpu`, `price`, `stock`, `image_url`) VALUES
(6, 'ASUS TUF i7 RTX', 'i7 - 15th gen RTX 5090 bitter Lake Kang Harley daw ni ana siya daw', 'i7 - 11th', 'RTX 5090 bitter Lake', 34.00, 10, '205270221-laptop sample.jpg'),
(23, 'Acer Nitro 5 AN515-58-50YE', '5 AN515-58-50YE', 'i5-13th wow', 'intel Iris', 35.00, 7, '1270804305-lenovo legion.jpg'),
(24, 'Lenovo Thinkpad', 'i5 - 8th gen pre owned but in good condition', 'i5-13th', 'intel UHD', 543.00, 2, '1043007146-lenovo.jpg'),
(25, 'ASUS TUF Green Avatar', 'testing edited ', 'i5 8th generator edited', 'RTX 5030 bitter Lake edited', 15.00, 5, '140598492-ROG Strix.jpg'),
(28, 'HP EliteBook 840 G4', 'Good condition in 2nd hand', 'i3 - 8th gen', 'GTX 1660', 32000.00, 0, '1679047157-dell.jpg'),
(29, 'Macbook Pro M1', 'aoiwjdsosdf', 'M1', 'M1 GPU', 1.00, 5, '1925266471-Macbook.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`return_id`, `order_id`, `user_id`, `reason`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(12, 41, 1, 'may igit sa iring', '675c578612304.jpg', 'Approved', '2024-12-13 15:49:26', '2024-12-13 16:37:42'),
(14, 42, 1, 'What ?', '675c5e4b64470.png', 'Approved', '2024-12-13 16:18:19', '2024-12-13 16:37:32'),
(15, 40, 1, 'Test debug /r/n', '675c5ff82a274.jpg', 'Approved', '2024-12-13 16:25:28', '2024-12-13 16:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` int(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `phone_number`, `location`, `email`, `status`, `otp`, `is_admin`) VALUES
(1, 'harveycasane', '$2y$10$cASgtynyWnGFhMsjyWjBOu8dlwFI7/YI6I1/LURlOahDwLh7aF.Me', 'Harvey', 'inchik', 944988781, 'Lilia Avenue Cogon Combado, Ormoc City, Leyte, Philippines', 'harveycasane1@gmail.com', 'verified', 0, 0),
(2, 'Admin', '$2y$10$2jNmAcm33sCnjKchuy9RbeWs7lT4PWHuL308oBYptaJJDeNw0DdOy', 'Mr. ', 'Admin', 944988781, 'Cogon rako boss', 'harvey.casane@evsu.edu.ph', 'verified', 996861, 1),
(3, 'DomenickMahusay', '$2y$10$3UZ7Py.XvG10CazSB0Qh6.GQ9xUbXENrBK3JMReBUIyamRafYx6fG', 'Domenick', 'bayot', 987654, 'Cebu. PH', 'harveycasane2@gmail.com', 'verified', 808640, 0),
(6, 'Christian', '$2y$10$1lsHd0Je9X3ILMAqEr5Jd.WBZtWzpY5XEktqNZ1RcwGm9RYQeZNhu', 'Christian', 'Dacera', 987654323, 'Lilia Avenue Cogon Combado, Ormoc City, Leyte, Philippines', 'harveycasane3@gmail.com', 'verified', 341198, 0),
(13, 'test edited', '$2y$10$e9AM.9y6HIuDG8RK3et.1OvCbQj9n7TDwBQ9TdRRwS/Y6EJJaKcMu', 'Ate ', 'Jamjam', 98668, 'Osmeña Extension Alegria, Ormoc City, Leyte, Philippines', 'jamabds48@gmail.com', 'verified', 823601, 0),
(14, 'Harvey', '$2y$10$EGULOd6HvVihgaBM6dLRTuIsY6hMQHPMCGmb.5nwbGr0Drn1bNIqO', 'Harvey', 'Casane', 944988781, 'Mongala, Democratic Republic of the Congo', 'harveycasane5@gmail.com', 'verified', 667766, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allorder`
--
ALTER TABLE `allorder`
  ADD PRIMARY KEY (`all_order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id_fk` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allorder`
--
ALTER TABLE `allorder`
  MODIFY `all_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1509;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allorder`
--
ALTER TABLE `allorder`
  ADD CONSTRAINT `allorder_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `allorder_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
