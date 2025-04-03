CREATE TABLE `nhomquyen` (
  `ID_NhomQuyen` INT(11) NOT NULL AUTO_INCREMENT,
  `TenNhomQuyen` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_NhomQuyen`)
);
CREATE TABLE `taikhoan` (
    `ID_TK` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_NhomQuyen` INT(11) NOT NULL,
  PRIMARY KEY (`ID_TK`),
  FOREIGN KEY (`ID_NhomQuyen`) REFERENCES `nhomquyen`(`ID_NhomQuyen`) ON DELETE CASCADE
);
CREATE TABLE `nhanvien` (
  `IDNhanVien` INT(11) NOT NULL AUTO_INCREMENT,
  `TenNhanVien` VARCHAR(255),
  `Mail` VARCHAR(255),
  `SDT` VARCHAR(15),
  `ID_TK` int not null,
  `MatKhau` int not null,
  `avatar` VARCHAR(255) DEFAULT './avatar/default-avatar.jpg',
  `status` TINYINT(1) NOT NULL DEFAULT 1 CHECK (`status` IN (0, 1)),
  PRIMARY KEY (`IDNhanVien`),
  FOREIGN KEY (`ID_TK`) REFERENCES `taikhoan`(`ID_TK`) ON DELETE CASCADE
);
alter table `nhanvien` modify column `MatKhau` varchar(55) not null
CREATE TABLE `chitietquyen` (
  `ID_ChiTiet` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_NhomQuyen` INT(11) NOT NULL,
  `ChucNang` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_ChiTiet`),
  FOREIGN KEY (`ID_NhomQuyen`) REFERENCES `nhomquyen`(`ID_NhomQuyen`) ON DELETE CASCADE
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT './avatar/default-avatar.jpg',
  `status` int(11) DEFAULT 1,
  `ID_TK` int not null,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`ID_TK`) REFERENCES `taikhoan`(`ID_TK`) ON DELETE CASCADE
);
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(100) DEFAULT NULL,
  `subjectImage` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookName` varchar(255) NOT NULL,
  `subjectId` int(11) DEFAULT NULL,
  `classNumber` int(11) NOT NULL,
  `oldPrice` double DEFAULT 0,
  `currentPrice` double DEFAULT 0,
  `quantitySold` int(11) DEFAULT 0,
  `imageURL` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `description` varchar(3000) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_books_subject` (`subjectId`),
  FULLTEXT KEY `bookName` (`bookName`)
);
CREATE TABLE `imageproduct` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `idBook` INT(11) NOT NULL,
  `imageURL` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imageProduct_products` (`idBook`),
  CONSTRAINT `fk_imageProduct_products`
    FOREIGN KEY (`idBook`) REFERENCES `books`(`id`) ON DELETE CASCADE
);
CREATE TABLE
  review (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    rating int NOT NULL DEFAULT 1,
    review VARCHAR(255),
    userId int NOT NULL,
    bookId int NOT NULL,
    FOREIGN KEY (bookid) REFERENCES books (id),
    FOREIGN KEY (userId) REFERENCES users (id)
  );
CREATE TABLE `cart` (
  `idCart` INT(11) NOT NULL AUTO_INCREMENT,
  `idUser` INT(11) NOT NULL,
  `totalPrice` INT(11) NOT NULL,
  PRIMARY KEY (`idCart`),
  KEY `fk_cart_users` (`idUser`),
  FOREIGN KEY (`idUser`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE `cartitems` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bookId` INT(11) NOT NULL,
  `cartId` INT(11) NOT NULL,
  `amount` INT(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `bookId` (`bookId`),
  KEY `cartId` (`cartId`),
  FOREIGN KEY (`bookId`) REFERENCES `books`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cartId`) REFERENCES `cart`(`idCart`) ON DELETE CASCADE
);
CREATE TABLE hoadon (
  idBill INT(11) AUTO_INCREMENT PRIMARY KEY,
  idUser INT(11) NOT NULL,
  receiver VARCHAR(100) NOT NULL,
  phoneNumber VARCHAR(11),
  totalBill DOUBLE DEFAULT 0,
  paymentMethod VARCHAR(250),
  statusBill INT(11) DEFAULT 0,         -- 0: chưa duyệt, 1: đã duyệt, v.v.
  statusRemove INT(11) DEFAULT 0,       -- 0: hiển thị, 1: đã xóa mềm
  FOREIGN KEY (idUser) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE thongtinhoadon (
    id int AUTO_INCREMENT not null primary key,
  idHoadon INT NOT NULL,
  shippingAddress VARCHAR(250),
  orderTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  approvalTime TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (idHoadon),
  FOREIGN KEY (idHoadon) REFERENCES hoadon(idBill) ON DELETE CASCADE
);
CREATE TABLE chitiethoadon (
  idBook INT NOT NULL,
  idHoadon INT NOT NULL,
  amount INT NOT NULL,
  PRIMARY KEY (idBook, idHoadon),
  FOREIGN KEY (idBook) REFERENCES books(id) ON DELETE CASCADE,
  FOREIGN KEY (idHoadon) REFERENCES hoadon(idBill) ON DELETE CASCADE
);

ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_subject` FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`);

ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

ALTER TABLE `cartitems`
  ADD CONSTRAINT `fk_cartitems_book` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_cartitems_cart` FOREIGN KEY (`cartId`) REFERENCES `cart` (`idCart`);

ALTER TABLE `imageproduct`
  ADD CONSTRAINT `fk_imageProduct_products` FOREIGN KEY (`idBook`) REFERENCES `books` (`id`);

ALTER TABLE `review`
  ADD CONSTRAINT `fk_review_book` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);


INSERT INTO `books`
(`id`,`bookName`, `subjectId`, `classNumber`, `oldPrice`, `currentPrice`, `quantitySold`, `imageURL`, `status`, `description`, `type`)
VALUES
-- Lớp 6
('Toán 6 - Giáo Khoa Cơ Bản', 1, 6, 18000, 16000, 120, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 6 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
('Ngữ Văn 6 - Giáo Trình', 2, 6, 20000, 18000, 80, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Giáo trình Ngữ văn lớp 6.', 'Giáo Trình'),

-- Lớp 7
('Toán 7 - Giáo Khoa Cơ Bản', 1, 7, 19000, 17000, 110, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 7 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
('Ngữ Văn 7 - Bài Tập', 2, 7, 21000, 19000, 85, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Bài tập Ngữ văn lớp 7.', 'Bài Tập'),

-- Lớp 8
('Toán 8 - Giáo Khoa Nâng Cao', 1, 8, 20000, 18000, 95, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 8 nâng cao.', 'Giáo Khoa Nâng Cao'),
('Hóa Học 8 - Bài Tập', 7, 8, 22000, 20000, 70, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Bài tập Hóa học lớp 8.', 'Bài Tập'),

-- Lớp 9 (tăng số lượng)
('Toán 9 - Ôn Thi vào 10', 1, 9, 25000, 23000, 150, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Toán lớp 9 vào 10.', 'Ôn Thi'),
('Ngữ Văn 9 - Ôn Thi vào 10', 2, 9, 24000, 22000, 140, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Ngữ văn lớp 9.', 'Ôn Thi'),
('Tiếng Anh 9 - Ôn Thi', 8, 9, 23000, 21000, 100, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi tiếng Anh lớp 9.', 'Ôn Thi'),
('Toán 9 - Giáo Khoa Cơ Bản', 1, 9, 24000, 22000, 90, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 9 cơ bản.', 'Giáo Khoa Cơ Bản'),
('Vật Lý 9 - Giáo Trình', 5, 9, 22500, 20500, 80, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Vật lý lớp 9.', 'Giáo Trình'),
('Ngữ Văn 9 - Bài Tập', 2, 9, 22000, 20000, 95, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Bài tập văn học lớp 9.', 'Bài Tập'),
('Sinh Học 9 - Ôn Thi', 6, 9, 23000, 21500, 65, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Sinh học lớp 9.', 'Ôn Thi'),
('Hóa Học 9 - Ôn Thi', 7, 9, 23500, 21500, 60, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Hóa lớp 9.', 'Ôn Thi'),

-- Lớp 10
('Toán 10 - Giáo Khoa Cơ Bản', 1, 10, 26000, 24000, 130, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 10 bản cơ bản.', 'Giáo Khoa Cơ Bản'),
('Ngữ Văn 10 - Bài Giảng', 2, 10, 27000, 25000, 95, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Bài giảng Văn học lớp 10.', 'Bài Giảng'),

-- Lớp 11
('Toán 11 - Giáo Trình', 1, 11, 28000, 26000, 85, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Giáo trình Toán lớp 11.', 'Giáo Trình'),
('Ngữ Văn 11 - Ôn Thi', 2, 11, 28500, 26500, 80, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Ngữ văn lớp 11.', 'Ôn Thi'),

-- Lớp 12 (tăng số lượng)
('Toán 12 - Ôn Thi THPT', 1, 12, 32000, 30000, 180, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi tốt nghiệp môn Toán.', 'Ôn Thi'),
('Ngữ Văn 12 - Ôn Thi THPT', 2, 12, 31000, 29000, 170, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi tốt nghiệp môn Ngữ văn.', 'Ôn Thi'),
('Tiếng Anh 12 - Ôn Thi THPT', 8, 12, 30000, 28000, 150, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi tiếng Anh THPT.', 'Ôn Thi'),
('Toán 12 - Giáo Khoa Cơ Bản', 1, 12, 31000, 29000, 140, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Toán lớp 12 cơ bản.', 'Giáo Khoa Cơ Bản'),
('Vật Lý 12 - Giáo Trình', 5, 12, 30000, 28000, 130, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Giáo trình Vật lý lớp 12.', 'Giáo Trình'),
('Sinh Học 12 - Ôn Thi THPT', 6, 12, 30500, 28500, 115, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Sinh học THPT.', 'Ôn Thi'),
('Hóa Học 12 - Ôn Thi THPT', 7, 12, 31000, 29000, 120, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Ôn thi Hóa học THPT.', 'Ôn Thi'),
('Ngữ Văn 12 - Bài Tập', 2, 12, 30000, 28000, 90, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg', 1, 'Bài tập Văn học lớp 12.', 'Bài Tập');



INSERT INTO imageproduct (idBook, imageURL) VALUES (1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (1, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (2, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (3, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (4, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (5, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (6, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (7, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (8, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (9, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (10, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (11, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (12, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (13, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (14, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (15, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (16, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (17, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (18, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (19, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (20, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (21, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (22, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (23, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (24, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (25, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (26, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (27, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (27, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (27, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (28, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (28, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (28, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (29, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (29, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (29, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (30, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (30, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');
INSERT INTO imageproduct (idBook, imageURL) VALUES (30, 'https://hieusach24h.com/wp-content/uploads/2021/09/Toan-5-1.jpg');



INSERT INTO `subjects` (`id`, `subjectName`, `subjectImage`) VALUES
(1, 'Toán', NULL),
(2, 'Ngữ Văn', NULL),
(3, 'Lịch Sử', NULL),
(4, 'Địa Lý', NULL),
(5, 'Vật Lý', NULL),
(6, 'Sinh Học', NULL),
(7, 'Hóa Học', NULL),
(8, 'Tiếng Anh', NULL);


INSERT INTO `nhomquyen` (`ID_NhomQuyen`, `TenNhomQuyen`) VALUES
(1, 'Admin'),
(2, 'Người quản lí'),
(3, 'Nhân viên kho'),
(4, 'Nhân viên bán hàng'),
(5, 'Người mua hàng');


-- Admin (ID_NhomQuyen = 1)
INSERT INTO `chitietquyen` (`ID_NhomQuyen`, `ChucNang`) VALUES
(1, 'Quản lí khách hàng'),
(1, 'Quản lí nhân viên'),
(1, 'Thống kê');

-- Manager (ID_NhomQuyen = 2) – có tất cả các quyền
INSERT INTO `chitietquyen` (`ID_NhomQuyen`, `ChucNang`) VALUES
(2, 'Quản lí khách hàng'),
(2, 'Quản lí nhân viên'),
(2, 'Thống kê'),
(2, 'Quản lí sản phẩm'),
(2, 'Nhập hàng'),
(2, 'Quản lí danh mục'),
(2, 'Quản lí đơn hàng');

-- Nhân viên kho (ID_NhomQuyen = 3)
INSERT INTO `chitietquyen` (`ID_NhomQuyen`, `ChucNang`) VALUES
(3, 'Quản lí sản phẩm'),
(3, 'Nhập hàng'),
(3, 'Quản lí danh mục');

-- Nhân viên bán hàng (ID_NhomQuyen = 4)
INSERT INTO `chitietquyen` (`ID_NhomQuyen`, `ChucNang`) VALUES
(4, 'Quản lí khách hàng'),
(4, 'Quản lí đơn hàng');


INSERT INTO `taikhoan` (`ID_TK`, `ID_NhomQuyen`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 3),
(6, 4),
(7, 4),
(8, 2),
(9, 3),
(10, 4),
(11, 1),
(12, 2),
(13, 3),
(14, 4),
(15, 1);

INSERT INTO `taikhoan` (`ID_TK`, `ID_NhomQuyen`) VALUES
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

INSERT INTO `nhanvien` (`TenNhanVien`, `username`, `Mail`, `SDT`, `avatar`, `status`, `MatKhau`, `ID_TK`) VALUES
('Nguyễn Văn An', 'nguyenvanan', 'a@example.com', '0912345678', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 1),
('Trần Thị Bình', 'tranthibinh', 'b@example.com', '0987654321', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 2),
('Lê Văn Cường', 'levancuong', 'c@example.com', '0934567890', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 3),
('Phạm Thị Dung', 'phamthidung', 'd@example.com', '0978123456', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 4),
('Vũ Minh Đức', 'vuminhduc', 'e@example.com', '0901234567', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 5),
('Đặng Thị Phương', 'dangthiphuong', 'f@example.com', '0911122233', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 6),
('Ngô Văn Giang', 'ngovangiang', 'g@example.com', '0966123456', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 7),
('Hoàng Thị Hồng', 'hoangthihong', 'h@example.com', '0922233344', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 0, '123456', 8),
('Nguyễn Văn Hòa', 'nguyenvanhoa', 'i@example.com', '0907788990', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 9),
('Trần Thị Lan', 'tranthilan', 'j@example.com', '0933555777', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 10),
('Phạm Văn Khánh', 'phamvankhanh', 'k@example.com', '0977445566', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 0, '123456', 11),
('Lê Thị Lệ', 'lethile', 'l@example.com', '0955112233', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 12),
('Đoàn Văn Minh', 'doanvanminh', 'm@example.com', '0988776655', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 13),
('Bùi Thị Nga', 'buithinga', 'n@example.com', '0966332211', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 14),
('Võ Minh Nhật', 'vominhnhat', 'o@example.com', '0944225566', 'https://images.icon-icons.com/1378/PNG/512/avatardefault_92824.png', 1, '123456', 15);








INSERT INTO `users`
(`id`, `fullName`, `phoneNumber`, `userName`, `password`, `email`, `avatar`, `status`, `ID_TK`) VALUES
(1, 'Linh Nguyễn', '0911111234', 'linhnguyen', '123456', 'linh@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 16),
(2, 'Minh Trần', '0911222333', 'minhtran', '123456', 'minhtran@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 17),
(3, 'Thảo Lê', '0911333444', 'thaole', '123456', 'thaole@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 18),
(4, 'Huy Phạm', '0911444555', 'huypham', '123456', 'huypham@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 19),
(5, 'Lan Hồ', '0911555666', 'lanho', '123456', 'lanho@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 20),
(6, 'Nam Đặng', '0911666777', 'namdang', '123456', 'namdang@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 21),
(7, 'Tú Vũ', '0911777888', 'tuvu', '123456', 'tuvu@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 22),
(8, 'Quỳnh Anh', '0911888999', 'quynhanh', '123456', 'quynhanh@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 23),
(9, 'Michael Nguyen', '0911999000', 'michaelng', '123456', 'michael@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 24),
(10, 'Jessica Trinh', '0912000111', 'jessicatrinh', '123456', 'jessica@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 25),
(11, 'Tommy Le', '0912111222', 'tommyle', '123456', 'tommy@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 26),
(12, 'David Hoang', '0912222333', 'davidhoang', '123456', 'david@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 27),
(13, 'Emily Dang', '0912333444', 'emilydang', '123456', 'emily@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 28),
(14, 'Chloe Phan', '0912444555', 'chloephan', '123456', 'chloe@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 29),
(15, 'Anthony Tran', '0912555666', 'anthonytran', '123456', 'anthony@gmail.com', 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png', 1, 30);

-- Bảng giỏ hàng

INSERT INTO `cart` (`idUser`, `totalPrice`) VALUES
(1, 46000), -- Linh Nguyễn
(2, 39000), -- Minh Trần
(3, 43000); -- Thảo Lê

-- Bảng chi tiết sản phẩm trong giỏ hàng

-- Linh Nguyễn (cartId = 1)
INSERT INTO `cartitems` (`bookId`, `cartId`, `amount`) VALUES
(1, 1, 1),  -- Toán 6 - 16000
(2, 1, 1);  -- Ngữ Văn 6 - 18000 → Tổng 34000

-- Minh Trần (cartId = 2)
INSERT INTO `cartitems` (`bookId`, `cartId`, `amount`) VALUES
(3, 2, 1),  -- Toán 7 - 17000
(4, 2, 1);  -- Ngữ Văn 7 - 19000 → Tổng 36000

-- Thảo Lê (cartId = 3)
INSERT INTO `cartitems` (`bookId`, `cartId`, `amount`) VALUES
(5, 3, 1),  -- Toán 8 - 18000
(6, 3, 1);  -- Hóa Học 8 - 20000 → Tổng 38000



INSERT INTO hoadon 
(idUser, receiver, phoneNumber, totalBill, paymentMethod, statusBill, statusRemove)
VALUES
(1, 'Linh Nguyễn', '0911111234', 950000, 'Thanh toán khi nhận hàng', 0, 0),
(2, 'Minh Trần', '0911222333', 1200000, 'Chuyển khoản ngân hàng', 1, 0),
(3, 'Thảo Lê', '0911333444', 310000, 'Thanh toán khi nhận hàng', 0, 0),
(4, 'Huy Phạm', '0911444555', 845000, 'Thanh toán khi nhận hàng', 1, 0),
(5, 'Lan Hồ', '0911555666', 470000, 'Chuyển khoản ngân hàng', 1, 0),
(6, 'Nam Đặng', '0911666777', 2300000, 'Thanh toán khi nhận hàng', 0, 0),
(7, 'Tú Vũ', '0911777888', 180000, 'Thanh toán khi nhận hàng', 1, 0),
(8, 'Quỳnh Anh', '0911888999', 1290000, 'Chuyển khoản ngân hàng', 1, 0),
(9, 'Michael Nguyen', '0911999000', 670000, 'Thanh toán khi nhận hàng', 0, 0),
(10, 'Jessica Trinh', '0912000111', 560000, 'Chuyển khoản ngân hàng', 1, 0),
(11, 'Tommy Le', '0912111222', 985000, 'Thanh toán khi nhận hàng', 1, 0),
(12, 'David Hoang', '0912222333', 310000, 'Thanh toán khi nhận hàng', 0, 0),
(13, 'Emily Dang', '0912333444', 450000, 'Chuyển khoản ngân hàng', 0, 0),
(14, 'Chloe Phan', '0912444555', 2200000, 'Chuyển khoản ngân hàng', 1, 0),
(15, 'Anthony Tran', '0912555666', 890000, 'Thanh toán khi nhận hàng', 1, 0);

-- Bảng thông tin hóa đơn

INSERT INTO thongtinhoadon (idHoadon, shippingAddress, orderTime, approvalTime)
VALUES
(1, '123 Lê Lợi, Quận 1, TP.HCM', NOW(), NULL),
(2, '45 Trần Phú, Quận 5, TP.HCM', NOW(), NOW()),
(3, '78 Nguyễn Huệ, Quận 1, TP.HCM', NOW(), NULL),
(4, '9B Lý Tự Trọng, Quận 1, TP.HCM', NOW(), NOW()),
(5, '32 Nguyễn Thái Học, Quận 3, TP.HCM', NOW(), NOW()),
(6, '67 CMT8, Quận 10, TP.HCM', NOW(), NULL),
(7, '89 Pasteur, Quận 1, TP.HCM', NOW(), NOW()),
(8, '56 Hoàng Văn Thụ, Tân Bình, TP.HCM', NOW(), NOW()),
(9, '11 Tôn Đức Thắng, Quận 1, TP.HCM', NOW(), NULL),
(10, '4 Lý Thường Kiệt, Quận 10, TP.HCM', NOW(), NOW()),
(11, '220 Hai Bà Trưng, Quận 3, TP.HCM', NOW(), NOW()),
(12, '88 Nguyễn Tri Phương, Quận 5, TP.HCM', NOW(), NULL),
(13, '33 Điện Biên Phủ, Bình Thạnh, TP.HCM', NOW(), NULL),
(14, '76 Nguyễn Đình Chiểu, Quận 3, TP.HCM', NOW(), NOW()),
(15, '90 Trường Chinh, Tân Phú, TP.HCM', NOW(), NOW());

-- Bảng chi tiết hóa đơn

INSERT INTO chitiethoadon (idBook, idHoadon, amount) VALUES
(1, 1, 1),
(2, 1, 2),

(3, 2, 1),
(4, 2, 1),

(5, 3, 2),

(6, 4, 1),
(7, 4, 1),

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


