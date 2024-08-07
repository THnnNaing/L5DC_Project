-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 03:43 PM
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
-- Database: `tempest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `admin_id` varchar(10) NOT NULL,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_password` varchar(100) DEFAULT NULL,
  `admin_email` varchar(50) DEFAULT NULL,
  `admin_phnum` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`admin_id`, `admin_name`, `admin_password`, `admin_email`, `admin_phnum`) VALUES
('AID-00001', 'Thi Han', 'ajkUI90&*(', 'thihannaing123@gmail.com', '09876543456'),
('AID-00002', 'mike', 'mike123MK!@#', 'mike12@gmail.com', '123123123'),
('AID-00003', 'Poe', '123#$%^TYUhjkl', 'poe2@gmail.com', '09876567123'),
('AID-00004', 'PoePa', 'asTY3456#$%^&', 'poe212@gmail.com', '09876567123');

-- --------------------------------------------------------

--
-- Table structure for table `author_tb`
--

CREATE TABLE `author_tb` (
  `Author_ID` varchar(10) NOT NULL,
  `Author_Name` varchar(50) NOT NULL,
  `Author_Bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author_tb`
--

INSERT INTO `author_tb` (`Author_ID`, `Author_Name`, `Author_Bio`) VALUES
('AUID-00001', 'poepoe', 'kkkk'),
('AUID-00002', 'thi han', 'Thi Han book'),
('AUID-00003', 'JK Rowling', 'abc'),
('AUID-00004', 'J.R.R.Tolkien', 'Best author ever'),
('AUID-00005', 'Eiiichiro Oda', 'Best Mangaka of All Time'),
('AUID-00006', 'George R. R. Martin', 'Writer of Game of Thrones\r\n'),
('AUID-00007', 'Lwin Min Thant', 'Lorem abcd');

-- --------------------------------------------------------

--
-- Table structure for table `book_tb`
--

CREATE TABLE `book_tb` (
  `book_id` varchar(10) NOT NULL,
  `book_name` varchar(50) DEFAULT NULL,
  `book_qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `book_desc` varchar(255) DEFAULT NULL,
  `book_img` varchar(255) DEFAULT NULL,
  `Author_ID` varchar(10) DEFAULT NULL,
  `publisher_id` varchar(10) DEFAULT NULL,
  `isbn_id` varchar(10) DEFAULT NULL,
  `category_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_tb`
--

INSERT INTO `book_tb` (`book_id`, `book_name`, `book_qty`, `price`, `book_desc`, `book_img`, `Author_ID`, `publisher_id`, `isbn_id`, `category_id`) VALUES
('BID-00003', 'One Piece Romance Dawn Arc', 6, 10000, 'Romance Dawn Arc of One Piece', '../Addimg/665ddfdc40454_Romance Dawn.jpg', 'AUID-00005', 'PUID-00005', 'IsID-00001', 'CTID-00007'),
('BID-00004', 'Souma Tome Japanese N1 Goi ', 20, 5000, 'Souma Tome Japanese N1 Goi  For learners', '../Addimg/665de02d1ab0c_n1 goi.jpg', 'AUID-00002', 'PUID-00004', 'IsID-00012', 'CTID-00008'),
('BID-00005', 'How to find money', 5, 5000, 'The ways to find money ', '../Addimg/665de189d412f_MyanmarBook1.jpg', 'AUID-00001', 'PUID-00006', 'IsID-00012', 'CTID-00008'),
('BID-00006', 'Harry Potter and the Philosopher Stone', 8, 100000, 'Harry Potter and the Philosopher Stone (The First Book of Harry Potter Fanchise)', '../Addimg/665de366cf7d9_Harry Potter and the Philosopher Stone.jpg', 'AUID-00003', 'PUID-00005', 'IsID-00015', 'CTID-00005'),
('BID-00007', 'The Armageddon Rag', 5, 100000, 'The Armageddon Rag by George R.R.Martin', '../Addimg/665de3d377bc2_The Armageddon Rag.jpg', 'AUID-00006', 'PUID-00006', 'IsID-00013', 'CTID-00005'),
('BID-00008', 'Harry Potter And Deathly Hollows', 4, 5000, 'Harry Potter and Deathly Hollows', '../Addimg/66719bc687fd8_English_Harry_Potter_7_Epub_9781781100264.jpg', 'AUID-00001', 'PUID-00005', 'IsID-00001', 'CTID-00005'),
('BID-00009', 'Minna no nihongo N5', 30, 5000, 'Minna no nihongo N5 for Japanese Starters', '../Addimg/668643ee8c443_images.jpg', 'AUID-00003', 'PUID-00003', 'IsID-00014', 'CTID-00008');

-- --------------------------------------------------------

--
-- Table structure for table `category_tb`
--

CREATE TABLE `category_tb` (
  `category_id` varchar(10) NOT NULL,
  `category` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_tb`
--

INSERT INTO `category_tb` (`category_id`, `category`) VALUES
('CTID-00001', 'Comedy'),
('CTID-00002', 'Action'),
('CTID-00003', 'Horror'),
('CTID-00004', 'Documentary '),
('CTID-00005', 'Fantasy'),
('CTID-00006', 'Romance'),
('CTID-00007', 'Japanese Manga'),
('CTID-00008', 'Learning'),
('CTID-00009', 'Biography'),
('CTID-00010', 'PG-13'),
('CTID-00011', 'For Kids'),
('CTID-00012', 'R-18');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tb`
--

CREATE TABLE `customer_tb` (
  `customer_id` varchar(10) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_email` varchar(40) DEFAULT NULL,
  `customer_password` varchar(50) DEFAULT NULL,
  `customer_dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tb`
--

INSERT INTO `customer_tb` (`customer_id`, `customer_name`, `customer_email`, `customer_password`, `customer_dob`) VALUES
('CID-00001', 'Author', 'abc123@gmail.com', 'abcAbc123!@#', '2006-07-20'),
('CID-00002', 'Thi', 'thi123@gmail.com', 'saj;bjYUO123', '2008-02-26'),
('CID-00003', 'Emilia', 'em12@gmail.com', 'asBB123@#', '2009-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `isbn_tb`
--

CREATE TABLE `isbn_tb` (
  `isbn_id` varchar(10) NOT NULL,
  `isbn_num` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `isbn_tb`
--

INSERT INTO `isbn_tb` (`isbn_id`, `isbn_num`) VALUES
('IsID-00001', '567898765433456'),
('IsID-00002', '1234567891011'),
('IsID-00003', '0987654321123'),
('IsID-00004', '9780575083847'),
('IsID-00005', '9781451627282'),
('IsID-00006', '9780143106101'),
('IsID-00007', '9780061120083'),
('IsID-00008', '9780441017990'),
('IsID-00009', '9780316015844'),
('IsID-00010', '9780525949892'),
('IsID-00011', '9780765326350'),
('IsID-00012', '9780375831003'),
('IsID-00013', '9780062120435'),
('IsID-00014', '9780553380958'),
('IsID-00015', '9780385335483');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `order_id` varchar(10) NOT NULL,
  `book_id` varchar(10) NOT NULL,
  `Product_Price` int(11) NOT NULL,
  `BuyQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`order_id`, `book_id`, `Product_Price`, `BuyQty`) VALUES
('ORD-00007', ' BID-00004', 5000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_tb`
--

CREATE TABLE `order_tb` (
  `order_id` varchar(10) NOT NULL,
  `order_date` date DEFAULT NULL,
  `orderTotalAmount` int(11) DEFAULT NULL,
  `orderTax` int(11) NOT NULL,
  `orderAllTotal` int(11) NOT NULL,
  `orderTotalQuantity` int(11) NOT NULL,
  `remark` varchar(30) NOT NULL,
  `payment_type` varchar(30) NOT NULL,
  `order_location` varchar(255) NOT NULL,
  `order_phone` varchar(15) NOT NULL,
  `order_status` varchar(15) NOT NULL,
  `customer_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tb`
--

INSERT INTO `order_tb` (`order_id`, `order_date`, `orderTotalAmount`, `orderTax`, `orderAllTotal`, `orderTotalQuantity`, `remark`, `payment_type`, `order_location`, `order_phone`, `order_status`, `customer_id`) VALUES
('ORD-00001', '2024-06-22', 20000, 1000, 21000, 4, ' 567gh', 'MPU', 'lsdkjaflkasdjf;las', '0987655678', '0', 'CID-00001'),
('ORD-00002', '2024-06-25', 25000, 1250, 26250, 5, ' ', 'MPU', 'asfadsfwedxzc', '0987654321', '0', 'CID-00003'),
('ORD-00003', '2024-06-25', 10000, 500, 10500, 1, ' ', 'MPU', '4hdsfkj', '56789098765', '0', 'CID-00002'),
('ORD-00004', '2024-06-27', 10000, 500, 10500, 1, ' asdfasdf', 'MPU', 'asdfasdfasdf', '09966788990', 'Confirmed', 'CID-00002'),
('ORD-00005', '2024-07-10', 10000, 500, 10500, 2, ' nothing', 'COD', 'ashdjkflaskdfhjl', '56789098765', 'Confirmed', 'CID-00001'),
('ORD-00006', '2024-07-12', 10000, 500, 10500, 2, ' ', 'COD', 'asdfasdfas', '56789098765', 'Confirmed', 'CID-00002'),
('ORD-00007', '2024-07-12', 10000, 500, 10500, 2, ' ', 'COD', 'asdfasdfas', '09876543456', 'Confirmed', 'CID-00002');

-- --------------------------------------------------------

--
-- Table structure for table `payment_tb`
--

CREATE TABLE `payment_tb` (
  `payment_id` varchar(10) NOT NULL,
  `payment_amount` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher_tb`
--

CREATE TABLE `publisher_tb` (
  `publisher_id` varchar(10) NOT NULL,
  `publisher_name` varchar(50) DEFAULT NULL,
  `publisher_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher_tb`
--

INSERT INTO `publisher_tb` (`publisher_id`, `publisher_name`, `publisher_desc`) VALUES
('PUID-00001', 'Daw Poe Publishing', 'Writes book'),
('PUID-00002', 'Venturers', 'lorem abc'),
('PUID-00003', 'JK Publishing', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam tempora debitis nobis expedita iste earum nisi architecto delectus fugiat eos natus, exercitationem nihil, beatae velit totam ducimus sequi inventore laboriosam.'),
('PUID-00004', 'ABC Publishing', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam tempora debitis nobis expedita iste earum nisi architecto delectus fugiat eos natus, exercitationem nihil, beatae velit totam ducimus sequi inventore laboriosam.'),
('PUID-00005', 'Inkwell Press', 'Inkwell Press'),
('PUID-00006', 'Serene Scribe Publishing', 'Serene Scribe Publishing\r\n'),
('PUID-00007', 'Quill & Compass Books', 'Quill & Compass Books'),
('PUID-00008', 'Luminary Lit', 'Luminary Lit'),
('PUID-00009', 'Arcadia Publishing House', 'Arcadia Publishing House\r\n\r\n'),
('PUID-00010', 'Nexus Novels', 'Nexus Novels'),
('PUID-00011', 'Spectra Books', 'Spectra Books\r\n'),
('PUID-00012', 'Verdant Valley Press', 'Verdant Valley Press'),
('PUID-00013', 'Pinnacle Publishing Co.', 'Pinnacle Publishing Co.'),
('PUID-00014', 'Horizon House Books', 'Horizon House Books');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail_tb`
--

CREATE TABLE `purchasedetail_tb` (
  `purchase_id` varchar(10) DEFAULT NULL,
  `unit_price` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `book_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchasedetail_tb`
--

INSERT INTO `purchasedetail_tb` (`purchase_id`, `unit_price`, `qty`, `book_id`) VALUES
('P-000002', 5000, 5, 'BID-00003'),
('P-00002', 5000, 1, 'BID-00006'),
('P-00002', 5000, 1, 'BID-00004'),
('P-00003', 5000, 1, 'BID-00004'),
('P-00004', 5000, 1, 'BID-00006'),
('P-00006', 10000, 20, 'BID-00004');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_tb`
--

CREATE TABLE `purchase_tb` (
  `purchase_id` varchar(10) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_amount` int(11) DEFAULT NULL,
  `purchase_tax` int(11) NOT NULL,
  `purchase_total_amount` int(11) DEFAULT NULL,
  `supplier_id` varchar(10) DEFAULT NULL,
  `purchase_status` varchar(15) NOT NULL,
  `admin_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_tb`
--

INSERT INTO `purchase_tb` (`purchase_id`, `purchase_date`, `purchase_amount`, `purchase_tax`, `purchase_total_amount`, `supplier_id`, `purchase_status`, `admin_id`) VALUES
('P-000002', '2024-06-06', 0, 0, 0, 'SID-00001', '0', 'AID-00001'),
('P-00001', '2024-06-02', 0, 0, 0, 'SID-00001', '0', 'AID-00001'),
('P-00002', '2024-06-06', 0, 0, 0, 'SID-00001', '0', 'AID-00001'),
('P-00003', '2024-06-09', 5000, 250, 5250, 'SID-00001', '0', 'AID-00001'),
('P-00004', '2024-06-09', 5000, 250, 5250, 'SID-00001', 'Confirmed', 'AID-00001'),
('P-00005', '2024-07-04', 200000, 10000, 210000, 'SID-00001', 'Confirmed', 'AID-00001'),
('P-00006', '2024-07-04', 200000, 10000, 210000, 'SID-00001', 'Confirmed', 'AID-00001');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_tb`
--

CREATE TABLE `supplier_tb` (
  `supplier_id` varchar(10) NOT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_email` varchar(40) DEFAULT NULL,
  `supplier_password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_tb`
--

INSERT INTO `supplier_tb` (`supplier_id`, `supplier_name`, `supplier_email`, `supplier_password`) VALUES
('SID-00001', 'DawPoe', 'poepoe12@gmail.com', 'as123!@#AS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `author_tb`
--
ALTER TABLE `author_tb`
  ADD PRIMARY KEY (`Author_ID`);

--
-- Indexes for table `book_tb`
--
ALTER TABLE `book_tb`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `publisher_id` (`publisher_id`),
  ADD KEY `isbn_id` (`isbn_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `Author_ID` (`Author_ID`);

--
-- Indexes for table `category_tb`
--
ALTER TABLE `category_tb`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer_tb`
--
ALTER TABLE `customer_tb`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `isbn_tb`
--
ALTER TABLE `isbn_tb`
  ADD PRIMARY KEY (`isbn_id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `order_tb`
--
ALTER TABLE `order_tb`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payment_tb`
--
ALTER TABLE `payment_tb`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `publisher_tb`
--
ALTER TABLE `publisher_tb`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `purchasedetail_tb`
--
ALTER TABLE `purchasedetail_tb`
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `purchase_tb`
--
ALTER TABLE `purchase_tb`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `supplier_tb`
--
ALTER TABLE `supplier_tb`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_tb`
--
ALTER TABLE `book_tb`
  ADD CONSTRAINT `book_tb_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher_tb` (`publisher_id`),
  ADD CONSTRAINT `book_tb_ibfk_2` FOREIGN KEY (`isbn_id`) REFERENCES `isbn_tb` (`isbn_id`),
  ADD CONSTRAINT `book_tb_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category_tb` (`category_id`);

--
-- Constraints for table `order_tb`
--
ALTER TABLE `order_tb`
  ADD CONSTRAINT `order_tb_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_tb` (`customer_id`);

--
-- Constraints for table `purchasedetail_tb`
--
ALTER TABLE `purchasedetail_tb`
  ADD CONSTRAINT `purchasedetail_tb_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_tb` (`purchase_id`),
  ADD CONSTRAINT `purchasedetail_tb_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book_tb` (`book_id`);

--
-- Constraints for table `purchase_tb`
--
ALTER TABLE `purchase_tb`
  ADD CONSTRAINT `purchase_tb_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_tb` (`supplier_id`),
  ADD CONSTRAINT `purchase_tb_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_tb` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
