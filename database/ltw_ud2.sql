-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 03:34 AM
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
-- Database: `ltw_ud2`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `bookName` varchar(255) NOT NULL,
  `subjectId` int(11) DEFAULT NULL,
  `classNumber` int(11) NOT NULL,
  `oldPrice` double DEFAULT 0,
  `currentPrice` double DEFAULT 0,
  `quantitySold` int(11) DEFAULT 0,
  `imageURL` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `description` varchar(3000) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `bookName`, `subjectId`, `classNumber`, `oldPrice`, `currentPrice`, `quantitySold`, `imageURL`, `status`, `description`, `type`) VALUES
(1, 'Toán 6 - Giáo Khoa Cơ Bản', 1, 6, 18000, 16000, 120, 'https://sachhoc.com/image/cache/catalog/LuyenThi/Lop6-9/Sach-giao-khoa-toan-lop-6-tap-1-ket-noi-tri-thuc-voi-cuoc-song-500x554.jpg', 1, 'Toán lớp 6 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
(2, 'Ngữ Văn 6 - Giáo Trình', 2, 6, 20000, 18000, 80, 'https://tailieugiaovien.com.vn/storage/uploads/images/posts/banner/van-6-ct-1684467741.png', 1, 'Giáo trình Ngữ văn lớp 6.', 'Giáo Trình'),
(3, 'Toán 7 - Giáo Khoa Cơ Bản', 1, 7, 19000, 17000, 110, 'https://classbook.vn/static/covers/STK07TCBNC02/cover.clsbi', 1, 'Toán lớp 7 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
(4, 'Ngữ Văn 7 - Bài Tập', 2, 7, 21000, 19000, 85, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqvFq42_zLyEGSnqgSIvQHnedai8cmUFR9DQ&s', 1, 'Bài tập Ngữ văn lớp 7.', 'Bài Tập'),
(5, 'Toán 8 - Giáo Khoa Nâng Cao', 1, 8, 20000, 18000, 95, 'https://down-vn.img.susercontent.com/file/vn-11134208-7qukw-lk1ug2tsdm9u08', 1, 'Toán lớp 8 nâng cao.', 'Giáo Khoa Nâng Cao'),
(6, 'Hóa Học 8 - Bài Tập', 7, 8, 22000, 20000, 70, 'https://bizweb.dktcdn.net/thumb/grande/100/386/441/products/9786040013613-1554883055.jpg?v=1593164899427', 1, 'Bài tập Hóa học lớp 8.', 'Bài Tập'),
(7, 'Toán 9 - Ôn Thi vào 10', 1, 9, 25000, 23000, 150, 'https://sobee.vn/wp-content/uploads/2025/02/Bia-On-thi-vao-10-mon-Toan-1-600x853.jpg', 1, 'Ôn thi Toán lớp 9 vào 10.', 'Ôn Thi'),
(8, 'Ngữ Văn 9 - Ôn Thi vào 10', 2, 9, 24000, 22000, 140, 'https://ebdbook.vn/upload/stk/lop9/ngu-van/lam-chu-kien-thuc-ngu-van-9-luyen-thi-vao-lop-10-phan-1-doc-hieu-van-ban/11-compressed.jpg?v=1.0.1', 1, 'Ôn thi Ngữ văn lớp 9.', 'Ôn Thi'),
(9, 'Tiếng Anh 9 - Ôn Thi', 8, 9, 23000, 21000, 100, 'https://cdn1.fahasa.com/media/flashmagazine/images/page_images/tong_on_tieng_anh_9___tap_1_chuong_trinh_sgk_moi/2024_11_14_16_58_00_1-390x510.jpg', 1, 'Ôn thi tiếng Anh lớp 9.', 'Ôn Thi'),
(10, 'Toán 9 - Giáo Khoa Cơ Bản', 1, 9, 24000, 22000, 90, 'https://img.websosanh.vn/v10/users/review/images/a9cwtpmu6641q/sgk-toan-lop-9-tap-2.jpg?compress=85', 1, 'Toán lớp 9 cơ bản.', 'Giáo Khoa Cơ Bản'),
(11, 'Vật Lý 9 - Giáo Trình', 5, 9, 22500, 20500, 80, 'https://metaisach.com/wp-content/uploads/2019/01/sach-giao-khoa-vat-li-lop-9.jpg', 1, 'Vật lý lớp 9.', 'Giáo Trình'),
(12, 'Ngữ Văn 9 - Bài Tập', 2, 9, 22000, 20000, 95, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoFovmyLGrJTbyg_rv2UsCqcgTPbb4onaOHw&s', 1, 'Bài tập văn học lớp 9.', 'Bài Tập'),
(13, 'Sinh Học 9 - Ôn Thi', 6, 9, 23000, 21500, 65, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTE9q_gBT0Pvuds7_z_s_go_18krS2qah-_4w&s', 1, 'Ôn thi Sinh học lớp 9.', 'Ôn Thi'),
(14, 'Hóa Học 9 - Ôn Thi', 7, 9, 23500, 21500, 60, 'https://down-vn.img.susercontent.com/file/db208c68264f1bd4d60237a97607a091', 1, 'Ôn thi Hóa lớp 9.', 'Ôn Thi'),
(15, 'Toán 10 - Giáo Khoa Cơ Bản', 1, 10, 26000, 24000, 130, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCVeWm0ZmbHqcJ-1E3OCKGYOr5RZapAF_xqA&s', 1, 'Toán lớp 10 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
(16, 'Ngữ Văn 10 - Bài Giảng', 2, 10, 27000, 25000, 95, 'https://bizweb.dktcdn.net/thumb/grande/100/362/945/products/41913655.jpg?v=1568985169303', 1, 'Bài giảng Văn học lớp 10.', 'Bài Giảng'),
(17, 'Toán 11 - Giáo Trình', 1, 11, 28000, 26000, 85, 'https://toanmath.com/wp-content/uploads/2022/12/sach-giao-khoa-toan-11-tap-1-canh-dieu.png', 1, 'Giáo trình Toán lớp 11.', 'Giáo Trình'),
(18, 'Ngữ Văn 11 - Ôn Thi', 2, 11, 28500, 26500, 80, 'https://video.vietjack.com/upload/images/documents/banner/gk1-ctst-1687763095.png', 1, 'Ôn thi Ngữ văn lớp 11.', 'Ôn Thi'),
(19, 'Toán 12 - Ôn Thi THPT', 1, 12, 32000, 30000, 180, 'https://toanmath.com/wp-content/uploads/2025/03/chuyen-de-on-thi-tot-nghiep-thpt-2025-mon-toan-nguyen-tien-ha.png', 1, 'Ôn thi tốt nghiệp môn Toán.', 'Ôn Thi'),
(20, 'Ngữ Văn 12 - Ôn Thi THPT', 2, 12, 31000, 29000, 170, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi tốt nghiệp môn Ngữ văn.', 'Ôn Thi'),
(21, 'Tiếng Anh 12 - Ôn Thi THPT', 8, 12, 30000, 28000, 150, 'https://sachhoc.com/image/cache/catalog/Sachtienganh/Luyen-thi/Lop10-12/12-chuyen-de-on-thi-thpt-quoc-gia-mon-tieng-anh-co-mai-phuong-500x554.jpg', 1, 'Ôn thi tiếng Anh THPT.', 'Ôn Thi'),
(22, 'Toán 12 - Giáo Khoa Cơ Bản', 1, 12, 31000, 29000, 140, 'https://toanmath.com/wp-content/uploads/2016/12/sach-giao-khoa-giai-tich-12-co-ban.png', 1, 'Toán lớp 12 cơ bản.', 'Giáo Khoa Cơ Bản'),
(23, 'Vật Lý 12 - Giáo Trình', 5, 12, 30000, 28000, 130, 'https://thuvienvatly.com/home/images/download_thumb/1dQt09bdxnqCEMpjHYZMfEaghJl8pJOe2.jpg', 1, 'Giáo trình Vật lý lớp 12.', 'Giáo Trình'),
(24, 'Sinh Học 12 - Ôn Thi THPT', 6, 12, 30500, 28500, 115, 'https://sachhoc.com/image/cache/catalog/LuyenThi/Lop10-12/On-tap-mon-sinh-hoc-chuan-bi-cho-ki-thi-thpt-quoc-gia-500x554.jpg', 1, 'Ôn thi Sinh học THPT.', 'Ôn Thi'),
(25, 'Hóa Học 12 - Ôn Thi THPT', 7, 12, 31000, 29000, 120, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcE4fBjAP-DYqMifDj65Bt8SeBvGSRy8RdIA&s', 1, 'Ôn thi Hóa học THPT.', 'Ôn Thi'),
(26, 'Ngữ Văn 12 - Bài Tập', 2, 12, 30000, 28000, 90, 'https://sachcanhdieu.vn/wp-content/uploads/2024/07/Bia-STKTY-Bai-tap-doc-hieu-Ngu-van-12-tap-1.png', 1, 'Bài tập Văn học lớp 12.', 'Bài Tập');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `idCart` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`idCart`, `idUser`, `totalPrice`) VALUES
(1, 1, 46000),
(2, 2, 39000),
(3, 3, 43000);

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `id` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  `cartId` int(11) NOT NULL,
  `amount` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`id`, `bookId`, `cartId`, `amount`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 2, 1),
(4, 4, 2, 1),
(5, 5, 3, 1),
(6, 6, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `idBook` int(11) NOT NULL,
  `idHoadon` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`idBook`, `idHoadon`, `amount`) VALUES
(3, 2, 1),
(4, 2, 1),
(5, 3, 2),
(8, 5, 1),
(9, 6, 3),
(10, 7, 1),
(11, 8, 2),
(12, 9, 1),
(13, 10, 1),
(14, 10, 1),
(15, 11, 1),
(16, 12, 2),
(17, 13, 1),
(18, 14, 2),
(19, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chitietquyen`
--

CREATE TABLE `chitietquyen` (
  `ID_ChiTiet` int(11) NOT NULL,
  `ID_NhomQuyen` int(11) NOT NULL,
  `ID_ChucNang` tinyint(255) NOT NULL,
  `id_quanly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietquyen`
--

INSERT INTO `chitietquyen` (`ID_ChiTiet`, `ID_NhomQuyen`, `ID_ChucNang`, `id_quanly`) VALUES
(16, 1, 1, 1),
(17, 1, 1, 3),
(18, 1, 2, 3),
(19, 1, 4, 3),
(20, 1, 3, 3),
(21, 1, 1, 7),
(22, 1, 2, 7),
(23, 1, 3, 7),
(24, 1, 4, 7),
(25, 1, 1, 2),
(26, 1, 2, 2),
(27, 1, 3, 2),
(28, 1, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chucnangquyen`
--

CREATE TABLE `chucnangquyen` (
  `id` int(10) NOT NULL,
  `chucnang` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chucnangquyen`
--

INSERT INTO `chucnangquyen` (`id`, `chucnang`) VALUES
(1, 'Xem'),
(2, 'Thêm'),
(3, 'Sửa'),
(4, 'Xóa');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `idBill` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `totalBill` double DEFAULT 0,
  `paymentMethod` varchar(250) DEFAULT NULL,
  `statusBill` int(11) DEFAULT 0,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`idBill`, `idUser`, `receiver`, `phoneNumber`, `totalBill`, `paymentMethod`, `statusBill`, `Date`) VALUES
(2, 2, 'Minh Trần', '0911222333', 1200000, 'Chuyển khoản ngân hàng', 1, '2024-11-13'),
(3, 3, 'Thảo Lê', '0911333444', 310000, 'Thanh toán khi nhận hàng', 1, '2024-12-11'),
(5, 5, 'Lan Hồ', '0911555666', 470000, 'Chuyển khoản ngân hàng', 1, '2025-03-11'),
(6, 6, 'Nam Đặng', '0911666777', 2300000, 'Thanh toán khi nhận hàng', 1, '2025-02-11'),
(7, 7, 'Tú Vũ', '0911777888', 180000, 'Thanh toán khi nhận hàng', 1, '2025-03-21'),
(8, 8, 'Quỳnh Anh', '0911888999', 1290000, 'Chuyển khoản ngân hàng', 1, '2025-03-19'),
(9, 9, 'Michael Nguyen', '0911999000', 670000, 'Thanh toán khi nhận hàng', 1, '2024-12-23'),
(10, 10, 'Jessica Trinh', '0912000111', 560000, 'Chuyển khoản ngân hàng', 1, '2025-03-17'),
(11, 11, 'Tommy Le', '0912111222', 985000, 'Thanh toán khi nhận hàng', 1, '2025-01-29'),
(12, 12, 'David Hoang', '0912222333', 310000, 'Thanh toán khi nhận hàng', 0, '2025-04-09'),
(13, 13, 'Emily Dang', '0912333444', 450000, 'Chuyển khoản ngân hàng', 1, '2025-02-10'),
(14, 14, 'Chloe Phan', '0912444555', 2200000, 'Chuyển khoản ngân hàng', 1, '2025-04-09'),
(15, 15, 'Anthony Tran', '0912555666', 890000, 'Thanh toán khi nhận hàng', 1, '2025-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `hoadonxuat`
--

CREATE TABLE `hoadonxuat` (
  `id` int(11) NOT NULL,
  `idBill` int(11) NOT NULL,
  `status` int(11) DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadonxuat`
--

INSERT INTO `hoadonxuat` (`id`, `idBill`, `status`, `create_at`) VALUES
(13, 5, 0, '2025-04-06 14:52:02'),
(14, 2, 0, '2025-04-06 14:52:02'),
(15, 3, 0, '2025-04-06 14:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `imageproduct`
--

CREATE TABLE `imageproduct` (
  `id` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `imageURL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `imageproduct`
--

INSERT INTO `imageproduct` (`id`, `idBook`, `imageURL`) VALUES
(1, 1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(2, 1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(3, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(4, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(5, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(6, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(7, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(8, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(9, 4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(10, 4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(11, 5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(12, 5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(13, 6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(14, 6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(15, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(16, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(17, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(18, 8, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(19, 9, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(20, 10, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(21, 11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(22, 11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(23, 12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(24, 12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(25, 13, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(26, 14, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(27, 15, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(28, 16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(29, 16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(30, 17, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(31, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(32, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(33, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(34, 19, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(35, 20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(36, 20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(37, 21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(38, 21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(39, 22, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(40, 23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(41, 23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(42, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(43, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(44, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(45, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(46, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(47, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(48, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(49, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(50, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(53, 1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(54, 1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(55, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(56, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(57, 2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(58, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(59, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(60, 3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(61, 4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(62, 4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(63, 5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(64, 5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(65, 6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(66, 6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(67, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(68, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(69, 7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(70, 8, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(71, 9, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(72, 10, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(73, 11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(74, 11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(75, 12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(76, 12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(77, 13, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(78, 14, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(79, 15, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(80, 16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(81, 16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(82, 17, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(83, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(84, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(85, 18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(86, 19, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(87, 20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(88, 20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(89, 21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(90, 21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(91, 22, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(92, 23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(93, 23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(94, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(95, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(96, 24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(97, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(98, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(99, 25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(100, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(101, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg'),
(102, 26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `IDNhanVien` int(11) NOT NULL,
  `TenNhanVien` varchar(255) DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `ID_TK` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT './avatar/default-avatar.jpg',
  `status` tinyint(1) NOT NULL DEFAULT 1 CHECK (`status` in (0,1)),
  `MatKhau` varchar(55) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ID_NhomQuyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`IDNhanVien`, `TenNhanVien`, `Mail`, `SDT`, `ID_TK`, `avatar`, `status`, `MatKhau`, `username`, `ID_NhomQuyen`) VALUES
(1, 'Nguyễn Văn An', 'a@example.com', '0912345678', 1, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'nguyenvanan', 1),
(2, 'Trần Thị Bình', 'b@example.com', '0987654321', 2, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'tranthibinh', 2),
(3, 'Lê Văn Cường', 'c@example.com', '0934567890', 3, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'levancuong', 3),
(4, 'Phạm Thị Dung', 'd@example.com', '0978123456', 4, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'phamthidung', 4),
(5, 'Vũ Minh Đức', 'e@example.com', '0901234567', 5, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'vuminhduc', 1),
(6, 'Đặng Thị Phương', 'f@example.com', '0911122233', 6, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'dangthiphuong', 2),
(7, 'Ngô Văn Giang', 'g@example.com', '0966123456', 7, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'ngovangiang', 3),
(8, 'Hoàng Thị Hồng', 'h@example.com', '0922233344', 8, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 0, '123456', 'hoangthihong', 4),
(9, 'Nguyễn Văn Hòa', 'i@example.com', '0907788990', 9, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'nguyenvanhoa', 1),
(10, 'Trần Thị Lan', 'j@example.com', '0933555777', 10, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'tranthilan', 2),
(11, 'Phạm Văn Khánh', 'k@example.com', '0977445566', 11, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 0, '123456', 'phamvankhanh', 3),
(12, 'Lê Thị Lệ', 'l@example.com', '0955112233', 12, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'lethile', 4),
(13, 'Đoàn Văn Minh', 'm@example.com', '0988776655', 13, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'doanvanminh', 1),
(14, 'Bùi Thị Nga', 'n@example.com', '0966332211', 14, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'buithinga', 2),
(15, 'Võ Minh Nhật', 'o@example.com', '0944225566', 15, 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 'vominhnhat', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nhomquyen`
--

CREATE TABLE `nhomquyen` (
  `ID_NhomQuyen` int(11) NOT NULL,
  `TenNhomQuyen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhomquyen`
--

INSERT INTO `nhomquyen` (`ID_NhomQuyen`, `TenNhomQuyen`) VALUES
(1, 'Admin'),
(2, 'Người quản lí'),
(3, 'Nhân viên kho'),
(4, 'Nhân viên bán hàng'),
(5, 'Người mua hàng');

-- --------------------------------------------------------

--
-- Table structure for table `quanlihoadon`
--

CREATE TABLE `quanlihoadon` (
  `idBill` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `IDNhanVien` int(11) NOT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quanlihoadon`
--

INSERT INTO `quanlihoadon` (`idBill`, `create_at`, `IDNhanVien`, `status`) VALUES
(2, '2025-04-06 15:04:37', 8, 0),
(3, '2025-04-06 15:04:37', 12, 0),
(5, '2025-04-06 15:04:37', 8, 0),
(6, '2025-04-06 15:04:37', 12, 0),
(7, '2025-04-06 15:04:37', 4, 0),
(8, '2025-04-06 15:04:37', 8, 0),
(9, '2025-04-06 15:04:38', 12, 0),
(10, '2025-04-06 17:08:31', 4, 3),
(11, '2025-04-06 17:08:31', 8, 3),
(12, '2025-04-06 17:08:31', 12, 2),
(13, '2025-04-06 17:08:31', 4, 3),
(14, '2025-04-06 17:08:31', 8, 2),
(15, '2025-04-06 17:08:31', 12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `quanly`
--

CREATE TABLE `quanly` (
  `id` int(11) NOT NULL,
  `quanly` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quanly`
--

INSERT INTO `quanly` (`id`, `quanly`) VALUES
(1, 'Thống kê'),
(2, 'Quản lý sách'),
(3, 'Quản lí nhân viên'),
(4, 'Quản lí người dùng'),
(5, 'Quản lý nhập hàng'),
(6, 'Quản lý đơn hàng'),
(7, 'Quản lý quyền');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 1,
  `review` varchar(255) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `bookId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statusdelivery`
--

CREATE TABLE `statusdelivery` (
  `id` int(11) NOT NULL,
  `idHoadon` int(11) NOT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subjectName` varchar(100) DEFAULT NULL,
  `subjectImage` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subjectName`) VALUES
(1, 'Toán'),
(2, 'Ngữ Văn'),
(3, 'Lịch Sử'),
(4, 'Địa Lý'),
(5, 'Vật Lý'),
(6, 'Sinh Học'),
(7, 'Hóa Học'),
(8, 'Tiếng Anh');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ID_TK` int(11) NOT NULL,
  `ID_NhomQuyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`ID_TK`, `ID_NhomQuyen`) VALUES
(1, 1),
(11, 1),
(15, 1),
(2, 2),
(3, 2),
(8, 2),
(12, 2),
(4, 3),
(5, 3),
(9, 3),
(13, 3),
(6, 4),
(7, 4),
(10, 4),
(14, 4),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 5),
(26, 5),
(27, 5),
(28, 5),
(29, 5),
(30, 5);

-- --------------------------------------------------------

--
-- Table structure for table `thongtinhoadon`
--

CREATE TABLE `thongtinhoadon` (
  `idHoadon` int(11) NOT NULL,
  `shippingAddress` varchar(250) DEFAULT NULL,
  `orderTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `approvalTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thongtinhoadon`
--

INSERT INTO `thongtinhoadon` (`idHoadon`, `shippingAddress`, `orderTime`, `approvalTime`) VALUES
(2, '45 Trần Phú, Quận 5, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(3, '78 Nguyễn Huệ, Quận 1, TP.HCM', '2025-04-03 04:10:16', NULL),
(5, '32 Nguyễn Thái Học, Quận 3, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(6, '67 CMT8, Quận 10, TP.HCM', '2025-04-03 04:10:16', NULL),
(7, '89 Pasteur, Quận 1, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(8, '56 Hoàng Văn Thụ, Tân Bình, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(9, '11 Tôn Đức Thắng, Quận 1, TP.HCM', '2025-04-03 04:10:16', NULL),
(10, '4 Lý Thường Kiệt, Quận 10, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(11, '220 Hai Bà Trưng, Quận 3, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(12, '88 Nguyễn Tri Phương, Quận 5, TP.HCM', '2025-04-03 04:10:16', NULL),
(13, '33 Điện Biên Phủ, Bình Thạnh, TP.HCM', '2025-04-03 04:10:16', NULL),
(14, '76 Nguyễn Đình Chiểu, Quận 3, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16'),
(15, '90 Trường Chinh, Tân Phú, TP.HCM', '2025-04-03 04:10:16', '2025-04-03 04:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT './avatar/default-avatar.jpg',
  `status_user` int(11) DEFAULT 1,
  `ID_TK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `phoneNumber`, `userName`, `password`, `email`, `avatar`, `status_user`) VALUES
(1, 'Linh Nguyễn', '0911111234', 'linhnguyen', '123456', 'linh@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(2, 'Minh Trần', '0911222333', 'minhtran', '123456', 'minhtran@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(3, 'Thảo Lê', '0911333444', 'thaole', '123456', 'thaole@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(4, 'Huy Phạm', '0911444555', 'huypham', '123456', 'huypham@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(5, 'Lan Hồ', '0911555666', 'lanho', '123456', 'lanho@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(6, 'Nam Đặng', '0911666777', 'namdang', '123456', 'namdang@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(7, 'Tú Vũ', '0911777888', 'tuvu', '123456', 'tuvu@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(8, 'Quỳnh Anh', '0911888999', 'quynhanh', '123456', 'quynhanh@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(9, 'Michael Nguyen', '0911999000', 'michaelng', '123456', 'michael@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(10, 'Jessica Trinh', '0912000111', 'jessicatrinh', '123456', 'jessica@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(11, 'Tommy Le', '0912111222', 'tommyle', '123456', 'tommy@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(12, 'David Hoang', '0912222333', 'davidhoang', '123456', 'david@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(13, 'Emily Dang', '0912333444', 'emilydang', '123456', 'emily@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(14, 'Chloe Phan', '0912444555', 'chloephan', '123456', 'chloe@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1),
(15, 'Anthony Tran', '0912555666', 'anthonytran', '123456', 'anthony@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_subject` (`subjectId`);
ALTER TABLE `books` ADD FULLTEXT KEY `bookName` (`bookName`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idCart`),
  ADD KEY `fk_cart_users` (`idUser`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookId` (`bookId`),
  ADD KEY `cartId` (`cartId`);

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`idBook`,`idHoadon`),
  ADD KEY `idHoadon` (`idHoadon`);

--
-- Indexes for table `chitietquyen`
--
ALTER TABLE `chitietquyen`
  ADD PRIMARY KEY (`ID_ChiTiet`),
  ADD KEY `ID_NhomQuyen` (`ID_NhomQuyen`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`idBill`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `hoadonxuat`
--
ALTER TABLE `hoadonxuat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idBill` (`idBill`);

--
-- Indexes for table `imageproduct`
--
ALTER TABLE `imageproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imageProduct_products` (`idBook`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`IDNhanVien`),
  ADD KEY `ID_TK` (`ID_TK`),
  ADD KEY `fk_nhanvien_nhomquyen` (`ID_NhomQuyen`);

--
-- Indexes for table `nhomquyen`
--
ALTER TABLE `nhomquyen`
  ADD PRIMARY KEY (`ID_NhomQuyen`);

--
-- Indexes for table `quanlihoadon`
--
ALTER TABLE `quanlihoadon`
  ADD PRIMARY KEY (`idBill`),
  ADD KEY `IDNhanVien` (`IDNhanVien`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookId` (`bookId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `statusdelivery`
--
ALTER TABLE `statusdelivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ID_TK`),
  ADD KEY `ID_NhomQuyen` (`ID_NhomQuyen`);

--
-- Indexes for table `thongtinhoadon`
--
ALTER TABLE `thongtinhoadon`
  ADD PRIMARY KEY (`idHoadon`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_TK` (`ID_TK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `idCart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chitietquyen`
--
ALTER TABLE `chitietquyen`
  MODIFY `ID_ChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `idBill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hoadonxuat`
--
ALTER TABLE `hoadonxuat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `imageproduct`
--
ALTER TABLE `imageproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `IDNhanVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nhomquyen`
--
ALTER TABLE `nhomquyen`
  MODIFY `ID_NhomQuyen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quanlihoadon`
--
ALTER TABLE `quanlihoadon`
  MODIFY `idBill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statusdelivery`
--
ALTER TABLE `statusdelivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ID_TK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`cartId`) REFERENCES `cart` (`idCart`) ON DELETE CASCADE;

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`idBook`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`idHoadon`) REFERENCES `hoadon` (`idBill`) ON DELETE CASCADE;

--
-- Constraints for table `chitietquyen`
--
ALTER TABLE `chitietquyen`
  ADD CONSTRAINT `chitietquyen_ibfk_1` FOREIGN KEY (`ID_NhomQuyen`) REFERENCES `nhomquyen` (`ID_NhomQuyen`) ON DELETE CASCADE;

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hoadonxuat`
--
ALTER TABLE `hoadonxuat`
  ADD CONSTRAINT `hoadonxuat_ibfk_1` FOREIGN KEY (`idBill`) REFERENCES `hoadon` (`idBill`);

--
-- Constraints for table `imageproduct`
--
ALTER TABLE `imageproduct`
  ADD CONSTRAINT `fk_imageProduct_products` FOREIGN KEY (`idBook`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `fk_nhanvien_nhomquyen` FOREIGN KEY (`ID_NhomQuyen`) REFERENCES `nhomquyen` (`ID_NhomQuyen`),
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`ID_TK`) REFERENCES `taikhoan` (`ID_TK`) ON DELETE CASCADE;

--
-- Constraints for table `quanlihoadon`
--
ALTER TABLE `quanlihoadon`
  ADD CONSTRAINT `quanlihoadon_ibfk_1` FOREIGN KEY (`IDNhanVien`) REFERENCES `nhanvien` (`IDNhanVien`),
  ADD CONSTRAINT `quanlihoadon_ibfk_2` FOREIGN KEY (`idBill`) REFERENCES `hoadon` (`idBill`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`ID_NhomQuyen`) REFERENCES `nhomquyen` (`ID_NhomQuyen`) ON DELETE CASCADE;

--
-- Constraints for table `thongtinhoadon`
--
ALTER TABLE `thongtinhoadon`
  ADD CONSTRAINT `thongtinhoadon_ibfk_1` FOREIGN KEY (`idHoadon`) REFERENCES `hoadon` (`idBill`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_TK`) REFERENCES `taikhoan` (`ID_TK`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
