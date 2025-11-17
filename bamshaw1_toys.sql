-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2025 at 11:41 PM
-- Server version: 10.6.24-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bamshaw1_toys`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `google_id`, `name`, `email`, `profile_image`, `created_at`) VALUES
(1, '110337028532789997857', 'Nimesh Shiwakoti', 'nimesh.shiwakoti@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocLvCUsEyvI8aqi03H9hBlnkksWxt1lYjZIOVGw_ccufAF4fN0Q=s96-c', '2025-11-11 23:57:39'),
(2, '114899392310948701456', 'Parbat Rai', 'echoesofparbat@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJXAD9WM8PFJLQ1TO6vd6FSja43rfd2cbJWYlcPzq60yry8p7w=s96-c', '2025-11-12 03:16:28'),
(3, '114941215535310325093', 'Satwik', 'satwiksam143@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocIytIOV5k5qZ1vG6lZbk-VJjXzO6S1IE2XUrwVBSfSiPMkWaA=s96-c', '2025-11-12 15:35:50'),
(4, '110789475150501337153', 'Priya Nandhini', 'nnandhu119@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKt8iBg-5y9JbZ6tdcgs5ezXz6B2wHAgPCo0jLODc549HX_Krep=s96-c', '2025-11-17 17:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` timestamp NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `image`) VALUES
(4, 'Electronic keyboard ', 'Electronic keyboard with microphone ', 'uploads/1000037835.jpg'),
(5, 'Baby Rattle', 'Baby Rattle set', 'uploads/1000037836.jpg'),
(6, 'Kitchen ware', 'Kitchen ware playing set', 'uploads/IMG_20240927_215956.jpg'),
(7, 'Speed match car bike aeroplane ', 'Car bike aeroplane ', 'uploads/1000037837.jpg'),
(8, 'LCD writing tablet', 'LCD writing tablet ', 'uploads/17274540419097632285461949051823.jpg'),
(9, 'Spider gun', 'Spider gun', 'uploads/IMG_20240927_220827.jpg'),
(10, 'Rubics cube', 'Rubics cube', 'uploads/IMG_20240927_221124.jpg'),
(11, 'Victory Gun', 'Battery operated sound gun', 'uploads/1000037838.jpg'),
(12, 'Vibration gun', 'Vibration gun ', 'uploads/IMG_20240927_221415.jpg'),
(13, 'Bouncing ball big', 'Big bouncing ball with rubber bands ', 'uploads/1000037839.jpg'),
(14, 'Basket ball net', 'Basketball net', 'uploads/IMG_20240927_221540.jpg'),
(15, 'Bouncing ball small ', 'Small bouncing ball with ring', 'uploads/1000037840.jpg'),
(16, 'LCD writing tablet 8.5 inch ', 'Tablet', 'uploads/IMG_20240927_221702.jpg'),
(17, 'Dancing cactus ', 'Dancing cactus ', 'uploads/IMG_20240927_221852.jpg'),
(18, 'Boxing bag with glove', 'Boxing bag with glove', 'uploads/1000037841.jpg'),
(19, 'Farm tractor ', 'Tractor with animals ', 'uploads/1000037842.jpg'),
(20, 'Remote control car ', 'Road master ', 'uploads/IMG_20240927_222210.jpg'),
(21, 'Remote control speed car', 'Speed car remote control ', 'uploads/IMG_20240927_222314.jpg'),
(22, 'Fierce car', 'Car ', 'uploads/1000037843.jpg'),
(23, 'Speed king remote car', 'Remote control car ', 'uploads/1000037844.jpg'),
(24, 'Avengers racing car', 'Racing car ', 'uploads/IMG_20240927_222540.jpg'),
(25, 'Remote control police car', 'Remote control car ', 'uploads/1000037845.jpg'),
(26, 'Badminton Shuttle cock plastic ', 'Plastic ', 'uploads/IMG_20240927_222724.jpg'),
(27, 'Badminton shuttlecock feather ', 'Badminton shuttlecock feather ', 'uploads/1000037846.jpg'),
(28, 'Sponze ball', 'Sponze ball', 'uploads/IMG_20240927_223009.jpg'),
(29, 'Electric rabbit ', 'Battery operated rabbit with music ', 'uploads/1000037847.jpg'),
(30, 'Remote control car ', 'Rc car', 'uploads/1000037848.jpg'),
(31, 'Remote control sport car', 'Operated with Battery ', 'uploads/IMG_20240927_223331.jpg'),
(32, 'Blasters shoot Dhanush ', 'Dhanush ', 'uploads/1000037849.jpg'),
(33, 'Table tennis set', 'Set with ball ', 'uploads/IMG_20240927_223604.jpg'),
(34, 'Gun shot', 'Gun with bullets ', 'uploads/1000037850.jpg'),
(35, 'Table tennis set with net ', 'With net ', 'uploads/IMG_20240927_223727.jpg'),
(36, 'Ring toy', 'Toy with ring ', 'uploads/1000037851.jpg'),
(37, 'Dog toy', 'Dog toy with baby', 'uploads/1000037852.jpg'),
(38, 'Cat toy small', 'Small cat', 'uploads/1000037853.jpg'),
(39, 'Dart game', 'Dart game with arrow ', 'uploads/IMG_20240927_224207.jpg'),
(40, 'Dog toy medium', 'Dog toy medium ', 'uploads/1000037854.jpg'),
(41, 'Fish bubble gun', 'Fish shaped bubble gun with liquid ', 'uploads/1000037855.jpg'),
(42, 'Slime small ', 'Colorful slime small ', 'uploads/IMG_20240927_224414.jpg'),
(43, 'Blocks game', '53 blocks', 'uploads/IMG_20240927_224605.jpg'),
(44, 'Momo key ring ', 'Key ring ', 'uploads/1000037856.jpg'),
(45, 'Orange key ring ', 'Key ring ', 'uploads/1000037862.jpg'),
(46, 'Gun card ', 'Gun card with 6 pieces arrow and 2 guns', 'uploads/IMG_20240927_224739.jpg'),
(47, 'Biscuit key ring ', 'Key ring ', 'uploads/1000037859.jpg'),
(48, 'Maize key ring ', 'Key ring ', 'uploads/1000037858.jpg'),
(49, 'Ice cream key ring ', 'Key ring ', 'uploads/1000037860.jpg'),
(50, 'French fries key ring ', 'Key ring ', 'uploads/1000037857.jpg'),
(51, 'Skipping ', 'Skipping rope', 'uploads/IMG_20240927_225009.jpg'),
(52, 'Rin tower 5 pieces ', 'Ring toy', 'uploads/1000037863.jpg'),
(53, 'Duck chu chu', 'Chu chu duck with baby ', 'uploads/1000037864.jpg'),
(54, 'Shrilling chicken ', 'Chicken toy ', 'uploads/1000037865.jpg'),
(55, 'Mr.yod football ', 'Football ⚽', 'uploads/IMG_20240927_225523.jpg'),
(56, 'Chu chu animal', 'Chu chu sounds animal', 'uploads/1000037866.jpg'),
(57, 'Mr.yod volleyball ', 'Volleyball ????', 'uploads/IMG_20240927_225633.jpg'),
(58, 'Wild animals set', 'Wild animals set ', 'uploads/1000037867.jpg'),
(59, 'Spin toy', 'Spin toy ', 'uploads/IMG_20240927_225801.jpg'),
(60, 'Musical rubber horse ', 'Rubber horse air filled ', 'uploads/1000037869.jpg'),
(61, 'Tennis ball ', '3 piece tennis ball ', 'uploads/IMG_20240927_225925.jpg'),
(62, 'Wild animals set big', 'Wild animals set ', 'uploads/1000037870.jpg'),
(63, 'Clay', 'Colorful clay ', 'uploads/IMG_20240927_230140.jpg'),
(64, 'Bubble liquid ', 'Bubble liquid ', 'uploads/1000037871.jpg'),
(65, 'Foot ball', 'Shining football ', 'uploads/1000037872.jpg'),
(66, 'Chuchu with light', '5 different colours chuchu', 'uploads/IMG_20240927_230400.jpg'),
(67, 'Farm animal set', 'Farm animal set ', 'uploads/1000037873.jpg'),
(68, 'Basketball ball ????', 'Basketball ball ', 'uploads/IMG_20240927_230544.jpg'),
(69, 'Doll set', 'Doll set', 'uploads/1000037874.jpg'),
(70, 'Doll set', 'Doll set', 'uploads/1000037875.jpg'),
(71, 'Remote control 360 car', '360 car with remote control ', 'uploads/IMG_20240927_230829.jpg'),
(72, 'Badminton racket ', 'For adults ', 'uploads/1000037876.jpg'),
(73, 'Farming tool', 'Garden toy ', 'uploads/IMG_20240927_231133.jpg'),
(74, 'Badminton racket ', 'For kids ', 'uploads/1000037877.jpg'),
(75, 'Study table ', 'Black colour table', 'uploads/IMG_20240927_231228.jpg'),
(76, 'A to z mat', 'Mat', 'uploads/1000037878.jpg'),
(77, 'Trolley doll', 'Yellow colour trolley doll', 'uploads/IMG_20240927_231345.jpg'),
(78, 'Kids tent', 'Tent', 'uploads/1000037879.jpg'),
(79, 'Jcv set', 'Jcv set', 'uploads/1000037880.jpg'),
(80, 'Roller truck green', 'Roller truck green ', 'uploads/IMG_20240927_231530.jpg'),
(81, 'Blowing set', 'Blowing set ', 'uploads/1000037881.jpg'),
(82, 'Jcv 4 in 1', 'Jcv', 'uploads/1000037882.jpg'),
(83, 'Magic fairy set ', 'Baby girls fairy set', 'uploads/IMG_20240927_231944.jpg'),
(84, 'Number mat', 'Mat', 'uploads/1000037883.jpg'),
(85, 'Cute pet car', '4 in 1', 'uploads/IMG_20240927_232059.jpg'),
(86, 'Yo yo', 'Yo yo', 'uploads/1000037884.jpg'),
(87, 'Rabbit kitchen set ', 'Cute rabbit kitchen set ', 'uploads/IMG_20240927_232240.jpg'),
(88, 'Bablet toy big', 'Bablet', 'uploads/1000037885.jpg'),
(89, 'Bay blade small', 'Bay blade ', 'uploads/IMG_20240927_232334.jpg'),
(90, 'Blowing bubbles ', 'Blowing bubbles ', 'uploads/IMG_20240927_232734.jpg'),
(91, 'Off road car small ', 'Off road car', 'uploads/1000037886.jpg'),
(92, 'Wisthle bubble ', 'Small wishle bubble ', 'uploads/IMG_20240927_232924.jpg'),
(93, 'Off road car big', 'Off road car big ', 'uploads/1000037887.jpg'),
(95, 'Buttom bubble ', 'Buttom bubble big', 'uploads/IMG_20240927_233201.jpg'),
(96, 'Transformers  dino', 'Transformer toy', 'uploads/1000037888.jpg'),
(97, 'Abcd mat big', 'Big and small floor mat', 'uploads/IMG_20240927_233910.jpg'),
(98, '1234 mat small', 'Floor mats ', 'uploads/IMG_20240927_233910.jpg'),
(99, 'Transformers  car', 'Transformers ', 'uploads/1000037889.jpg'),
(100, 'Transformers  tank', 'Transformers car ', 'uploads/1000037890.jpg'),
(101, 'Bag medium ', 'Printed bag ', 'uploads/IMG_20240927_234132.jpg'),
(103, 'Bag small', 'Bag ', 'uploads/IMG_20240927_234530.jpg'),
(105, 'Bat ball', 'Bat ball ', 'uploads/1000037907.jpg'),
(106, 'Rabbit ', 'Rabbit ', 'uploads/1000037908.jpg'),
(107, 'Puppy dog', 'Dog', 'uploads/1000037909.jpg'),
(108, 'Future car', 'Car', 'uploads/1000037910.jpg'),
(109, 'Jeep', 'Jeep', 'uploads/1000037911.jpg'),
(110, 'Gun with bullets ', 'Gun ', 'uploads/1000037912.jpg'),
(111, 'Jcb', 'Jcb', 'uploads/1000037913.jpg'),
(112, 'Bike', 'Bike', 'uploads/1000037914.jpg'),
(113, 'Truck', 'Truck ', 'uploads/1000037915.jpg'),
(114, 'Gun', 'Gun', 'uploads/1000037916.jpg'),
(116, 'Gun', 'Gun', 'uploads/1000037918.jpg'),
(117, 'Doctor set', 'Doctor set', 'uploads/1000037919.jpg'),
(118, 'Mobile ', 'Mobile phone ', 'uploads/1000037920.jpg'),
(119, 'Pipe organ', 'Pipe organ', 'uploads/1000037921.jpg'),
(120, 'Gun', 'Gun', 'uploads/1000037922.jpg'),
(121, 'Ball small', 'Ball small ', 'uploads/1000037923.jpg'),
(122, 'Ball medium', 'Ball medium ', 'uploads/1000037923.jpg'),
(123, 'Bullets ', 'Bullets ', 'uploads/1000037924.jpg'),
(124, 'Light doll', 'Doll', 'uploads/1000037925.jpg'),
(125, 'Baby toy', 'Toy', 'uploads/1000037927.jpg'),
(126, 'Bike ', 'Bike ', 'uploads/1000037928.jpg'),
(127, 'Police car', 'Car', 'uploads/1000037929.jpg'),
(128, 'Jcb truck', 'Jcb', 'uploads/1000037930.jpg'),
(129, 'Cycle ', 'Cycle ', 'uploads/1000037931.jpg'),
(130, 'Bike ', 'Bike', 'uploads/1000037932.jpg'),
(131, 'AA batteri', '1.5 v battery ', 'uploads/1000037969.jpg'),
(132, 'Aeroplane ', 'Aeroplane ', 'uploads/1000037970.jpg'),
(133, 'Balloon', 'Balloon ', 'uploads/1000038044.png'),
(134, 'Badminton set small ', 'With ball', 'uploads/1000038124.jpg'),
(135, 'Hand fan', 'Hand powered fan', 'uploads/1000038125.jpg'),
(136, 'Drum', 'Drum', 'uploads/1000038126.jpg'),
(137, 'Car', 'Battery wired remote car', 'uploads/1000038127.jpg'),
(138, 'Rubber toy', 'Taddy', 'uploads/1000038128.jpg'),
(139, 'Aeroplane ', 'Wired remote ', 'uploads/1000038129.jpg'),
(140, '1234 magnetic ', '1234', 'uploads/1000038130.jpg'),
(141, 'Scooter ', 'Scooter ', 'uploads/1000038131.jpg'),
(142, 'Doctor set', 'Doctor set', 'uploads/1000038132.jpg'),
(143, 'Doctor set small ', 'Small', 'uploads/1000038133.jpg'),
(144, 'Aeroplane ', 'Aeroplane ', 'uploads/1000038134.jpg'),
(145, 'White board set', 'White board set', 'uploads/1000038135.jpg'),
(146, 'Gun set', 'Gun set', 'uploads/1000038136.jpg'),
(147, 'Train ', 'Train ', 'uploads/1000038137.jpg'),
(148, 'Drum toy', 'Toy', 'uploads/1000038138.jpg'),
(149, 'Small gun ', 'With bullets ', 'uploads/1000038139.jpg'),
(150, 'Gun ', 'Gun ', 'uploads/1000038140.jpg'),
(151, 'Gun ', 'Gun', 'uploads/1000038141.jpg'),
(152, 'Abcd magnetic ', 'Abcd', 'uploads/1000038142.jpg'),
(153, 'Kitchen set', 'Kitchen ', 'uploads/1000038143.jpg'),
(154, 'Fruit set', 'Fruit set', 'uploads/1000038144.jpg'),
(155, 'Kitchen set big', 'Kitchen ', 'uploads/1000038145.jpg'),
(156, 'Kitchen set ', 'Kitchen ', 'uploads/1000038146.jpg'),
(157, 'Funny bear', 'Dear clapping ', 'uploads/1000038148.jpg'),
(158, 'Double tape', 'Double tape', 'uploads/1000040058.jpg'),
(159, 'Chess and ludo', 'Cheese and ludo ', 'uploads/1000040060.jpg'),
(160, 'Ludo and snake', 'Ludo and snake', 'uploads/1000040061.jpg'),
(161, 'Estimate bill', 'Bill', 'uploads/1000040062.jpg'),
(162, 'Stick file', 'File', 'uploads/1000040063.jpg'),
(163, 'Laser light ', 'Laser light', 'uploads/1000040064.jpg'),
(164, 'Clear bag', 'File', 'uploads/1000040065.jpg'),
(165, 'Diary 32k', 'Diary', 'uploads/1000040067.jpg'),
(166, 'Diary 25k k', 'Diary ', 'uploads/1000040066.jpg'),
(167, 'Buddha geometry box', 'geometry box', 'uploads/WIN_20241106_17_15_01_Pro.jpg'),
(168, 'x one geometry box', 'geometry box', 'uploads/WIN_20241106_17_16_31_Pro.jpg'),
(169, 'Doms geometry box', 'geometry box', 'uploads/WIN_20241106_17_17_23_Pro.jpg'),
(170, 'doms geometry box ', 'geometry box', 'uploads/WIN_20241106_17_18_54_Pro.jpg'),
(171, 'celo tape small', 'clear tape', 'uploads/WIN_20241106_17_19_26_Pro.jpg'),
(172, 'Grand master chessmen', 'Grand master chessmen', 'uploads/WIN_20241106_17_20_15_Pro.jpg'),
(173, 'doms water colour pen', 'doms water colour pen', 'uploads/WIN_20241106_17_23_52_Pro.jpg'),
(174, 'colour pencils', 'colour pencils', 'uploads/WIN_20241106_17_24_41_Pro.jpg'),
(175, 'doms colour pencil', 'doms colour pencil', 'uploads/WIN_20241106_17_26_12_Pro.jpg'),
(176, 'doms colour pencil', 'doms colour pencil', 'uploads/WIN_20241106_17_26_40_Pro.jpg'),
(177, 'color paper', 'color paper', 'uploads/WIN_20241106_17_28_49_Pro.jpg'),
(178, 'prince chessmen light', 'prince chessmen light', 'uploads/WIN_20241106_17_29_47_Pro.jpg'),
(179, 'pencil with lead', 'pencil with lead', 'uploads/WIN_20241106_17_30_57_Pro.jpg'),
(180, 'Register no 2', 'Register no 2', 'uploads/WIN_20241106_17_31_28_Pro.jpg'),
(181, 'register no 3', 'register no 3', 'uploads/WIN_20241106_17_32_08_Pro.jpg'),
(182, 'crystal ball', 'crystal ball', 'uploads/WIN_20241106_17_34_11_Pro.jpg'),
(183, 'pencil box', 'pencil box', 'uploads/WIN_20241106_17_34_31_Pro.jpg'),
(184, 'calculator fx 911w', 'calculator fx 911w', 'uploads/WIN_20241106_17_35_04_Pro.jpg'),
(185, 'calculator fx 911w c', 'calculator fx 911w c', 'uploads/WIN_20241106_17_36_19_Pro.jpg'),
(186, 'calculator fx 991 ES plus', 'calculator fx 991 ES plus', 'uploads/WIN_20241106_17_36_38_Pro.jpg'),
(187, 'ludo dice', 'ludo dice', 'uploads/WIN_20241106_17_44_25_Pro.jpg'),
(188, 'gum', 'gum', 'uploads/WIN_20241106_17_47_15_Pro.jpg'),
(189, 'sticker', 'sticker', 'uploads/WIN_20241106_17_48_04_Pro.jpg'),
(190, 'doms pencil y1+', 'doms pencil y1+', 'uploads/WIN_20241106_17_48_49_Pro.jpg'),
(191, 'pearly pencil', 'pearly pencil', 'uploads/WIN_20241106_17_49_32_Pro.jpg'),
(192, 'Doms x1 pencil', 'Doms x1 pencil', 'uploads/WIN_20241106_17_50_16_Pro.jpg'),
(193, 'white gum', 'white gum', 'uploads/WIN_20241106_17_50_36_Pro.jpg'),
(194, 'Glue stick', 'Glue stick', 'uploads/WIN_20241106_17_51_34_Pro.jpg'),
(195, 'oxford scale transparent ', 'oxford scale transparent ', 'uploads/WIN_20241106_17_52_58_Pro.jpg'),
(196, 'sumo metal scale 30 cm', 'sumo metal scale 30 cm', 'uploads/WIN_20241106_17_53_48_Pro.jpg'),
(197, 'fevikwik', 'fevikwik', 'uploads/WIN_20241106_17_54_23_Pro.jpg'),
(198, 'pokemon card', 'pokemon card', 'uploads/WIN_20241106_17_54_59_Pro.jpg'),
(199, 'doms water color', 'doms water color', 'uploads/WIN_20241106_17_56_34_Pro.jpg'),
(200, 'cutter knife', 'cutter knife', 'uploads/WIN_20241106_17_56_46_Pro.jpg'),
(201, 'doms wax color', 'doms wax color', 'uploads/WIN_20241106_17_58_54_Pro.jpg'),
(202, 'Glitter paper', 'Glitter paper', 'uploads/WIN_20241106_18_01_02_Pro.jpg'),
(203, 'sketch book', 'sketch book', 'uploads/WIN_20241106_18_02_43_Pro.jpg'),
(204, 'Card board', 'Card board', 'uploads/WIN_20241106_18_03_25_Pro.jpg'),
(205, 'plastic card board', 'plastic card board', 'uploads/WIN_20241106_18_04_46_Pro.jpg'),
(206, 'card board', 'card board', 'uploads/WIN_20241106_18_05_23_Pro.jpg'),
(207, 'stapler', 'stapler', 'uploads/WIN_20241106_18_06_18_Pro.jpg'),
(208, 'stapler pin', 'stapler pin', 'uploads/WIN_20241106_18_07_06_Pro.jpg'),
(209, 'doms champions kit', 'doms champions kit', 'uploads/WIN_20241106_18_07_51_Pro.jpg'),
(210, 'Doma Art strokes', 'Doma Art strokes', 'uploads/WIN_20241106_18_08_55_Pro.jpg'),
(211, 'ball pen nataraj', 'ball pen', 'uploads/WIN_20241106_18_09_35_Pro.jpg'),
(212, 'x one compass', 'x one compass', 'uploads/WIN_20241106_18_10_14_Pro.jpg'),
(213, 'envelope ', 'envelope ', 'uploads/WIN_20241106_18_10_31_Pro.jpg'),
(214, 'scale 15 cm transparent ', 'scale 15 cm transparent ', 'uploads/WIN_20241106_18_11_27_Pro.jpg'),
(215, 'Unomax ball pen', 'Unomax ball pen', 'uploads/WIN_20241106_18_11_48_Pro.jpg'),
(216, 'super tec ball pen', 'super tec ball pen', 'uploads/WIN_20241106_18_12_20_Pro.jpg'),
(217, 'Hauser Ball pen', 'Hauser Ball pen', 'uploads/WIN_20241106_18_12_56_Pro.jpg'),
(218, 'Safari ball pen', 'Safari ball pen', 'uploads/WIN_20241106_18_13_35_Pro.jpg'),
(219, 'kores marker pen', 'kores ball pen', 'uploads/WIN_20241106_18_14_15_Pro.jpg'),
(220, 'eloks permanent marker', 'eloks permanent marker', 'uploads/WIN_20241106_18_15_37_Pro.jpg'),
(221, 'Hauser High Lighter', 'Hauser High Lighter', 'uploads/WIN_20241106_18_15_51_Pro.jpg'),
(222, 'scissor small', 'scissor', 'uploads/WIN_20241106_18_17_00_Pro.jpg'),
(223, 'scissor dl65', 'scissor dl65', 'uploads/WIN_20241106_18_18_07_Pro.jpg'),
(224, 'shif scissor dl65', 'scissor dl65', 'uploads/WIN_20241106_18_18_35_Pro.jpg'),
(225, 'cricket tennis ball', 'cricket tennis ball', 'uploads/WIN_20241106_18_19_07_Pro.jpg'),
(226, 'T T ball', 'table tennis ball', 'uploads/WIN_20241106_18_19_51_Pro.jpg'),
(227, 'vixen t t ball', 'table tennis ball', 'uploads/WIN_20241106_18_20_26_Pro.jpg'),
(228, 'Hand Grip ', 'Hand Grip ', 'uploads/WIN_20241106_18_21_06_Pro.jpg'),
(229, 'Stand pen', 'Stand Pen', 'uploads/WIN_20241106_18_21_48_Pro.jpg'),
(230, 'Rubber Ball big', 'Rubber Ball big', 'uploads/WIN_20241106_18_22_47_Pro.jpg'),
(231, 'Rubber Ball Small', 'Rubber Ball Small', 'uploads/WIN_20241106_18_23_12_Pro.jpg'),
(232, 'Cutter Blade', 'Cutter Blade', 'uploads/WIN_20241106_18_23_32_Pro.jpg'),
(233, 'Doms Erasers', 'Doms Erasers', 'uploads/WIN_20241106_18_24_03_Pro.jpg'),
(234, 'Carbon paper', 'Carbon paper', 'uploads/WIN_20241106_18_24_31_Pro.jpg'),
(235, 'Record File', 'Record File', 'uploads/WIN_20241106_18_25_07_Pro.jpg'),
(236, 'Magnet ', 'magnet', 'uploads/WIN_20241106_18_26_43_Pro.jpg'),
(237, 'Glue gun stick Big', 'Glue gun stick Big', 'uploads/WIN_20241106_18_27_09_Pro.jpg'),
(238, 'glue gun stick small', 'glue gun stick small', 'uploads/WIN_20241106_18_27_51_Pro.jpg'),
(239, 'Tipex', 'Tipex', 'uploads/WIN_20241106_18_28_24_Pro.jpg'),
(240, 'Funny Geometry Box with ludo', 'Funny Geometry Box with ludo', 'uploads/WIN_20241106_18_29_20_Pro.jpg'),
(241, 'Doms Sharpener ', 'Doms Sharpener ', 'uploads/WIN_20241106_18_29_38_Pro.jpg'),
(242, 'Wheel Ereaser', 'Wheel Ereaserq', 'uploads/WIN_20241106_18_30_57_Pro.jpg'),
(243, 'Toy pencil', 'Toy pencil', 'uploads/WIN_20241106_18_31_47_Pro.jpg'),
(244, 'Copy 80', '80', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(245, 'Copy 70', 'Copy 70', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(246, 'copy with grid box ( math copy)', 'copy with grid box ( math copy)', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(247, 'Four line copy', 'Four line copy', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(248, 'Drawing Copy', 'Drawing Copy', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(249, 'Copy 50', 'copy 50', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(250, 'copy 30', 'copy 30', 'uploads/WIN_20241106_18_34_07_Pro.jpg'),
(251, 'Pen holder', 'Pen Holder', 'uploads/WIN_20241106_18_44_13_Pro.jpg'),
(252, 'Small Plastic Ball', 'Small Plastic Ball1', 'uploads/WIN_20241106_18_44_31_Pro.jpg'),
(253, 'Plastic Bottle', 'Plastic Bottle', 'uploads/WIN_20241106_18_45_23_Pro.jpg'),
(254, 'Plastic Bottle ', 'Plastic Bottle ', 'uploads/WIN_20241106_18_45_51_Pro.jpg'),
(255, 'Plastic Bottle', 'plastic bottle', 'uploads/WIN_20241106_18_46_30_Pro.jpg'),
(256, 'Plastic Bottle', 'Plastic Bottle', 'uploads/WIN_20241106_18_47_05_Pro.jpg'),
(257, 'Color paper white', 'Color paper', 'uploads/1000040069.jpg'),
(258, 'Chess and ludo wooden board', 'Chess and ludo wooden board', 'uploads/Screenshot 2024-11-08 090349.jpg'),
(259, 'Chart Paper', 'chart paper', 'uploads/6504079e8d9e1-500x500.jpg'),
(260, 'Copy 20', 'copy 20', 'uploads/494024209-copy-nepali-writing-book-set-of-12.jpg'),
(261, 'paint brush ', 'paint brush ', 'uploads/Screenshot 2024-11-08 104746.jpg'),
(262, 'Electric Tape', 'Electric Tape', 'uploads/10689-02.jpg'),
(263, 'kids water bottle', 'water bottle', 'uploads/WIN_20241116_16_01_34_Pro.jpg'),
(264, 'water bottle 500 ml', '500 ml water bottle ', 'uploads/WIN_20241116_16_04_37_Pro.jpg'),
(265, 'Lunch box', 'lunch box', 'uploads/WIN_20241116_16_05_29_Pro.jpg'),
(266, 'qq lunch box', 'lunch box', 'uploads/WIN_20241116_16_06_20_Pro.jpg'),
(267, 'Cup with Bear', 'gift cup', 'uploads/WIN_20241116_16_07_27_Pro.jpg'),
(268, 'water bottle 600 ml', 'water bottle', 'uploads/WIN_20241116_16_09_09_Pro.jpg'),
(269, 'wonderful Doll', 'doll', 'uploads/WIN_20241116_16_10_09_Pro.jpg'),
(270, 'Beauty Doll', 'doll', 'uploads/WIN_20241116_16_11_06_Pro.jpg'),
(271, 'Charm girl Doll', 'doll', 'uploads/WIN_20241116_16_12_14_Pro.jpg'),
(272, 'wings', 'wings', 'uploads/WIN_20241116_16_12_37_Pro.jpg'),
(273, 'tic tac toe', 'puzzle game', 'uploads/WIN_20241116_16_13_02_Pro.jpg'),
(274, 'sticker', 'sticker', 'uploads/WIN_20241116_16_13_56_Pro.jpg'),
(275, 'clock pendulum', 'wall clock', 'uploads/WIN_20241116_16_15_21_Pro.jpg'),
(276, 'clock ', 'wall clock', 'uploads/WIN_20241116_16_17_04_Pro.jpg'),
(277, 'wall clock', 'clock', 'uploads/WIN_20241116_16_18_13_Pro.jpg'),
(278, 'Clock', 'clock', 'uploads/WIN_20241116_16_19_10_Pro.jpg'),
(279, 'clock', 'clock', 'uploads/WIN_20241116_16_19_43_Pro.jpg'),
(280, 'clock', 'clock', 'uploads/WIN_20241116_16_20_35_Pro.jpg'),
(281, 'Mask', 'mask', 'uploads/WIN_20241116_16_21_14_Pro.jpg'),
(282, 'butterfly sticker', 'sticker', 'uploads/WIN_20241116_16_30_46_Pro.jpg'),
(283, 'water bottle', 'water bottle', 'uploads/WIN_20241116_16_31_24_Pro.jpg'),
(284, 'house toy', 'toy', 'uploads/WIN_20241116_16_31_47_Pro.jpg'),
(285, 'photo frame', 'photo frame', 'uploads/WIN_20241116_16_32_47_Pro.jpg'),
(286, 'gift cup', 'cup', 'uploads/WIN_20241116_16_35_35_Pro.jpg'),
(287, 'Mug', 'mug', 'uploads/WIN_20241116_16_37_43_Pro.jpg'),
(288, 'pencil bag', 'pencil bag', 'uploads/WIN_20241116_16_38_42_Pro.jpg'),
(289, 'pencil bag', 'bag', 'uploads/WIN_20241116_16_39_30_Pro.jpg'),
(290, 'pencil bag', 'bag', 'uploads/WIN_20241116_16_39_55_Pro.jpg'),
(291, 'AAA battery', 'battery', 'uploads/WIN_20241116_16_40_16_Pro.jpg'),
(292, 'sharpener', 'sharpener\r\n', 'uploads/WIN_20241116_16_41_16_Pro.jpg'),
(293, 'dinosaur balloon', 'dinosaur balloon', 'uploads/WIN_20241116_16_45_00_Pro.jpg'),
(294, 'cartoon balloon', 'cartoon balloon', 'uploads/WIN_20241116_16_46_33_Pro.jpg'),
(295, 'ball pen pack', 'packet of 20 pcs', 'uploads/WIN_20241116_16_48_38_Pro.jpg'),
(296, 'four line copy 20', '20', 'uploads/WIN_20241116_16_49_56_Pro.jpg'),
(297, 'graph copy', 'graph copy', 'uploads/WIN_20241116_16_50_40_Pro.jpg'),
(298, 'ear muff', 'Ear muff with sound', 'uploads/1000040471.jpg'),
(299, 'Electric kettle', '2ltr electric kettle ', 'uploads/1000040545.png'),
(300, 'Electric pot', '1.8 lte electric pot', 'uploads/1000040540.png'),
(301, 'Hand Blender', 'hand blender', 'uploads/IMG_20241122_170855.jpg'),
(302, 'Mini Speaker', 'mini speaker with bluetooth', 'uploads/IMG_20241122_171028.jpg'),
(303, 'electric hot bag', 'electric hot bag', 'uploads/IMG_20241122_170931.jpg'),
(304, 'Electric hand fan with led display ', 'Fan', 'uploads/1000040691.jpg'),
(305, 'Speaker with mike', 'Speaker and mike', 'uploads/1000040747.jpg'),
(306, 'Mini stand fan', 'Rechargeable ', 'uploads/1000040748.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `product_id`, `cost_price`, `selling_price`, `purchase_date`, `quantity`) VALUES
(9, 4, 1100.00, 1550.00, '2024-09-28', 1),
(10, 5, 190.00, 270.00, '2024-09-28', 6),
(11, 6, 260.00, 370.00, '2024-09-28', 3),
(12, 7, 30.00, 50.00, '2024-09-28', 1),
(13, 8, 270.00, 400.00, '2024-09-28', 1),
(14, 9, 360.00, 600.00, '2024-09-28', 1),
(15, 10, 75.00, 130.00, '2024-09-28', 12),
(16, 11, 360.00, 630.00, '2024-09-28', 2),
(17, 12, 250.00, 500.00, '2024-09-28', 2),
(18, 13, 14.50, 30.00, '2024-09-28', 20),
(19, 14, 185.00, 250.00, '2024-09-28', 2),
(20, 15, 9.00, 20.00, '2024-09-28', 30),
(21, 16, 160.00, 320.00, '2024-09-28', 2),
(22, 17, 550.00, 750.00, '2024-09-28', 3),
(23, 18, 1100.00, 1650.00, '2024-09-28', 1),
(24, 19, 400.00, 530.00, '2024-09-28', 2),
(25, 20, 550.00, 770.00, '2024-09-28', 1),
(26, 21, 700.00, 1000.00, '2024-09-28', 1),
(27, 22, 375.00, 550.00, '2024-09-28', 2),
(28, 23, 600.00, 860.00, '2024-09-28', 1),
(29, 24, 250.00, 250.00, '2024-09-28', 2),
(30, 25, 450.00, 650.00, '2024-09-28', 2),
(31, 26, 52.00, 70.00, '2024-09-28', 6),
(32, 27, 50.00, 70.00, '2024-09-28', 12),
(33, 28, 35.00, 50.00, '2024-09-28', 12),
(34, 29, 553.00, 700.00, '2024-09-28', 2),
(35, 30, 700.00, 1000.00, '2024-09-28', 1),
(36, 31, 360.00, 500.00, '2024-09-28', 2),
(37, 32, 250.00, 350.00, '2024-09-28', 1),
(38, 33, 280.00, 400.00, '2024-09-28', 1),
(39, 34, 140.00, 200.00, '2024-09-28', 2),
(40, 35, 350.00, 500.00, '2024-09-28', 1),
(41, 36, 200.00, 300.00, '2024-09-28', 2),
(42, 37, 960.00, 1350.00, '2024-09-28', 1),
(43, 38, 150.00, 200.00, '2024-09-28', 1),
(44, 39, 270.00, 400.00, '2024-09-28', 1),
(45, 40, 300.00, 400.00, '2024-09-28', 1),
(46, 41, 260.00, 500.00, '2024-09-28', 5),
(47, 42, 25.00, 40.00, '2024-09-28', 24),
(48, 43, 225.00, 450.00, '2024-09-28', 1),
(49, 44, 100.00, 150.00, '2024-09-28', 6),
(50, 45, 100.00, 150.00, '2024-09-28', 5),
(51, 46, 190.00, 270.00, '2024-09-28', 1),
(52, 47, 100.00, 150.00, '2024-09-28', 6),
(53, 48, 100.00, 150.00, '2024-09-28', 2),
(54, 49, 120.00, 180.00, '2024-09-28', 2),
(55, 50, 100.00, 150.00, '2024-09-28', 2),
(56, 51, 75.00, 150.00, '2024-09-28', 2),
(57, 52, 130.00, 200.00, '2024-09-28', 3),
(58, 53, 70.00, 100.00, '2024-09-28', 4),
(59, 54, 80.00, 120.00, '2024-09-28', 2),
(60, 55, 490.00, 650.00, '2024-09-28', 1),
(61, 58, 235.00, 350.00, '2024-09-28', 1),
(62, 62, 325.00, 450.00, '2024-09-28', 1),
(63, 56, 50.00, 80.00, '2024-09-28', 3),
(64, 57, 490.00, 650.00, '2024-09-28', 1),
(65, 59, 110.00, 150.00, '2024-09-28', 2),
(66, 60, 530.00, 750.00, '2024-09-28', 1),
(67, 61, 60.00, 80.00, '2024-09-28', 3),
(68, 63, 65.00, 100.00, '2024-09-28', 2),
(69, 64, 150.00, 250.00, '2024-09-28', 2),
(70, 65, 310.00, 450.00, '2024-09-28', 2),
(71, 66, 70.00, 100.00, '2024-09-28', 5),
(72, 67, 275.00, 380.00, '2024-09-28', 1),
(73, 68, 380.00, 550.00, '2024-09-28', 1),
(74, 69, 1245.00, 1750.00, '2024-09-28', 1),
(75, 70, 1465.00, 2000.00, '2024-09-28', 1),
(76, 71, 800.00, 1150.00, '2024-09-28', 1),
(77, 72, 425.00, 600.00, '2024-09-28', 1),
(78, 74, 290.00, 400.00, '2024-09-28', 1),
(79, 75, 600.00, 750.00, '2024-09-28', 2),
(80, 76, 900.00, 1250.00, '2024-09-28', 1),
(81, 77, 1000.00, 1400.00, '2024-09-28', 1),
(82, 78, 950.00, 1200.00, '2024-09-28', 1),
(83, 79, 280.00, 350.00, '2024-09-28', 2),
(84, 80, 450.00, 650.00, '2024-09-28', 1),
(85, 81, 400.00, 650.00, '2024-09-28', 1),
(86, 82, 130.00, 180.00, '2024-09-28', 4),
(87, 83, 320.00, 450.00, '2024-09-28', 1),
(88, 84, 450.00, 650.00, '2024-09-28', 1),
(89, 85, 130.00, 180.00, '2024-09-28', 4),
(90, 86, 25.00, 50.00, '2024-09-28', 25),
(91, 87, 370.00, 520.00, '2024-09-28', 1),
(92, 88, 57.00, 80.00, '2024-09-28', 12),
(93, 89, 24.00, 40.00, '2024-09-28', 20),
(94, 90, 40.00, 80.00, '2024-09-28', 48),
(95, 91, 180.00, 250.00, '2024-09-29', 2),
(96, 92, 35.00, 70.00, '2024-09-29', 23),
(97, 93, 250.00, 350.00, '2024-09-29', 2),
(98, 95, 100.00, 180.00, '2024-09-29', 15),
(99, 96, 285.00, 380.00, '2024-09-29', 2),
(100, 97, 670.00, 850.00, '2024-09-29', 2),
(101, 98, 550.00, 750.00, '2024-09-29', 2),
(102, 99, 285.00, 380.00, '2024-09-29', 2),
(103, 100, 285.00, 380.00, '2024-09-29', 2),
(104, 101, 40.00, 50.00, '2024-09-29', 12),
(105, 103, 30.00, 40.00, '2024-09-29', 12),
(106, 105, 60.00, 100.00, '2024-09-29', 4),
(107, 106, 290.00, 420.00, '2024-09-29', 2),
(108, 107, 240.00, 350.00, '2024-09-29', 2),
(109, 108, 400.00, 750.00, '2024-09-29', 2),
(110, 109, 240.00, 400.00, '2024-09-29', 2),
(111, 110, 350.00, 480.00, '2024-09-29', 2),
(112, 111, 110.00, 180.00, '2024-09-29', 4),
(113, 112, 105.00, 150.00, '2024-09-29', 4),
(114, 113, 100.00, 150.00, '2024-09-29', 2),
(115, 114, 40.00, 80.00, '2024-09-29', 5),
(116, 116, 40.00, 80.00, '2024-09-29', 5),
(117, 117, 120.00, 180.00, '2024-09-29', 2),
(118, 118, 45.00, 70.00, '2024-09-29', 5),
(119, 120, 2.50, 10.00, '2024-09-29', 40),
(120, 121, 25.00, 40.00, '2024-09-29', 4),
(121, 122, 40.00, 80.00, '2024-09-29', 5),
(122, 123, 0.00, 20.00, '2024-09-29', 6),
(123, 123, 0.00, 20.00, '2024-09-29', 6),
(124, 124, 95.00, 150.00, '2024-09-29', 4),
(125, 126, 70.00, 100.00, '2024-09-29', 5),
(126, 127, 27.00, 50.00, '2024-09-29', 6),
(127, 128, 60.00, 95.00, '2024-09-29', 6),
(128, 130, 59.00, 85.00, '2024-09-29', 6),
(129, 132, 55.00, 85.00, '2024-09-29', 5),
(130, 131, 10.00, 15.00, '2024-09-29', 24),
(131, 119, 30.00, 60.00, '2024-09-29', 2),
(132, 129, 70.00, 100.00, '2024-09-29', 5),
(133, 125, 19.00, 30.00, '2024-09-29', 12),
(134, 73, 500.00, 700.00, '2024-09-29', 1),
(135, 133, 2.00, 5.00, '2024-10-01', 50),
(136, 71, 800.00, 1200.00, '2024-10-02', 2),
(137, 134, 28.50, 40.00, '2024-10-04', 4),
(138, 135, 70.00, 100.00, '2024-10-04', 5),
(139, 136, 115.00, 160.00, '2024-10-04', 2),
(140, 137, 100.00, 140.00, '2024-10-04', 2),
(141, 138, 70.00, 100.00, '2024-10-04', 5),
(142, 140, 95.00, 140.00, '2024-10-04', 1),
(143, 141, 120.00, 170.00, '2024-10-04', 1),
(144, 142, 110.00, 160.00, '2024-10-04', 1),
(145, 143, 105.00, 140.00, '2024-10-04', 1),
(146, 139, 150.00, 210.00, '2024-10-04', 2),
(147, 145, 140.00, 220.00, '2024-10-04', 2),
(148, 146, 110.00, 160.00, '2024-10-04', 1),
(149, 147, 200.00, 280.00, '2024-10-04', 1),
(150, 148, 80.00, 120.00, '2024-10-04', 4),
(151, 149, 28.00, 40.00, '2024-10-04', 5),
(152, 150, 140.00, 200.00, '2024-10-04', 1),
(153, 151, 120.00, 170.00, '2024-10-04', 2),
(154, 152, 115.00, 160.00, '2024-10-04', 1),
(155, 153, 75.00, 100.00, '2024-10-04', 1),
(156, 154, 220.00, 310.00, '2024-10-04', 1),
(157, 155, 220.00, 290.00, '2024-10-04', 1),
(158, 156, 110.00, 150.00, '2024-10-04', 1),
(159, 12, 250.00, 500.00, '2024-10-04', 1),
(160, 157, 280.00, 350.00, '2024-10-04', 1),
(161, 60, 530.00, 750.00, '2024-10-04', 2),
(162, 144, 140.00, 220.00, '2024-10-05', 2),
(163, 60, 500.00, 750.00, '2024-10-24', 2),
(164, 256, 135.00, 180.00, '2024-11-06', 2),
(165, 255, 85.00, 120.00, '2024-11-06', 4),
(166, 253, 100.00, 150.00, '2024-11-06', 2),
(167, 252, 10.00, 15.00, '2024-11-06', 12),
(168, 251, 40.00, 60.00, '2024-11-06', 4),
(169, 250, 21.66, 30.00, '2024-11-06', 6),
(170, 249, 36.00, 50.00, '2024-11-06', 12),
(171, 248, 36.00, 50.00, '2024-11-06', 6),
(172, 247, 36.00, 50.00, '2024-11-06', 6),
(173, 246, 36.00, 50.00, '2024-11-06', 6),
(174, 245, 52.50, 70.00, '2024-11-06', 6),
(175, 244, 60.00, 80.00, '2024-11-06', 6),
(176, 243, 22.00, 30.00, '2024-11-06', 12),
(177, 242, 8.00, 15.00, '2024-11-06', 4),
(178, 241, 19.00, 25.00, '2024-11-06', 6),
(179, 240, 88.00, 120.00, '2024-11-06', 1),
(180, 239, 33.00, 45.00, '2024-11-06', 3),
(181, 238, 7.00, 10.00, '2024-11-06', 20),
(182, 237, 14.00, 20.00, '2024-11-06', 20),
(183, 236, 10.00, 20.00, '2024-11-06', 20),
(184, 235, 4.58, 10.00, '2024-11-06', 12),
(185, 234, 3.00, 5.00, '2024-11-06', 100),
(186, 233, 3.00, 5.00, '2024-11-06', 20),
(187, 232, 6.50, 10.00, '2024-11-06', 10),
(188, 231, 27.00, 40.00, '2024-11-06', 4),
(189, 230, 58.00, 80.00, '2024-11-06', 4),
(190, 229, 45.00, 60.00, '2024-11-06', 2),
(191, 228, 275.00, 400.00, '2024-11-06', 2),
(192, 227, 18.33, 25.00, '2024-11-06', 6),
(193, 226, 6.90, 10.00, '2024-11-06', 50),
(194, 225, 78.00, 100.00, '2024-11-06', 3),
(195, 224, 75.00, 100.00, '2024-11-06', 1),
(196, 223, 56.00, 80.00, '2024-11-06', 1),
(197, 222, 34.00, 50.00, '2024-11-06', 4),
(198, 221, 33.20, 45.00, '2024-11-06', 5),
(199, 220, 22.00, 30.00, '2024-11-06', 6),
(200, 219, 16.50, 25.00, '2024-11-06', 10),
(201, 218, 4.10, 10.00, '2024-11-06', 20),
(202, 217, 15.00, 20.00, '2024-11-06', 10),
(203, 216, 5.50, 10.00, '2024-11-06', 10),
(204, 215, 15.00, 20.00, '2024-11-06', 10),
(205, 214, 6.00, 10.00, '2024-11-06', 10),
(206, 212, 14.50, 20.00, '2024-11-06', 10),
(207, 211, 7.00, 10.00, '2024-11-06', 10),
(208, 210, 215.00, 300.00, '2024-11-06', 1),
(209, 209, 145.00, 200.00, '2024-11-06', 1),
(210, 208, 11.50, 15.00, '2024-11-06', 20),
(211, 207, 60.00, 85.00, '2024-11-06', 2),
(212, 206, 30.00, 50.00, '2024-11-06', 4),
(213, 205, 60.00, 90.00, '2024-11-06', 6),
(214, 204, 95.00, 130.00, '2024-11-06', 2),
(215, 202, 16.00, 25.00, '2024-11-06', 10),
(216, 203, 23.00, 35.00, '2024-11-06', 4),
(217, 201, 16.00, 25.00, '2024-11-06', 4),
(218, 200, 45.00, 60.00, '2024-11-06', 2),
(219, 199, 32.00, 70.00, '2024-11-06', 2),
(220, 198, 10.50, 15.00, '2024-11-06', 36),
(221, 197, 6.80, 10.00, '2024-11-06', 25),
(222, 196, 31.60, 45.00, '2024-11-06', 12),
(223, 195, 14.50, 20.00, '2024-11-06', 10),
(224, 194, 19.00, 25.00, '2024-11-06', 6),
(225, 192, 7.20, 10.00, '2024-11-06', 20),
(226, 191, 3.70, 5.00, '2024-11-07', 10),
(227, 190, 6.00, 10.00, '2024-11-07', 10),
(228, 189, 7.00, 10.00, '2024-11-07', 19),
(229, 188, 7.00, 10.00, '2024-11-07', 10),
(230, 187, 15.00, 20.00, '2024-11-07', 6),
(231, 186, 475.00, 650.00, '2024-11-07', 1),
(232, 185, 220.00, 300.00, '2024-11-07', 1),
(233, 184, 210.00, 280.00, '2024-11-07', 1),
(234, 183, 190.00, 250.00, '2024-11-07', 1),
(235, 182, 5.00, 10.00, '2024-11-07', 20),
(236, 181, 27.00, 40.00, '2024-11-07', 4),
(237, 180, 20.00, 30.00, '2024-11-07', 4),
(238, 179, 20.00, 30.00, '2024-11-07', 6),
(239, 178, 220.00, 300.00, '2024-11-07', 1),
(240, 177, 2.70, 5.00, '2024-11-07', 225),
(241, 257, 1.35, 2.50, '2024-11-07', 70),
(242, 176, 48.00, 65.00, '2024-11-07', 2),
(243, 175, 40.00, 50.00, '2024-11-07', 2),
(244, 174, 28.00, 40.00, '2024-11-07', 2),
(245, 173, 18.00, 25.00, '2024-11-07', 4),
(246, 172, 170.00, 120.00, '2024-11-07', 3),
(247, 171, 6.25, 10.00, '2024-11-07', 12),
(248, 170, 110.00, 150.00, '2024-11-07', 1),
(249, 169, 98.00, 135.00, '2024-11-07', 1),
(250, 168, 80.00, 100.00, '2024-11-07', 2),
(251, 167, 68.00, 85.00, '2024-11-07', 1),
(252, 166, 155.00, 200.00, '2024-11-07', 6),
(253, 165, 135.00, 175.00, '2024-11-07', 4),
(254, 164, 12.90, 20.00, '2024-11-07', 12),
(255, 163, 73.00, 100.00, '2024-11-07', 6),
(256, 162, 13.50, 20.00, '2024-11-07', 20),
(257, 161, 33.00, 40.00, '2024-11-07', 4),
(258, 160, 45.00, 60.00, '2024-11-07', 4),
(259, 159, 45.00, 60.00, '2024-11-07', 2),
(260, 158, 37.00, 50.00, '2024-11-07', 3),
(261, 213, 0.40, 1.00, '2024-11-07', 90),
(262, 258, 240.00, 350.00, '2024-11-08', 1),
(263, 259, 8.00, 15.00, '2024-11-08', 30),
(264, 193, 14.00, 20.00, '2024-11-08', 10),
(265, 260, 11.66, 20.00, '2024-11-08', 12),
(266, 261, 12.50, 20.00, '2024-11-08', 18),
(267, 262, 13.50, 20.00, '2024-11-08', 10),
(268, 190, 6.00, 10.00, '2024-11-10', 20),
(269, 74, 350.00, 550.00, '2024-11-10', 1),
(270, 72, 470.00, 680.00, '2024-11-10', 1),
(271, 263, 275.00, 320.00, '2024-11-16', 3),
(272, 264, 480.00, 600.00, '2024-11-16', 2),
(273, 297, 14.00, 20.00, '2024-11-16', 6),
(274, 296, 14.00, 20.00, '2024-11-16', 6),
(275, 295, 82.00, 120.00, '2024-11-16', 2),
(276, 294, 50.00, 80.00, '2024-11-16', 6),
(277, 293, 90.00, 130.00, '2024-11-16', 2),
(278, 292, 3.75, 5.00, '2024-11-16', 20),
(279, 291, 12.75, 15.00, '2024-11-16', 20),
(280, 290, 120.00, 160.00, '2024-11-16', 2),
(281, 289, 80.00, 125.00, '2024-11-16', 4),
(282, 288, 100.00, 145.00, '2024-11-16', 4),
(283, 287, 220.00, 315.00, '2024-11-16', 2),
(284, 286, 110.00, 165.00, '2024-11-16', 12),
(285, 285, 450.00, 630.00, '2024-11-16', 2),
(286, 284, 310.00, 450.00, '2024-11-16', 1),
(287, 283, 575.00, 685.00, '2024-11-16', 2),
(288, 282, 35.00, 50.00, '2024-11-16', 5),
(289, 281, 160.00, 125.00, '2024-11-16', 1),
(290, 280, 560.00, 850.00, '2024-11-16', 1),
(291, 279, 528.00, 750.00, '2024-11-16', 1),
(292, 278, 472.00, 665.00, '2024-11-16', 1),
(293, 277, 290.00, 400.00, '2024-11-16', 1),
(294, 276, 290.00, 400.00, '2024-11-16', 1),
(295, 275, 875.00, 1250.00, '2024-11-16', 1),
(296, 274, 85.00, 125.00, '2024-11-16', 2),
(297, 273, 150.00, 225.00, '2024-11-16', 2),
(298, 272, 130.00, 185.00, '2024-11-16', 2),
(299, 271, 210.00, 340.00, '2024-11-16', 2),
(300, 270, 335.00, 470.00, '2024-11-16', 1),
(301, 269, 450.00, 650.00, '2024-11-16', 2),
(302, 268, 550.00, 750.00, '2024-11-16', 1),
(303, 267, 165.00, 235.00, '2024-11-16', 2),
(304, 266, 460.00, 650.00, '2024-11-16', 2),
(305, 265, 390.00, 495.00, '2024-11-16', 2),
(306, 242, 8.00, 15.00, '2024-11-16', 4),
(307, 131, 12.75, 15.00, '2024-11-16', 20),
(308, 217, 15.00, 20.00, '2024-11-16', 10),
(309, 298, 300.00, 425.00, '2024-11-17', 4),
(310, 240, 88.00, 120.00, '2024-11-17', 2),
(311, 218, 4.10, 10.00, '2024-11-17', 40),
(312, 243, 22.00, 30.00, '2024-11-17', 6),
(313, 165, 135.00, 175.00, '2024-11-17', 4),
(314, 299, 620.00, 950.00, '2024-11-19', 2),
(315, 300, 760.00, 1100.00, '2024-11-19', 2),
(316, 303, 287.00, 380.00, '2024-11-22', 1),
(317, 302, 337.00, 480.00, '2024-11-22', 4),
(318, 301, 248.50, 350.00, '2024-11-22', 4),
(319, 198, 10.50, 15.00, '2024-11-22', 72),
(320, 236, 300.00, 20.00, '2024-11-22', 20),
(321, 189, 7.00, 10.00, '2024-11-22', 30),
(322, 304, 271.00, 525.00, '2024-11-24', 6),
(323, 303, 247.50, 380.00, '2024-11-26', 4),
(324, 305, 821.00, 1000.00, '2024-11-26', 3),
(325, 306, 361.00, 750.00, '2024-11-26', 3),
(326, 174, 40.00, 40.00, '2025-11-12', 0),
(327, 188, 10.00, 10.00, '2025-11-12', 0),
(328, 247, 50.00, 50.00, '2025-11-12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(5,2) DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL,
  `sale_date` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `product_id`, `quantity`, `discount`, `total_price`, `sale_date`, `user_id`) VALUES
(25, 120, 1, 0.00, 10.00, '2024-09-29 14:32:04', 1),
(26, 85, 1, 0.00, 180.00, '2024-09-30 06:02:50', 1),
(27, 120, 1, 0.00, 10.00, '2024-10-01 03:38:57', 1),
(28, 120, 2, 0.00, 20.00, '2024-10-01 08:22:12', 1),
(29, 71, 1, 5.00, 1092.50, '2024-10-01 09:06:16', 1),
(30, 131, 3, 83.00, 7.65, '2024-10-01 09:06:16', 1),
(31, 120, 2, 0.00, 20.00, '2024-10-01 09:10:53', 1),
(32, 133, 1, 0.00, 10.00, '2024-10-02 12:15:54', 1),
(33, 120, 2, 0.00, 20.00, '2024-10-02 12:19:06', 1),
(34, 120, 2, 0.00, 20.00, '2024-10-03 05:24:50', 1),
(35, 86, 1, 0.00, 50.00, '2024-10-03 07:34:17', 1),
(36, 42, 1, 25.00, 30.00, '2024-10-03 07:47:48', 1),
(37, 60, 1, 7.00, 697.50, '2024-10-03 12:04:54', 1),
(38, 128, 1, 0.00, 95.00, '2024-10-04 09:41:00', 1),
(39, 90, 1, 0.00, 70.00, '2024-10-04 10:09:03', 1),
(40, 86, 1, 0.00, 50.00, '2024-10-04 10:18:11', 1),
(41, 134, 1, 0.00, 40.00, '2024-10-04 13:38:38', 1),
(42, 148, 1, 0.00, 120.00, '2024-10-04 13:38:38', 1),
(43, 120, 2, 0.00, 20.00, '2024-10-05 00:20:22', 1),
(44, 135, 1, 0.00, 100.00, '2024-10-05 01:45:41', 1),
(45, 120, 1, 0.00, 10.00, '2024-10-05 07:37:36', 1),
(46, 99, 1, 20.00, 360.00, '2024-10-05 07:37:36', 1),
(47, 155, 1, 0.00, 290.00, '2024-10-05 07:37:36', 1),
(48, 61, 1, 0.00, 80.00, '2024-10-05 08:51:01', 1),
(49, 86, 1, 0.00, 50.00, '2024-10-05 09:11:51', 1),
(50, 156, 1, 0.00, 150.00, '2024-10-05 10:26:07', 1),
(57, 92, 1, 70.00, 0.00, '2024-10-07 09:27:52', 1),
(58, 129, 1, 90.00, 10.00, '2024-10-07 09:29:03', 1),
(59, 46, 1, 20.00, 250.00, '2024-10-08 16:02:09', 1),
(60, 86, 1, 0.00, 50.00, '2024-10-09 04:07:09', 1),
(61, 90, 1, 0.00, 80.00, '2024-10-09 04:15:42', 1),
(62, 120, 1, 0.00, 10.00, '2024-10-09 04:25:51', 1),
(63, 121, 1, 0.00, 40.00, '2024-10-09 06:41:40', 1),
(64, 120, 3, 10.00, 20.00, '2024-10-09 07:28:16', 1),
(65, 132, 1, 0.00, 85.00, '2024-10-09 09:06:18', 1),
(66, 6, 1, 0.00, 370.00, '2024-10-09 10:33:59', 1),
(67, 135, 1, 0.00, 100.00, '2024-10-10 23:15:42', 1),
(68, 122, 1, 0.00, 80.00, '2024-10-11 00:42:25', 1),
(69, 62, 1, 50.00, 400.00, '2024-10-11 02:22:29', 1),
(70, 148, 1, 20.00, 100.00, '2024-10-11 08:14:10', 1),
(71, 135, 1, 0.00, 100.00, '2024-10-11 08:14:10', 1),
(72, 120, 1, 0.00, 10.00, '2024-10-11 08:39:14', 1),
(73, 119, 1, 0.00, 60.00, '2024-10-11 11:33:38', 1),
(74, 12, 1, 0.00, 500.00, '2024-10-11 13:09:03', 1),
(75, 131, 3, 45.00, 0.00, '2024-10-11 13:09:03', 1),
(76, 58, 1, 0.00, 350.00, '2024-10-12 05:22:55', 1),
(77, 109, 1, 50.00, 350.00, '2024-10-12 05:22:55', 1),
(78, 10, 1, 0.00, 130.00, '2024-10-12 07:53:57', 1),
(79, 125, 1, 30.00, 0.00, '2024-10-12 07:53:57', 1),
(80, 119, 1, 0.00, 60.00, '2024-10-12 07:55:34', 1),
(81, 120, 1, 0.00, 10.00, '2024-10-12 08:11:44', 1),
(82, 63, 1, 0.00, 100.00, '2024-10-12 08:25:44', 1),
(83, 86, 2, 0.00, 100.00, '2024-10-12 08:42:09', 1),
(84, 19, 1, 30.00, 530.00, '2024-10-12 09:29:50', 1),
(85, 95, 2, 10.00, 350.00, '2024-10-12 09:29:50', 1),
(86, 151, 1, 10.00, 160.00, '2024-10-12 09:29:50', 1),
(87, 5, 1, 20.00, 250.00, '2024-10-12 09:29:50', 1),
(88, 66, 1, 0.00, 100.00, '2024-10-12 09:50:53', 1),
(89, 125, 1, 30.00, 0.00, '2024-10-12 09:50:53', 1),
(90, 95, 1, 0.00, 180.00, '2024-10-12 09:50:53', 1),
(91, 90, 1, 10.00, 70.00, '2024-10-12 09:50:53', 1),
(92, 118, 1, 20.00, 50.00, '2024-10-12 09:53:56', 1),
(93, 146, 1, 0.00, 160.00, '2024-10-12 10:06:10', 1),
(94, 96, 1, 30.00, 350.00, '2024-10-12 10:06:10', 1),
(95, 149, 1, 0.00, 40.00, '2024-10-12 10:06:10', 1),
(96, 149, 1, 0.00, 40.00, '2024-10-12 10:11:23', 1),
(97, 135, 1, 0.00, 100.00, '2024-10-12 11:19:01', 1),
(98, 86, 1, 0.00, 50.00, '2024-10-12 11:19:01', 1),
(99, 120, 1, 0.00, 10.00, '2024-10-12 11:20:19', 1),
(100, 86, 1, 0.00, 50.00, '2024-10-12 11:21:00', 1),
(101, 15, 1, 0.00, 20.00, '2024-10-12 11:23:44', 1),
(102, 95, 1, 20.00, 160.00, '2024-10-12 11:25:42', 1),
(103, 121, 1, 0.00, 40.00, '2024-10-12 11:28:02', 1),
(104, 86, 1, 0.00, 50.00, '2024-10-12 11:37:09', 1),
(105, 41, 1, 0.00, 500.00, '2024-10-16 03:25:53', 1),
(107, 134, 1, 0.00, 40.00, '2024-10-16 03:27:53', 1),
(108, 86, 2, 40.00, 60.00, '2024-10-16 13:12:57', 1),
(109, 15, 1, 0.00, 20.00, '2024-10-16 14:00:08', 1),
(110, 121, 2, 0.00, 80.00, '2024-10-18 08:38:12', 1),
(111, 107, 1, 30.00, 320.00, '2024-10-18 08:38:12', 1),
(112, 36, 1, 0.00, 300.00, '2024-10-18 08:40:44', 1),
(113, 135, 1, 0.00, 100.00, '2024-10-18 08:48:42', 1),
(114, 15, 5, 0.00, 100.00, '2024-10-18 08:49:24', 1),
(115, 107, 1, 50.00, 300.00, '2024-10-18 09:06:26', 1),
(116, 13, 1, 0.00, 30.00, '2024-10-18 09:30:01', 1),
(117, 128, 1, 0.00, 95.00, '2024-10-18 10:11:45', 1),
(118, 105, 1, 0.00, 100.00, '2024-10-18 10:11:45', 1),
(119, 130, 1, 5.00, 80.00, '2024-10-18 10:37:27', 1),
(120, 26, 1, 0.00, 70.00, '2024-10-18 10:37:27', 1),
(121, 72, 1, 0.00, 600.00, '2024-10-18 10:37:27', 1),
(122, 125, 1, 30.00, 0.00, '2024-10-18 10:37:27', 1),
(123, 31, 1, 0.00, 500.00, '2024-10-18 11:07:06', 1),
(124, 131, 5, 55.00, 20.00, '2024-10-18 11:07:06', 1),
(125, 127, 1, 0.00, 50.00, '2024-10-19 05:45:28', 1),
(126, 95, 1, 0.00, 180.00, '2024-10-20 09:18:42', 1),
(127, 153, 1, 0.00, 100.00, '2024-10-20 13:07:18', 1),
(128, 134, 1, 0.00, 40.00, '2024-10-20 13:07:18', 1),
(129, 65, 1, 50.00, 400.00, '2024-10-22 09:18:24', 1),
(130, 60, 1, 50.00, 700.00, '2024-10-23 02:56:49', 1),
(131, 116, 2, 0.00, 160.00, '2024-10-23 13:49:59', 1),
(132, 116, 1, 0.00, 10.00, '2024-10-23 13:49:59', 1),
(133, 44, 1, 150.00, 150.00, '2024-10-24 01:35:51', 1),
(134, 126, 2, 20.00, 180.00, '2024-10-24 01:53:13', 1),
(135, 129, 1, 10.00, 90.00, '2024-10-24 01:53:14', 1),
(136, 60, 1, 150.00, 600.00, '2024-10-24 09:54:45', 1),
(137, 60, 1, 150.00, 600.00, '2024-10-24 09:54:45', 1),
(138, 145, 1, 0.00, 220.00, '2024-10-28 05:25:33', 1),
(139, 93, 1, 50.00, 300.00, '2024-10-30 01:23:38', 1),
(140, 9, 1, 50.00, 550.00, '2024-10-30 01:23:38', 1),
(141, 131, 3, 45.00, 0.00, '2024-10-30 01:23:38', 1),
(142, 114, 1, 0.00, 80.00, '2024-10-30 10:55:39', 1),
(143, 131, 1, 15.00, 0.00, '2024-11-05 10:01:15', 1),
(144, 120, 1, 0.00, 10.00, '2024-11-05 10:14:51', 1),
(145, 127, 1, 0.00, 50.00, '2024-11-05 10:19:07', 1),
(146, 122, 1, 10.00, 70.00, '2024-11-05 10:33:56', 1),
(147, 142, 1, 0.00, 160.00, '2024-11-06 10:17:04', 1),
(148, 229, 1, 60.00, 0.00, '2024-11-06 14:12:20', 1),
(149, 11, 1, 0.00, 630.00, '2024-11-08 02:55:39', 1),
(150, 131, 3, 45.00, 0.00, '2024-11-08 02:55:39', 1),
(151, 114, 1, 10.00, 70.00, '2024-11-08 02:55:39', 1),
(152, 242, 1, 0.00, 15.00, '2024-11-08 04:00:32', 1),
(153, 260, 1, 0.00, 20.00, '2024-11-08 04:41:35', 1),
(154, 193, 1, 0.00, 20.00, '2024-11-08 06:21:30', 1),
(155, 39, 1, 0.00, 400.00, '2024-11-08 07:26:27', 1),
(156, 190, 10, 20.00, 80.00, '2024-11-08 10:38:01', 1),
(157, 26, 1, 0.00, 70.00, '2024-11-08 10:38:01', 1),
(158, 74, 1, 0.00, 400.00, '2024-11-08 10:38:01', 1),
(159, 148, 1, 0.00, 120.00, '2024-11-08 10:38:01', 1),
(160, 189, 1, 0.00, 10.00, '2024-11-08 11:17:42', 1),
(161, 120, 1, 0.00, 10.00, '2024-11-08 11:23:38', 1),
(162, 236, 2, 10.00, 20.00, '2024-11-08 11:36:32', 1),
(163, 236, 1, 0.00, 15.00, '2024-11-08 11:42:00', 1),
(164, 236, 2, 0.00, 30.00, '2024-11-08 12:07:28', 1),
(165, 217, 1, 0.00, 20.00, '2024-11-08 12:07:28', 1),
(166, 236, 1, 0.00, 15.00, '2024-11-08 12:23:43', 1),
(167, 243, 1, 0.00, 30.00, '2024-11-10 03:35:02', 1),
(168, 182, 1, 0.00, 10.00, '2024-11-10 03:35:02', 1),
(169, 188, 1, 0.00, 10.00, '2024-11-10 03:35:02', 1),
(170, 148, 1, 20.00, 100.00, '2024-11-10 05:05:20', 1),
(171, 120, 1, 0.00, 10.00, '2024-11-10 12:25:10', 1),
(172, 201, 1, 0.00, 25.00, '2024-11-10 12:25:10', 1),
(173, 243, 1, 0.00, 30.00, '2024-11-10 12:25:10', 1),
(174, 236, 1, 0.00, 20.00, '2024-11-10 12:25:10', 1),
(175, 179, 1, 30.00, 0.00, '2024-11-10 12:33:48', 1),
(176, 192, 1, 0.00, 10.00, '2024-11-11 03:04:58', 1),
(177, 260, 1, 0.00, 20.00, '2024-11-11 03:22:03', 1),
(178, 242, 1, 0.00, 15.00, '2024-11-11 05:04:05', 1),
(179, 188, 1, 0.00, 10.00, '2024-11-11 05:04:05', 1),
(180, 132, 1, 5.00, 80.00, '2024-11-11 12:30:12', 1),
(181, 179, 1, 5.00, 25.00, '2024-11-11 12:30:12', 1),
(182, 217, 2, 0.00, 40.00, '2024-11-11 12:30:12', 1),
(183, 191, 1, 0.00, 5.00, '2024-11-12 03:33:16', 1),
(184, 242, 1, 0.00, 15.00, '2024-11-12 12:21:34', 1),
(185, 192, 1, 0.00, 10.00, '2024-11-12 12:21:34', 1),
(186, 241, 1, 0.00, 25.00, '2024-11-12 12:21:34', 1),
(187, 179, 1, 0.00, 30.00, '2024-11-12 12:21:34', 1),
(188, 120, 1, 0.00, 10.00, '2024-11-12 12:21:34', 1),
(189, 246, 1, 0.00, 50.00, '2024-11-12 12:21:34', 1),
(190, 260, 1, 0.00, 20.00, '2024-11-12 12:21:34', 1),
(191, 92, 1, 0.00, 70.00, '2024-11-12 12:21:34', 1),
(192, 198, 1, 0.00, 15.00, '2024-11-12 12:21:34', 1),
(193, 247, 1, 0.00, 50.00, '2024-11-12 12:57:22', 1),
(194, 197, 1, 0.00, 10.00, '2024-11-13 12:43:26', 1),
(195, 189, 2, 0.00, 20.00, '2024-11-13 12:43:26', 1),
(196, 165, 2, 0.00, 350.00, '2024-11-15 02:03:15', 1),
(197, 243, 1, 0.00, 30.00, '2024-11-15 02:03:15', 1),
(198, 218, 1, 0.00, 10.00, '2024-11-15 02:03:15', 1),
(199, 89, 1, 0.00, 40.00, '2024-11-15 02:03:15', 1),
(200, 248, 2, 0.00, 100.00, '2024-11-15 02:03:15', 1),
(201, 252, 1, 0.00, 15.00, '2024-11-15 06:21:20', 1),
(202, 189, 2, 0.00, 20.00, '2024-11-15 06:21:20', 1),
(203, 42, 1, 0.00, 40.00, '2024-11-15 06:21:20', 1),
(204, 240, 1, 0.00, 120.00, '2024-11-15 10:55:14', 1),
(205, 189, 1, 0.00, 10.00, '2024-11-15 10:55:14', 1),
(206, 174, 1, 0.00, 40.00, '2024-11-15 10:55:14', 1),
(207, 198, 1, 0.00, 15.00, '2024-11-16 01:40:33', 1),
(208, 198, 2, 0.00, 30.00, '2024-11-16 03:43:18', 1),
(209, 218, 1, 10.00, 0.00, '2024-11-17 05:44:19', 1),
(210, 89, 1, 0.00, 40.00, '2024-11-17 12:08:40', 1),
(211, 236, 2, 0.00, 40.00, '2024-11-17 12:08:40', 1),
(212, 241, 1, 0.00, 25.00, '2024-11-17 12:08:40', 1),
(213, 88, 2, 0.00, 160.00, '2024-11-17 12:08:40', 1),
(214, 66, 1, 0.00, 100.00, '2024-11-17 12:08:40', 1),
(215, 198, 7, 0.00, 105.00, '2024-11-17 12:08:40', 1),
(216, 189, 1, 0.00, 10.00, '2024-11-17 12:08:40', 1),
(217, 236, 1, 0.00, 20.00, '2024-11-17 12:34:23', 1),
(218, 85, 1, 0.00, 180.00, '2024-11-17 13:19:58', 1),
(219, 198, 5, 0.00, 75.00, '2024-11-18 07:41:59', 1),
(220, 222, 1, 0.00, 50.00, '2024-11-18 07:41:59', 1),
(221, 197, 1, 0.00, 10.00, '2024-11-18 12:45:01', 1),
(222, 236, 2, 0.00, 40.00, '2024-11-18 12:45:01', 1),
(223, 189, 7, 0.00, 70.00, '2024-11-18 12:45:01', 1),
(224, 198, 1, 0.00, 15.00, '2024-11-18 12:45:01', 1),
(225, 243, 1, 0.00, 30.00, '2024-11-18 12:45:01', 1),
(226, 198, 13, 0.00, 195.00, '2024-11-19 10:41:21', 1),
(227, 236, 2, 0.00, 40.00, '2024-11-19 10:41:21', 1),
(228, 182, 2, 0.00, 20.00, '2024-11-19 10:41:21', 1),
(229, 189, 1, 0.00, 10.00, '2024-11-19 12:58:44', 1),
(230, 198, 2, 0.00, 30.00, '2024-11-19 12:58:44', 1),
(231, 182, 1, 0.00, 10.00, '2024-11-19 12:58:44', 1),
(232, 191, 2, 0.00, 10.00, '2024-11-19 12:58:44', 1),
(233, 68, 1, 50.00, 500.00, '2024-11-21 09:57:15', 1),
(234, 6, 1, 20.00, 350.00, '2024-11-21 09:57:16', 1),
(235, 198, 3, 0.00, 45.00, '2024-11-22 09:54:33', 1),
(236, 191, 1, 0.00, 5.00, '2024-11-22 09:54:33', 1),
(237, 42, 1, 0.00, 40.00, '2024-11-22 09:57:33', 1),
(238, 236, 3, 0.00, 60.00, '2024-11-22 09:57:33', 1),
(239, 191, 1, 0.00, 5.00, '2024-11-22 09:57:33', 1),
(240, 260, 1, 0.00, 20.00, '2024-11-22 09:57:33', 1),
(241, 197, 1, 0.00, 10.00, '2024-11-22 09:57:33', 1),
(242, 182, 2, 0.00, 20.00, '2024-11-22 09:57:33', 1),
(243, 228, 1, 0.00, 400.00, '2024-11-22 09:57:33', 1),
(244, 173, 1, 0.00, 25.00, '2024-11-23 02:32:29', 1),
(245, 198, 3, 0.00, 45.00, '2024-11-23 02:32:29', 1),
(246, 131, 2, 0.00, 30.00, '2024-11-23 02:32:29', 1),
(247, 189, 1, 0.00, 10.00, '2024-11-23 02:32:29', 1),
(248, 198, 2, 0.00, 30.00, '2024-11-23 05:38:12', 1),
(249, 27, 1, 0.00, 70.00, '2024-11-23 09:44:49', 1),
(250, 74, 1, 50.00, 500.00, '2024-11-23 09:50:36', 1),
(251, 192, 1, 0.00, 10.00, '2024-11-24 01:01:18', 1),
(252, 249, 1, 0.00, 50.00, '2024-11-24 01:38:53', 1),
(253, 133, 1, 0.00, 5.00, '2024-11-24 01:38:53', 1),
(254, 197, 2, 0.00, 20.00, '2024-11-24 10:19:57', 1),
(255, 105, 1, 0.00, 100.00, '2024-11-25 02:07:19', 1),
(256, 192, 1, 0.00, 10.00, '2024-11-25 02:07:19', 1),
(257, 243, 1, 0.00, 30.00, '2024-11-25 02:07:19', 1),
(258, 13, 1, 0.00, 30.00, '2024-11-25 02:07:19', 1),
(259, 15, 2, 0.00, 40.00, '2024-11-25 02:07:19', 1),
(260, 249, 2, 0.00, 100.00, '2024-11-25 02:07:19', 1),
(261, 89, 1, 0.00, 40.00, '2024-11-25 02:31:15', 1),
(262, 173, 1, 0.00, 25.00, '2024-11-26 02:12:28', 1),
(263, 236, 1, 0.00, 20.00, '2024-11-26 02:12:28', 1),
(264, 242, 1, 0.00, 15.00, '2024-11-26 02:12:28', 1),
(265, 174, 1, 0.00, 40.00, '2024-11-26 02:12:28', 1),
(266, 197, 1, 0.00, 10.00, '2024-11-26 02:12:28', 1),
(267, 198, 1, 0.00, 15.00, '2024-11-26 02:12:28', 1),
(268, 244, 1, 0.00, 80.00, '2024-11-26 05:34:01', 1),
(269, 233, 1, 0.00, 5.00, '2024-11-26 05:34:01', 1),
(270, 292, 1, 0.00, 5.00, '2024-11-26 05:34:01', 1),
(271, 240, 1, 0.00, 120.00, '2024-11-27 01:27:55', 1),
(272, 182, 1, 0.00, 10.00, '2024-11-27 01:27:55', 1),
(273, 198, 1, 0.00, 15.00, '2024-11-27 01:27:55', 1),
(274, 216, 10, 5.00, 95.00, '2024-11-27 03:28:09', 1),
(275, 189, 10, 0.00, 100.00, '2024-11-27 12:53:46', 1),
(276, 298, 1, 25.00, 400.00, '2024-11-27 12:53:46', 1),
(277, 199, 1, 0.00, 70.00, '2024-11-27 12:55:32', 1),
(278, 192, 1, 0.00, 10.00, '2024-11-28 12:53:01', 1),
(279, 191, 1, 0.00, 5.00, '2024-11-28 12:53:01', 1),
(280, 260, 1, 0.00, 20.00, '2024-11-28 12:53:01', 1),
(281, 189, 1, 0.00, 10.00, '2024-11-28 12:53:01', 1),
(282, 66, 1, 0.00, 100.00, '2024-11-28 12:53:01', 1),
(283, 92, 1, 0.00, 70.00, '2024-11-28 12:53:01', 1),
(284, 236, 1, 0.00, 20.00, '2024-11-28 12:53:01', 1),
(286, 255, 1, 120.00, 0.00, '2024-12-13 01:26:17', 1),
(287, 55, 1, 650.00, 0.00, '2024-12-13 01:26:17', 1),
(288, 114, 1, 80.00, 0.00, '2024-12-13 01:26:17', 1),
(289, 240, 1, 0.00, 120.00, '2024-12-13 01:26:17', 1),
(290, 49, 1, 180.00, 0.00, '2024-12-13 01:37:26', 1),
(291, 14, 1, 250.00, 0.00, '2024-12-13 01:38:13', 1),
(292, 49, 1, 180.00, 0.00, '2024-12-13 03:24:21', 1),
(293, 303, 1, 30.00, 350.00, '2025-01-02 11:19:08', 1),
(294, 131, 2, 30.00, 0.00, '2025-01-17 05:57:27', 1),
(295, 117, 1, 180.00, 0.00, '2025-01-17 05:57:27', 1),
(296, 149, 1, 40.00, 0.00, '2025-01-17 05:57:27', 1),
(297, 284, 1, 450.00, 0.00, '2025-01-17 05:57:27', 1),
(298, 71, 1, 999.99, 0.00, '2025-01-17 05:57:27', 1),
(299, 151, 1, 170.00, 0.00, '2025-01-17 05:57:27', 1),
(300, 145, 1, 220.00, 0.00, '2025-01-17 05:58:04', 1),
(301, 250, 1, 30.00, 0.00, '2025-02-03 01:23:04', 1),
(302, 243, 1, 30.00, 0.00, '2025-02-03 01:23:04', 1),
(303, 218, 1, 10.00, 0.00, '2025-02-03 01:23:04', 1),
(304, 214, 1, 10.00, 0.00, '2025-02-03 01:23:04', 1),
(305, 233, 1, 5.00, 0.00, '2025-02-03 01:23:04', 1),
(306, 292, 1, 5.00, 0.00, '2025-02-03 01:23:04', 1),
(307, 189, 1, 10.00, 0.00, '2025-02-03 01:23:56', 1),
(308, 260, 3, 60.00, 0.00, '2025-02-03 01:30:27', 1),
(309, 192, 1, 10.00, 0.00, '2025-02-03 01:30:27', 1),
(310, 131, 4, 0.00, 60.00, '2025-02-07 03:48:40', 1),
(311, 291, 2, 0.00, 30.00, '2025-02-07 03:48:40', 1),
(312, 303, 1, 0.00, 380.00, '2025-02-07 03:48:40', 1),
(313, 168, 1, 0.00, 100.00, '2025-02-26 11:18:06', 1),
(314, 271, 1, 340.00, 0.00, '2025-02-26 11:20:11', 1),
(315, 111, 1, 30.00, 150.00, '2025-02-26 11:43:09', 1),
(316, 92, 1, 70.00, 0.00, '2025-02-26 11:43:09', 1),
(317, 237, 2, 0.00, 40.00, '2025-03-01 02:13:05', 1),
(318, 212, 1, 0.00, 20.00, '2025-03-04 12:22:06', 1),
(319, 214, 1, 0.00, 10.00, '2025-03-04 12:22:06', 1),
(320, 192, 1, 0.00, 10.00, '2025-03-04 12:22:06', 1),
(321, 305, 1, 999.99, 0.00, '2025-03-31 02:32:09', 1),
(322, 131, 1, 15.00, 0.00, '2025-03-31 02:32:10', 1),
(323, 306, 1, 750.00, 0.00, '2025-03-31 02:33:29', 1),
(324, 268, 1, 750.00, 0.00, '2025-04-06 11:52:12', 1),
(325, 305, 1, 999.99, 0.00, '2025-04-06 11:52:12', 1),
(326, 285, 1, 630.00, 0.00, '2025-04-06 11:52:12', 1),
(327, 201, 1, 25.00, 0.00, '2025-04-06 11:52:12', 1),
(328, 131, 1, 15.00, 0.00, '2025-04-06 11:52:12', 1),
(329, 288, 1, 15.00, 130.00, '2025-04-10 06:07:28', 1),
(330, 295, 1, 25.00, 95.00, '2025-04-10 06:07:29', 1),
(331, 186, 1, 100.00, 550.00, '2025-04-10 06:07:29', 1),
(332, 244, 5, 70.00, 330.00, '2025-04-10 06:07:29', 1),
(333, 245, 6, 60.00, 360.00, '2025-04-10 06:07:29', 1),
(334, 163, 1, 100.00, 0.00, '2025-04-15 11:35:45', 1),
(335, 114, 1, 80.00, 0.00, '2025-04-15 11:35:45', 1),
(336, 32, 1, 350.00, 0.00, '2025-05-05 09:23:19', 1),
(337, 261, 1, 0.00, 20.00, '2025-05-17 07:26:06', 1),
(338, 198, 2, 0.00, 30.00, '2025-05-17 07:26:06', 1),
(339, 262, 1, 20.00, 0.00, '2025-05-17 07:26:06', 1),
(340, 120, 1, 10.00, 0.00, '2025-05-17 07:26:06', 1),
(341, 302, 1, 130.00, 350.00, '2025-05-17 08:29:30', 1),
(342, 10, 1, 0.00, 130.00, '2025-05-17 11:59:44', 1),
(343, 42, 2, 10.00, 70.00, '2025-05-17 12:03:35', 1),
(344, 42, 1, 40.00, 0.00, '2025-05-17 12:38:03', 1),
(345, 247, 1, 0.00, 50.00, '2025-05-18 00:56:16', 1),
(346, 120, 1, 0.00, 10.00, '2025-05-18 10:57:09', 1),
(347, 257, 2, 0.00, 5.00, '2025-05-18 11:55:24', 1),
(348, 97, 1, 50.00, 800.00, '2025-05-18 12:37:35', 1),
(349, 211, 2, 0.00, 20.00, '2025-05-19 12:23:04', 1),
(350, 241, 1, 0.00, 25.00, '2025-05-21 10:43:40', 1),
(351, 173, 1, 0.00, 25.00, '2025-05-22 10:43:33', 1),
(352, 189, 1, 0.00, 10.00, '2025-05-22 11:53:12', 1),
(353, 120, 1, 0.00, 10.00, '2025-05-23 00:53:49', 1),
(354, 201, 1, 0.00, 25.00, '2025-05-26 10:38:55', 1),
(355, 192, 1, 0.00, 10.00, '2025-05-27 00:41:05', 1),
(356, 260, 1, 0.00, 20.00, '2025-05-27 01:37:08', 1),
(357, 18, 1, 999.99, 0.00, '2025-06-03 06:45:12', 1),
(358, 201, 1, 25.00, 0.00, '2025-06-16 10:36:56', 1),
(359, 73, 1, 700.00, 0.00, '2025-06-26 10:12:40', 1),
(360, 120, 1, 10.00, 0.00, '2025-06-30 08:05:33', 1),
(361, 81, 1, 650.00, 0.00, '2025-06-30 08:05:33', 1),
(362, 286, 1, 0.00, 165.00, '2025-07-20 09:38:03', 1),
(363, 21, 1, 0.00, 1000.00, '2025-07-20 09:38:03', 1),
(364, 95, 1, 0.00, 180.00, '2025-07-20 09:38:03', 1),
(365, 6, 1, 370.00, 0.00, '2025-07-20 09:38:03', 1),
(366, 89, 1, 40.00, 0.00, '2025-07-20 09:38:03', 1),
(367, 210, 1, 100.00, 200.00, '2025-07-20 09:41:54', 1),
(368, 90, 10, 800.00, 0.00, '2025-07-20 09:51:19', 1),
(369, 301, 1, 350.00, 0.00, '2025-07-20 09:51:19', 1),
(370, 10, 1, 130.00, 0.00, '2025-07-20 09:51:48', 1),
(371, 92, 1, 70.00, 0.00, '2025-07-20 09:52:20', 1),
(372, 209, 1, 0.00, 200.00, '2025-07-22 00:48:45', 1),
(373, 203, 1, 0.00, 35.00, '2025-07-22 00:48:45', 1),
(374, 253, 1, 150.00, 0.00, '2025-08-01 03:08:52', 1),
(375, 271, 1, 340.00, 0.00, '2025-08-13 11:43:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'nimesh', '$2y$10$j6q9KTHBqJSgPEiqEUgva.c6S3ouEqj4ugQ8F8g8ywrBsJFsopftO', 'admin'),
(4, 'aishwarya', '$2y$10$Gh84cMXOIRfUdB3bubfTee1JYKeMcS2u9wA/LzzT/MvrW//h8bCdG', 'staff'),
(5, 'pushpa', '$2y$10$b1Qp8d6nFoDUwuNnIEOsQOP8jtKs53qtfZy/pefrtrhua8NKBSLnG', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

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
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
