SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `billdetail` (
  `idBill` int DEFAULT NULL,
  `idProduct` int DEFAULT NULL,
  `size` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `idBill` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `receiver` varchar(100) DEFAULT NULL,
  `shippingAddress` varchar(250) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `totalBill` double DEFAULT NULL,
  `paymentMethod` varchar(250) DEFAULT NULL,
  `statusBill` int DEFAULT '1',
  `statusRemove` int DEFAULT '0',
  `orderTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approvalTime` timestamp NULL DEFAULT NULL,
  `deliveryTime` timestamp NULL DEFAULT NULL,
  `completionTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `idsubject` int NOT NULL,
  `subjectName` varchar(100) DEFAULT NULL,
  `subjectImage` varchar(200) DEFAULT NULL,
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`idsubject`, `subjectName`, `subjectImage`) VALUES
(1, 'Tiếng Việt', './image/logo/adidas.webp'),
(2, 'Toán', './image/logo/jordan.png'),
(3, 'Địa lý', './image/logo/nike.webp'),
(4, 'Lịch sử', './image/logo/converse.webp'),
(5, 'Hóa học', './image/logo/puma.webp');
(6, 'Tin học', './image/logo/puma.webp');
(7, 'Vật lý', './image/logo/puma.webp');
(8, 'Sinh học', './image/logo/puma.webp');
(9, 'Ngữ văn', './image/logo/puma.webp');
(10, 'Anh văn', './image/logo/puma.webp');







-- --------------------------------------------------------

--
-- Table structure for table `cartdetail`
--

CREATE TABLE `cartdetail` (
  `idCart` int DEFAULT NULL,
  `idProduct` int DEFAULT NULL,
  `size` double DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `totalProduct` double DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `cartdetail`
--
-- DELIMITER $$
CREATE TRIGGER `updateQuantityProduct` AFTER UPDATE ON `cartdetail` FOR EACH ROW BEGIN if (NEW.QUANTITY != OLD.QUANTITY) THEN
UPDATE carts
SET quantityProduct = (
    SELECT SUM(QUANTITY)
    FROM cartDetail
    WHERE IDCART = NEW.IDCART
  ),
  total = (
    SELECT SUM(TOTAL)
    FROM cartDetail
    WHERE IDCART = NEW.IDCART
  )
WHERE IDCART = NEW.IDCART;
END if;
END
-- $$
-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `idCart` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `quantityProduct` int DEFAULT '0',
  `total` double DEFAULT '0',
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`idCart`, `idUser`, `quantityProduct`, `total`, `createAt`, `updateAt`) VALUES
(1, 1, 0, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(2, 2, 0, 0, '2025-02-26 14:09:51', '2025-02-26 14:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `idEvaluation` int NOT NULL,
  `idBill` int DEFAULT NULL,
  `idProduct` int DEFAULT NULL,
  `content` varchar(250) DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `createAtEvaluation` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imageproducts`
--

CREATE TABLE `imageproducts` (
  `idImage` int NOT NULL,
  `idProduct` int DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `imageproducts`
--

INSERT INTO `imageproducts` (`idImage`, `idProduct`, `image`) VALUES
(1, 1, './image/products/1.webp'),
(2, 1, './image/products/1-1.webp'),
(3, 1, './image/products/1-2.webp'),
(4, 1, './image/products/1-3.webp'),
(5, 1, './image/products/1-4.webp'),
(6, 2, './image/products/2.webp'),
(7, 2, './image/products/2-1.webp'),
(8, 2, './image/products/2-2.webp'),
(9, 2, './image/products/2-3.webp'),
(10, 3, './image/products/3.webp'),
(11, 3, './image/products/3-1.webp'),
(12, 3, './image/products/3-2.webp'),
(13, 3, './image/products/3-3.webp'),
(14, 3, './image/products/3-4.webp'),
(15, 3, './image/products/3-5.webp'),
(16, 4, './image/products/4.webp'),
(17, 4, './image/products/4-1.webp'),
(18, 4, './image/products/4-2.webp'),
(19, 4, './image/products/4-3.webp'),
(20, 4, './image/products/4-4.webp'),
(21, 4, './image/products/4-5.webp'),
(22, 5, './image/products/5.webp'),
(23, 5, './image/products/5-1.webp'),
(24, 5, './image/products/5-2.webp'),
(25, 5, './image/products/5-3.webp'),
(26, 5, './image/products/5-4.webp'),
(27, 5, './image/products/5-5.webp'),
(28, 6, './image/products/6.webp'),
(29, 6, './image/products/6-1.webp'),
(30, 6, './image/products/6-2.webp'),
(31, 6, './image/products/6-3.webp'),
(32, 6, './image/products/6-4.webp'),
(33, 6, './image/products/6-5.webp'),
(34, 7, './image/products/7.webp'),
(35, 7, './image/products/7-1.webp'),
(36, 7, './image/products/7-2.webp'),
(37, 7, './image/products/7-3.webp'),
(38, 7, './image/products/7-4.webp'),
(39, 7, './image/products/7-5.webp'),
(40, 8, './image/products/8.webp'),
(41, 8, './image/products/8-1.webp'),
(42, 8, './image/products/8-2.webp'),
(43, 8, './image/products/8-3.webp'),
(44, 8, './image/products/8-4.webp'),
(45, 9, './image/products/9.jpg'),
(46, 9, './image/products/9-1.webp'),
(47, 9, './image/products/9-2.webp'),
(48, 9, './image/products/9-3.webp'),
(49, 9, './image/products/9-4.webp'),
(50, 10, './image/products/10.webp'),
(51, 10, './image/products/10-1.webp'),
(52, 10, './image/products/10-2.webp'),
(53, 10, './image/products/10-3.webp'),
(54, 10, './image/products/10-4.webp'),
(55, 11, './image/products/11.webp'),
(56, 11, './image/products/11-1.webp'),
(57, 11, './image/products/11-2.webp'),
(58, 11, './image/products/11-3.webp'),
(59, 11, './image/products/11-4.webp'),
(60, 11, './image/products/11-5.webp'),
(61, 12, './image/products/12.webp'),
(62, 12, './image/products/12-1.webp'),
(63, 12, './image/products/12-2.webp'),
(64, 12, './image/products/12-3.webp'),
(65, 12, './image/products/12-4.webp'),
(66, 13, './image/products/13.webp'),
(67, 13, './image/products/13-1.webp'),
(68, 13, './image/products/13-2.webp'),
(69, 13, './image/products/13-3.webp'),
(70, 13, './image/products/13-4.webp'),
(71, 14, './image/products/14.webp'),
(72, 14, './image/products/14-1.webp'),
(73, 14, './image/products/14-2.webp'),
(74, 14, './image/products/14-3.webp'),
(75, 14, './image/products/14-4.webp'),
(76, 15, './image/products/15.webp'),
(77, 15, './image/products/15-1.webp'),
(78, 15, './image/products/15-2.webp'),
(79, 15, './image/products/15-3.webp'),
(80, 15, './image/products/15-4.webp'),
(81, 16, './image/products/16.webp'),
(82, 16, './image/products/16-1.webp'),
(83, 16, './image/products/16-2.webp'),
(84, 16, './image/products/16-3.webp'),
(85, 16, './image/products/16-4.webp'),
(86, 17, './image/products/17.webp'),
(87, 17, './image/products/17-1.webp'),
(88, 17, './image/products/17-2.webp'),
(89, 17, './image/products/17-3.webp'),
(90, 17, './image/products/17-4.webp'),
(91, 18, './image/products/18.webp'),
(92, 18, './image/products/18-1.webp'),
(93, 18, './image/products/18-2.webp'),
(94, 18, './image/products/18-3.webp'),
(95, 18, './image/products/18-4.webp'),
(96, 19, './image/products/19.webp'),
(97, 19, './image/products/19-1.webp'),
(98, 19, './image/products/19-2.webp'),
(99, 19, './image/products/19-3.webp'),
(100, 19, './image/products/19-4.webp'),
(101, 20, './image/products/20.webp'),
(102, 20, './image/products/20-1.webp'),
(103, 20, './image/products/20-2.webp'),
(104, 20, './image/products/20-3.webp'),
(105, 20, './image/products/20-4.webp'),
(106, 21, './image/products/21.webp'),
(107, 21, './image/products/21-1.webp'),
(108, 21, './image/products/21-2.webp'),
(109, 22, './image/products/22.webp'),
(110, 22, './image/products/22-1.webp'),
(111, 22, './image/products/22-2.webp'),
(112, 22, './image/products/22-3.webp'),
(113, 22, './image/products/22-4.webp'),
(114, 23, './image/products/23.webp'),
(115, 23, './image/products/23-1.webp'),
(116, 23, './image/products/23-2.webp'),
(117, 23, './image/products/23-3.webp'),
(118, 23, './image/products/23-4.webp'),
(119, 24, './image/products/24.webp'),
(120, 24, './image/products/24-1.webp'),
(121, 24, './image/products/24-2.webp'),
(122, 24, './image/products/24-3.webp'),
(123, 24, './image/products/24-4.webp'),
(124, 25, './image/products/25.webp'),
(125, 25, './image/products/25-1.webp'),
(126, 25, './image/products/25-2.webp'),
(127, 25, './image/products/25-3.webp'),
(128, 26, './image/products/26.webp'),
(129, 26, './image/products/26-1.webp'),
(130, 26, './image/products/26-2.webp'),
(131, 26, './image/products/26-3.webp'),
(132, 26, './image/products/26-4.webp'),
(133, 26, './image/products/26-5.webp'),
(134, 27, './image/products/27.webp'),
(135, 27, './image/products/27-1.webp'),
(136, 27, './image/products/27-2.webp'),
(137, 27, './image/products/27-3.webp'),
(138, 28, './image/products/28.webp'),
(139, 28, './image/products/28-1.webp'),
(140, 28, './image/products/28-2.webp'),
(141, 28, './image/products/28-3.webp'),
(142, 28, './image/products/28-4.webp'),
(143, 29, './image/products/29.webp'),
(144, 29, './image/products/29-1.webp'),
(145, 29, './image/products/29-2.webp'),
(146, 30, './image/products/30.webp'),
(147, 30, './image/products/30-1.webp'),
(148, 30, './image/products/30-2.webp'),
(149, 30, './image/products/30-3.webp'),
(150, 30, './image/products/30-4.webp'),
(151, 31, './image/products/31.webp'),
(152, 31, './image/products/31-1.webp'),
(153, 31, './image/products/31-2.webp'),
(154, 32, './image/products/32.webp'),
(155, 32, './image/products/32-1.webp'),
(156, 32, './image/products/32-2.webp'),
(157, 32, './image/products/32-3.webp'),
(158, 32, './image/products/32-4.webp'),
(159, 33, './image/products/33.webp'),
(160, 33, './image/products/33-1.webp'),
(161, 33, './image/products/33-2.webp'),
(162, 33, './image/products/33-3.webp'),
(163, 34, './image/products/34.webp'),
(164, 34, './image/products/34-1.webp'),
(165, 34, './image/products/34-2.webp'),
(166, 35, './image/products/35.webp'),
(167, 35, './image/products/35-1.webp'),
(168, 35, './image/products/35-2.webp'),
(169, 35, './image/products/35-3.webp'),
(170, 36, './image/products/36.webp'),
(171, 36, './image/products/36-1.webp'),
(172, 36, './image/products/36-2.webp'),
(173, 36, './image/products/36-3.webp'),
(174, 37, './image/products/37.webp'),
(175, 37, './image/products/37-1.webp'),
(176, 37, './image/products/37-2.webp'),
(177, 37, './image/products/37-3.webp'),
(178, 37, './image/products/37-4.webp'),
(179, 38, './image/products/38.webp'),
(180, 38, './image/products/38-1.webp'),
(181, 38, './image/products/38-2.webp'),
(182, 38, './image/products/38-3.webp'),
(183, 39, './image/products/39.webp'),
(184, 39, './image/products/39-1.webp'),
(185, 39, './image/products/39-2.webp'),
(186, 39, './image/products/39-3.webp'),
(187, 39, './image/products/39-4.webp'),
(188, 40, './image/products/40.webp'),
(189, 40, './image/products/40-1.webp'),
(190, 40, './image/products/40-2.webp');

-- --------------------------------------------------------

--
-- Table structure for table `permissiongroups`
--

CREATE TABLE `permissiongroups` (
  `idPermission` int NOT NULL,
  `permissionName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `permissiongroups`
--

INSERT INTO `permissiongroups` (`idPermission`, `permissionName`) VALUES
(1, 'Quản lý khách hàng'),
(2, 'Quản lý nhân viên'),
(3, 'Quản lý sản phẩm'),
(4, 'Quản lý bán hàng'),
(5, 'Quản lý nhập hàng'),
(6, 'Quản lý phân quyền'),
(7, 'Quản lý danh mục'),
(8, 'Quản lý nhà cung cấp');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `idBook` int NOT NULL,
  `idSubject` int DEFAULT NULL,

  `class` int NOT NULL,
  `oldPrice` double DEFAULT '0',
  `currentPrice` double DEFAULT '0',
  `quantitySold` int DEFAULT '0',

  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`idBook`, `idSubject`, `class`, `oldPrice`, `currentPrice`, `quantitySold`, `createAt`, `updateAt`) VALUES
(1, 1, 1, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(2, 4, 1, 10790000, 10090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(3, 7, 1, 0, 60090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(4, 2,1, 6490000, 3690000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(5, 5, 2, 4690000, 3390000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(6, 8, 2, 3690000, 2890000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(7, 3, 2, 6890000, 6390000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(8, 6,  2, 168000000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(9, 9, 3, 3590000, 2590000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(10, 1,3, 0, 189000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(11, 4, 3, 0, 4890000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(12, 7,3, 0, 1990000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(13, 2, 4, 0, 4490000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(14, 5, 4, 3690000, 2190000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(15, 8,4, 3790000, 3390000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(16, 3, 4, 3790000, 3290000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(17, 6, 5, 0, 7900000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(18, 9, 5, 9090000, 7890000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(19, 1, 5, 0, 10690000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(20, 4,  5, 5090000, 3890000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(21, 7,  6, 3090000, 1500000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(22, 2, 6, 2490000, 1990000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(23, 5,  6, 0, 2490000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(24, 8,  6, 0, 2890000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(25, 3,  7, 2200000, 1390000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(26, 6, 7, 4690000, 1690000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(27, 9,  7, 2500000, 1790000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(28, 1,  7, 0, 2890000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(29, 4,  8, 2600000, 1590000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(30, 7, 8, 2990000, 1490000, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(31,2,  8, 5090000, 3990000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(32, 5,  8, 0, 3190000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(33, 8, 9 2500000, 1290000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(34, 3,  9 0, 4490000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(35, 6, 9 3190000, 2290000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(36, 9,  9, 1890000, 1590000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(37, 1, 10, 0, 2090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(38, 4,  10, 2490000, 2190000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(39, 7,  10, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(40, 2,  10, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(41, 2,  11, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(42, 5,  11, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(43, 8,  11, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(44, 3,  11, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(45, 6,  12, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(46, 9,  12, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(47,1,  12, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');
(48, 4,  12, 0, 3090000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `receiptdetail`
--

CREATE TABLE `receiptdetail` (
  `idReceipt` int DEFAULT NULL,
  `idSupplier` int DEFAULT NULL,
  `idProduct` int DEFAULT NULL,
  `size` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `pucharsePrice` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `receiptdetail`
--



-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `idReceipt` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `staff` varchar(100) DEFAULT NULL,
  `totalReceipt` double DEFAULT NULL,
  `statusRemove` int DEFAULT '0',
  `createTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `receipts`
--


-- --------------------------------------------------------

--
-- Table structure for table `roledetail`
--

CREATE TABLE `roledetail` (
  `idRole` int DEFAULT NULL,
  `idPermission` int DEFAULT NULL,
  `idTask` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roledetail`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `idRole` int NOT NULL,
  `roleName` varchar(100) DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `sizeproducts`
--

CREATE TABLE `sizeproducts` (
  `idProduct` int DEFAULT NULL,
  `size` double DEFAULT NULL,
  `statusSize` int DEFAULT '1',
  `quantityRemain` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- --------------------------------------------------------

--
-- Table structure for table `subsubjects`
--

CREATE TABLE `subsubjects` (
  `idsubject` int DEFAULT NULL,
  `subsubjectName` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subsubjects`
--

INSERT INTO `subsubjects` (`idsubject`, `subsubjectName`) VALUES
(1, 'Yeezy'),
(1, 'Ultra Boost'),
(1, 'Stand Smith'),
(2, 'Air Jordan 1'),
(2, 'Air Jordan 1 Low'),
(2, 'Air Jordan 1 Mid'),
(2, 'Air Jordan 1 High'),
(3, 'Air force 1'),
(3, 'Air max'),
(3, 'Nike blazer'),
(4, 'Converse 1970s'),
(4, 'Run Star Hike'),
(4, 'Run Star Motion'),
(4, 'All Star'),
(5, 'Puma RS'),
(5, 'Puma Mule'),
(5, 'Puma Thunder');

-- --------------------------------------------------------

--
-- Table structure for table `supplierdetail`
--

CREATE TABLE `supplierdetail` (
  `idSupplier` int DEFAULT NULL,
  `idProduct` int DEFAULT NULL,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `idTask` int NOT NULL,
  `taskName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`idTask`, `taskName`) VALUES
(1, 'thêm'),
(2, 'xoá'),
(3, 'sửa'),
(4, 'xem');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int NOT NULL,
  `idRole` int DEFAULT '1',
  `fullName` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT './avatar/default-avatar.jpg',
  `status` int DEFAULT '1',
  `statusRemove` int DEFAULT '0',
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `idRole`, `fullName`, `phoneNumber`, `username`, `password`, `email`, `avatar`, `status`, `statusRemove`, `createAt`, `updateAt`) VALUES
(1, 2, 'admin', '0123456789', 'admin123', '$2y$10$bgyVh0xTbFU8kFRVan1AK.lh03ISwS53j0162crPEby.Y90k85CUC', NULL, './avatar/default-avatar.jpg', 1, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(2, 2, 'nguyễn thành nam', '0912345678', 'thanhnam123', '$2y$10$5gSznaOeH2OcipJpAKlDVOO0ip214yZOFuH316681YhWuTZLYd3Lm', NULL, './avatar/default-avatar.jpg', 1, 0, '2025-02-26 14:09:51', '2025-02-26 14:10:00');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `createCart` AFTER INSERT ON `users` FOR EACH ROW BEGIN
INSERT INTO CARTS (IDUSER)
VALUES (NEW.IDUSER);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usershippingaddress`
--

CREATE TABLE `usershippingaddress` (
  `idAddress` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `status` int DEFAULT '0',
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billdetail`
--
ALTER TABLE `billdetail`
  ADD KEY `idBill` (`idBill`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`idBill`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`idsubject`);

--
-- Indexes for table `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD KEY `idCart` (`idCart`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`idCart`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`idEvaluation`),
  ADD KEY `idBill` (`idBill`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `imageproducts`
--
ALTER TABLE `imageproducts`
  ADD PRIMARY KEY (`idImage`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `permissiongroups`
--
ALTER TABLE `permissiongroups`
  ADD PRIMARY KEY (`idPermission`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `idsubject` (`idsubject`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`idReceipt`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `roledetail`
--
ALTER TABLE `roledetail`
  ADD KEY `idRole` (`idRole`),
  ADD KEY `idPermission` (`idPermission`),
  ADD KEY `idTask` (`idTask`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `sizeproducts`
--
ALTER TABLE `sizeproducts`
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `subsubjects`
--
ALTER TABLE `subsubjects`
  ADD KEY `idsubject` (`idsubject`);

--
-- Indexes for table `supplierdetail`
--
ALTER TABLE `supplierdetail`
  ADD KEY `idSupplier` (`idSupplier`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`idSupplier`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`idTask`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idRole` (`idRole`);

--
-- Indexes for table `usershippingaddress`
--
ALTER TABLE `usershippingaddress`
  ADD PRIMARY KEY (`idAddress`),
  ADD KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `idBill` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `idsubject` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `idCart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `idEvaluation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imageproducts`
--
ALTER TABLE `imageproducts`
  MODIFY `idImage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `permissiongroups`
--
ALTER TABLE `permissiongroups`
  MODIFY `idPermission` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `idProduct` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `idReceipt` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `idSupplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `idTask` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usershippingaddress`
--
ALTER TABLE `usershippingaddress`
  MODIFY `idAddress` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billdetail`
--
ALTER TABLE `billdetail`
  ADD CONSTRAINT `billdetail_ibfk_1` FOREIGN KEY (`idBill`) REFERENCES `bills` (`idBill`),
  ADD CONSTRAINT `billdetail_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD CONSTRAINT `cartdetail_ibfk_1` FOREIGN KEY (`idCart`) REFERENCES `carts` (`idCart`),
  ADD CONSTRAINT `cartdetail_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`idBill`) REFERENCES `bills` (`idBill`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `imageproducts`
--
ALTER TABLE `imageproducts`
  ADD CONSTRAINT `imageproducts_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idsubject`) REFERENCES `subjects` (`idsubject`);

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `roledetail`
--
ALTER TABLE `roledetail`
  ADD CONSTRAINT `roledetail_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`),
  ADD CONSTRAINT `roledetail_ibfk_2` FOREIGN KEY (`idPermission`) REFERENCES `permissiongroups` (`idPermission`),
  ADD CONSTRAINT `roledetail_ibfk_3` FOREIGN KEY (`idTask`) REFERENCES `tasks` (`idTask`);

--
-- Constraints for table `sizeproducts`
--
ALTER TABLE `sizeproducts`
  ADD CONSTRAINT `sizeproducts_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `subsubjects`
--
ALTER TABLE `subsubjects`
  ADD CONSTRAINT `subsubjects_ibfk_1` FOREIGN KEY (`idsubject`) REFERENCES `subjects` (`idsubject`);

--
-- Constraints for table `supplierdetail`
--
ALTER TABLE `supplierdetail`
  ADD CONSTRAINT `supplierdetail_ibfk_1` FOREIGN KEY (`idSupplier`) REFERENCES `suppliers` (`idSupplier`),
  ADD CONSTRAINT `supplierdetail_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`idProduct`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`);

--
-- Constraints for table `usershippingaddress`
--
ALTER TABLE `usershippingaddress`
  ADD CONSTRAINT `usershippingaddress_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

