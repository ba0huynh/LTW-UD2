SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- ----------------------------------------------------------------

--
-- Table structure for table book
--

CREATE TABLE books (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  bookName varchar(255) NOT NULL,
  subjectId int DEFAULT NULL,

  class int NOT NULL,
  oldPrice double DEFAULT '0',
  currentPrice double DEFAULT '0',
  quantitySold int DEFAULT '0',

  createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) 

--
-- Dumping data for table book
--

INSERT INTO books (id, bookName,subjectId, class, oldPrice, currentPrice, quantitySold, createAt, updateAt) VALUES
(1, 'Sách giáo khoa tiếng việt lớp 1 tập 1' ,1, 1, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(2, 'Sách giáo khoa đại số lớp 10 tập 2' ,2, 10, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(3, 'Sách giáo khoa cơ sở Python lớp 8 tập 1' ,6, 8, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(4, 'Sách giáo khoa Vật lý lớp 6 tập 1' ,7, 6, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(5, 'Sách giáo khoa Tiếng anh lớp 9 tập 2' ,10, 9, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(6, 'Sách bài tập hình học lớp 11 tập 1' ,11, 2, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(7, 'Sách giảng viên sinh học lớp 7' ,8, 7, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(8, 'Sách thực hành hóa học lớp 12 tập 1' ,5, 12, 2936498480, 230000000, 0,  '2025-02-26 14:09:11', '2025-02-26 14:09:11');

-- --------------------------------------------------------




--
-- Table structure for table users
--

CREATE TABLE users (
  id int NOT NULL,
  roleId int DEFAULT '1',
  fullName varchar(100) DEFAULT NULL,
  phoneNumber varchar(11) DEFAULT NULL,
  userName varchar(100) DEFAULT NULL,
  password varchar(100) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  avatar varchar(100) DEFAULT './avatar/default-avatar.jpg',
  status int DEFAULT '1',
)

--
-- Dumping data for table users
--

INSERT INTO users (id, roleId, fullName, phoneNumber, userName, password, email, avatar, status, ) VALUES
(1, 2, 'admin', '0123456789', 'admin','12345','huynh8a0k5@gmail.com',NULL,1),
(2, 2, 'Huỳnh Tấn Bảo', '0912345678', 'baohuynh','12345','captianbao@gmail.com',NULL,1 );

-- --------------------------------------------------------------------------


--
-- Table structure for table subjects
--

CREATE TABLE subjects (
    id INT NOT NULL,
    subjectName VARCHAR(100) DEFAULT NULL,
    subjectImage VARCHAR(200) DEFAULT NULL,
    PRIMARY KEY (id)
);


--
-- Dumping data for table subjects
--

INSERT INTO subjects (id, subjectName, subjectImage) VALUES
(1, 'Tiếng Việt', './image/logo/adidas.webp'),
(2, 'Toán', './image/logo/jordan.png'),
(3, 'Địa lý', './image/logo/nike.webp'),
(4, 'Lịch sử', './image/logo/converse.webp'),
(5, 'Hóa học', './image/logo/puma.webp'),
(6, 'Tin học', './image/logo/puma.webp'),
(7, 'Vật lý', './image/logo/puma.webp'),
(8, 'Sinh học', './image/logo/puma.webp'),
(9, 'Ngữ văn', './image/logo/puma.webp'),
(10, 'Anh văn', './image/logo/puma.webp');

-- --------------------------------------------------------


--
-- Table structure for table cartItems
--

CREATE TABLE cartitems (
    id INT NOT NULL PRIMARY KEY,
    bookid INT NOT NULL,
    userid INT NOT NULL,
    amount INT DEFAULT 1,
    FOREIGN KEY (bookid) REFERENCES books(id)
);



CREATE TABLE billdetail (
  idBill int DEFAULT NULL,
  idProduct int DEFAULT NULL,
  size int DEFAULT NULL,
  quantity int DEFAULT NULL,
  total int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table bills
--

CREATE TABLE bills (
  idBill int NOT NULL,
  idUser int DEFAULT NULL,
  receiver varchar(100) DEFAULT NULL,
  shippingAddress varchar(250) DEFAULT NULL,
  phoneNumber varchar(11) DEFAULT NULL,
  totalBill double DEFAULT NULL,
  paymentMethod varchar(250) DEFAULT NULL,
  statusBill int DEFAULT '1',
  statusRemove int DEFAULT '0',
  orderTime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  approvalTime timestamp NULL DEFAULT NULL,
  deliveryTime timestamp NULL DEFAULT NULL,
  completionTime timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table cartdetail
--

CREATE TABLE cartdetail (
  idCart int DEFAULT NULL,
  idProduct int DEFAULT NULL,
  size double DEFAULT NULL,
  quantity int DEFAULT NULL,
  totalProduct double DEFAULT NULL,
  createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers cartdetail
--
-- DELIMITER $$
CREATE TRIGGER updateQuantityProduct AFTER UPDATE ON cartdetail FOR EACH ROW BEGIN if (NEW.QUANTITY != OLD.QUANTITY) THEN
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
-- Table structure for table carts
--

CREATE TABLE carts (
  idCart int NOT NULL,
  idUser int DEFAULT NULL,
  quantityProduct int DEFAULT '0',
  total double DEFAULT '0',
  createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table carts
--

INSERT INTO carts (idCart, idUser, quantityProduct, total, createAt, updateAt) VALUES
(1, 1, 0, 0, '2025-02-26 14:09:11', '2025-02-26 14:09:11'),
(2, 2, 0, 0, '2025-02-26 14:09:51', '2025-02-26 14:09:51');

-- --------------------------------------------------------

--
-- Table structure for table evaluation
--

CREATE TABLE evaluation (
  idEvaluation int NOT NULL,
  idBill int DEFAULT NULL,
  idProduct int DEFAULT NULL,
  content varchar(250) DEFAULT NULL,
  rating int DEFAULT NULL,
  createAtEvaluation timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table imageproducts
--

CREATE TABLE imageproducts (
  idImage int NOT NULL,
  idProduct int DEFAULT NULL,
  image varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table imageproducts
--

-- --------------------------------------------------------

--
-- Table structure for table permissiongroups
--

CREATE TABLE permissiongroups (
  idPermission int NOT NULL,
  permissionName varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table permissiongroups
--

INSERT INTO permissiongroups (idPermission, permissionName) VALUES
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
-- Table structure for table receiptdetail
--

CREATE TABLE receiptdetail (
  idReceipt int DEFAULT NULL,
  idSupplier int DEFAULT NULL,
  idProduct int DEFAULT NULL,
  size int DEFAULT NULL,
  quantity int DEFAULT NULL,
  pucharsePrice int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table receiptdetail
--



-- --------------------------------------------------------

--
-- Table structure for table receipts
--

CREATE TABLE receipts (
  idReceipt int NOT NULL,
  idUser int DEFAULT NULL,
  staff varchar(100) DEFAULT NULL,
  totalReceipt double DEFAULT NULL,
  statusRemove int DEFAULT '0',
  createTime timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table receipts
--


-- --------------------------------------------------------

--
-- Table structure for table roledetail
--

CREATE TABLE roledetail (
  idRole int DEFAULT NULL,
  idPermission int DEFAULT NULL,
  idTask int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table roledetail
--


-- --------------------------------------------------------

--
-- Table structure for table roles
--

CREATE TABLE roles (
  idRole int NOT NULL,
  roleName varchar(100) DEFAULT NULL,
  createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table roles
--


-- --------------------------------------------------------

--
-- Table structure for table sizeproducts
--

CREATE TABLE sizeproducts (
  idProduct int DEFAULT NULL,
  size double DEFAULT NULL,
  statusSize int DEFAULT '1',
  quantityRemain int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- --------------------------------------------------------

--
-- Table structure for table subsubjects
--

CREATE TABLE subsubjects (
  idsubject int DEFAULT NULL,
  subsubjectName varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table subsubjects
--

INSERT INTO subsubjects (idsubject, subsubjectName) VALUES
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
-- Table structure for table supplierdetail
--

CREATE TABLE supplierdetail (
  idSupplier int DEFAULT NULL,
  idProduct int DEFAULT NULL,
  price int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table tasks
--

CREATE TABLE tasks (
  idTask int NOT NULL,
  taskName varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table tasks
--

INSERT INTO tasks (idTask, taskName) VALUES
(1, 'thêm'),
(2, 'xoá'),
(3, 'sửa'),
(4, 'xem');

--
-- Triggers users
--
DELIMITER $$
CREATE TRIGGER createCart AFTER INSERT ON users FOR EACH ROW BEGIN
INSERT INTO CARTS (IDUSER)
VALUES (NEW.IDUSER);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table usershippingaddress
--

CREATE TABLE usershippingaddress (
  idAddress int NOT NULL,
  idUser int DEFAULT NULL,
  name varchar(100) DEFAULT NULL,
  phoneNumber varchar(11) DEFAULT NULL,
  address varchar(250) DEFAULT NULL,
  status int DEFAULT '0',
  createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table billdetail
--
ALTER TABLE billdetail
  ADD KEY idBill (idBill),
  ADD KEY idProduct (idProduct);

--
-- Indexes for table bills
--
ALTER TABLE bills
  ADD PRIMARY KEY (idBill),
  ADD KEY idUser (idUser);

--
-- Indexes for table subjects
--
ALTER TABLE subjects
  ADD PRIMARY KEY (idsubject);

--
-- Indexes for table cartdetail
--
ALTER TABLE cartdetail
  ADD KEY idCart (idCart),
  ADD KEY idProduct (idProduct);

--
-- Indexes for table carts
--
ALTER TABLE carts
  ADD PRIMARY KEY (idCart),
  ADD KEY idUser (idUser);

--
-- Indexes for table evaluation
--
ALTER TABLE evaluation
  ADD PRIMARY KEY (idEvaluation),
  ADD KEY idBill (idBill),
  ADD KEY idProduct (idProduct);

--
-- Indexes for table imageproducts
--
ALTER TABLE imageproducts
  ADD PRIMARY KEY (idImage),
  ADD KEY idProduct (idProduct);

--
-- Indexes for table permissiongroups
--
ALTER TABLE permissiongroups
  ADD PRIMARY KEY (idPermission);

--
-- Indexes for table products
--
ALTER TABLE products
  ADD PRIMARY KEY (idProduct),
  ADD KEY idsubject (idsubject);

--
-- Indexes for table receipts
--
ALTER TABLE receipts
  ADD PRIMARY KEY (idReceipt),
  ADD KEY idUser (idUser);

--
-- Indexes for table roledetail
--
ALTER TABLE roledetail
  ADD KEY idRole (idRole),
  ADD KEY idPermission (idPermission),
  ADD KEY idTask (idTask);

--
-- Indexes for table roles
--
ALTER TABLE roles
  ADD PRIMARY KEY (idRole);

--
-- Indexes for table sizeproducts
--
ALTER TABLE sizeproducts
  ADD KEY idProduct (idProduct);

--
-- Indexes for table subsubjects
--
ALTER TABLE subsubjects
  ADD KEY idsubject (idsubject);

--
-- Indexes for table supplierdetail
--
ALTER TABLE supplierdetail
  ADD KEY idSupplier (idSupplier),
  ADD KEY idProduct (idProduct);

--
-- Indexes for table suppliers
--
ALTER TABLE suppliers
  ADD PRIMARY KEY (idSupplier);

--
-- Indexes for table tasks
--
ALTER TABLE tasks
  ADD PRIMARY KEY (idTask);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (idUser),
  ADD KEY idRole (idRole);

--
-- Indexes for table usershippingaddress
--
ALTER TABLE usershippingaddress
  ADD PRIMARY KEY (idAddress),
  ADD KEY idUser (idUser);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table bills
--
ALTER TABLE bills
  MODIFY idBill int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table subjects
--
ALTER TABLE subjects
  MODIFY idsubject int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table carts
--
ALTER TABLE carts
  MODIFY idCart int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table evaluation
--
ALTER TABLE evaluation
  MODIFY idEvaluation int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table imageproducts
--
ALTER TABLE imageproducts
  MODIFY idImage int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table permissiongroups
--
ALTER TABLE permissiongroups
  MODIFY idPermission int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table products
--
ALTER TABLE products
  MODIFY idProduct int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table receipts
--
ALTER TABLE receipts
  MODIFY idReceipt int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table roles
--
ALTER TABLE roles
  MODIFY idRole int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table suppliers
--
ALTER TABLE suppliers
  MODIFY idSupplier int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table tasks
--
ALTER TABLE tasks
  MODIFY idTask int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users
  MODIFY idUser int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table usershippingaddress
--
ALTER TABLE usershippingaddress
  MODIFY idAddress int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table billdetail
--
ALTER TABLE billdetail
  ADD CONSTRAINT billdetail_ibfk_1 FOREIGN KEY (idBill) REFERENCES bills (idBill),
  ADD CONSTRAINT billdetail_ibfk_2 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table bills
--
ALTER TABLE bills
  ADD CONSTRAINT bills_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser);

--
-- Constraints for table cartdetail
--
ALTER TABLE cartdetail
  ADD CONSTRAINT cartdetail_ibfk_1 FOREIGN KEY (idCart) REFERENCES carts (idCart),
  ADD CONSTRAINT cartdetail_ibfk_2 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table carts
--
ALTER TABLE carts
  ADD CONSTRAINT carts_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser);

--
-- Constraints for table evaluation
--
ALTER TABLE evaluation
  ADD CONSTRAINT evaluation_ibfk_1 FOREIGN KEY (idBill) REFERENCES bills (idBill),
  ADD CONSTRAINT evaluation_ibfk_2 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table imageproducts
--
ALTER TABLE imageproducts
  ADD CONSTRAINT imageproducts_ibfk_1 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table products
--
ALTER TABLE products
  ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (idsubject) REFERENCES subjects (idsubject);

--
-- Constraints for table receipts
--
ALTER TABLE receipts
  ADD CONSTRAINT receipts_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser);

--
-- Constraints for table roledetail
--
ALTER TABLE roledetail
  ADD CONSTRAINT roledetail_ibfk_1 FOREIGN KEY (idRole) REFERENCES roles (idRole),
  ADD CONSTRAINT roledetail_ibfk_2 FOREIGN KEY (idPermission) REFERENCES permissiongroups (idPermission),
  ADD CONSTRAINT roledetail_ibfk_3 FOREIGN KEY (idTask) REFERENCES tasks (idTask);

--
-- Constraints for table sizeproducts
--
ALTER TABLE sizeproducts
  ADD CONSTRAINT sizeproducts_ibfk_1 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table subsubjects
--
ALTER TABLE subsubjects
  ADD CONSTRAINT subsubjects_ibfk_1 FOREIGN KEY (idsubject) REFERENCES subjects (idsubject);

--
-- Constraints for table supplierdetail
--
ALTER TABLE supplierdetail
  ADD CONSTRAINT supplierdetail_ibfk_1 FOREIGN KEY (idSupplier) REFERENCES suppliers (idSupplier),
  ADD CONSTRAINT supplierdetail_ibfk_2 FOREIGN KEY (idProduct) REFERENCES products (idProduct);

--
-- Constraints for table users
--
ALTER TABLE users
  ADD CONSTRAINT users_ibfk_1 FOREIGN KEY (idRole) REFERENCES roles (idRole);

--
-- Constraints for table usershippingaddress
--
ALTER TABLE usershippingaddress
  ADD CONSTRAINT usershippingaddress_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser);
COMMIT;

