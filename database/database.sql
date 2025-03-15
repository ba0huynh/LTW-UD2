DATABASENAME = ltw&ud2

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

-- -------------------------------------------------
CREATE TABLE
  books (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    bookName varchar(255) NOT NULL,
    subjectId int DEFAULT NULL,
    class int NOT NULL,
    oldPrice double DEFAULT '0',
    currentPrice double DEFAULT '0',
    quantitySold int DEFAULT '0',
    imageURL varchar(255) NOT NULL
  );
INSERT INTO
  books (
    bookName,
    subjectId,
    class,
    oldPrice,
    currentPrice,
    quantitySold,
    imageURL
  )
VALUES
  (
    'Sách giáo khoa tiếng việt lớp 1 tập 1',
    1,
    1,
    2936498480,
    230000000,
    0,
    "https://book.sachgiai.com/uploads/book/sach-giao-khoa-tieng-viet-1-tap-1/tieng-viet-1-tap-1-0.jpg"
  ),
  (
    'Sách giáo khoa đại số lớp 10 tập 2',
    2,
    10,
    2936498480,
    230000000,
    0,
    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRa9aLYWedvl6MYJ9sG4aeQ8UsIXUOBmx5FHA&s"
  ),
  (
    'Sách giáo khoa cơ sở Python lớp 8 tập 1',
    6,
    8,
    2936498480,
    230000000,
    0,
    "https://online.pubhtml5.com/gswf/peds/files/large/1.jpg"
  ),
  (
    'Sách giáo khoa Vật lý lớp 6 tập 1',
    7,
    6,
    2936498480,
    230000000,
    0,
    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiGEtA_z-fIFkaZTLARTAmNx2V4cpm3phwQw&s"
  ),
  (
    'Sách giáo khoa Tiếng anh lớp 9 tập 2',
    10,
    9,
    2936498480,
    230000000,
    0,
    "https://metaisach.com/wp-content/uploads/2019/01/sach-giao-khoa-vat-li-lop-6.jpg"
  ),
  (
    'Sách bài tập hình học lớp 11 tập 1',
    11,
    2,
    2936498480,
    230000000,
    0,
    "https://toanmath.com/wp-content/uploads/2016/12/sach-bai-tap-hinh-hoc-11-co-ban.png"
  ),
  (
    'Sách giảng viên sinh học lớp 7',
    8,
    7,
    2936498480,
    230000000,
    0,
    "https://www.vietjack.com/sach-moi/images/sgv-khoa-hoc-tu-nhien-lop-7-chan-troi-sang-tao-1.PNG"
  ),
  (
    'Sách thực hành hóa học lớp 12 tập 1',
    5,
    12,
    2936498480,
    230000000,
    0,
    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiwlUBv6ZvjJixEEiWlX8QX-4LY88_iGwOew&s"
  );

-- -------------------------------------------------
CREATE TABLE
  users (
    id int NOT NULL AUTO_INCREMENT,
    roleId int DEFAULT '1',
    fullName varchar(100) DEFAULT NULL,
    phoneNumber varchar(11) DEFAULT NULL,
    userName varchar(100) DEFAULT NULL,
    password varchar(100) DEFAULT NULL,
    email varchar(100) DEFAULT NULL,
    avatar varchar(100) DEFAULT './avatar/default-avatar.jpg',
    status int DEFAULT '1',
  )
INSERT INTO
  users (
    roleId,
    fullName,
    phoneNumber,
    userName,
    password,
    email,
    avatar,
    status,
  )
VALUES
  (
    2,
    'admin',
    '0123456789',
    'admin',
    '12345',
    'huynh8a0k5@gmail.com',
    NULL,
    1
  ),
  (
    2,
    'Huỳnh Tấn Bảo',
    '0912345678',
    'baohuynh',
    '12345',
    'captianbao@gmail.com',
    NULL,
    1
  );

-- -------------------------------------------------
CREATE TABLE
  review (
    id PRIMARY KEY AUTO_INCREMENT NOT NULL,
    rating int NOT NULL DEFAULT 1,
    review VARCHAR(255),
    userId NOT NULL,
    bookId NOT NULL,
    FOREIGN KEY (bookid) REFERENCES books (id),
    FOREIGN KEY (userId) REFERENCES users (id)
  )
  -- -------------------------------------------------
CREATE TABLE
  subjects (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subjectName VARCHAR(100) DEFAULT NULL,
    subjectImage VARCHAR(200) DEFAULT NULL
  );

INSERT INTO
  subjects (id, subjectName, subjectImage)
VALUES
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

CREATE TABLE
  cartitems (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bookId INT NOT NULL,
    userId INT NOT NULL,
    amount INT DEFAULT 1,
    FOREIGN KEY (bookid) REFERENCES books (id)
  );

CREATE TABLE
  billdetail (
    idBill int DEFAULT NULL,
    idProduct int DEFAULT NULL,
    size int DEFAULT NULL,
    quantity int DEFAULT NULL,
    total int DEFAULT NULL
  )
CREATE TABLE
  bills (
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

CREATE TABLE
  cartdetail (
    idCart int DEFAULT NULL,
    idProduct int DEFAULT NULL,
    size double DEFAULT NULL,
    quantity int DEFAULT NULL,
    totalProduct double DEFAULT NULL,
    createAt timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updateAt timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

CREATE TABLE
  imageproducts (
    idImage int NOT NULL,
    idProduct int DEFAULT NULL,
    image varchar(200) DEFAULT NULL
  )
CREATE TABLE
  roles (
    idRole int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    roleName varchar(100) DEFAULT NULL,
  )
INSERT INTO
  roles (roleName)
VALUES
  ('customer'),
  ('admin');

CREATE TABLE
  usershippingaddress (
    id int NOT NULL,
    userId int DEFAULT NULL,
    phoneNumber varchar(11) DEFAULT NULL,
    address varchar(250) DEFAULT NULL,
    status int DEFAULT '0',
  )