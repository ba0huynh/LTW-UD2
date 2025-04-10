<?php
session_start();
include_once("../database/database.php");
include_once("../database/book.php");
include_once("../database/cartItems.php");


$servername = "localhost";
$username = "root";
$password = "";

$dbname = "ltw_ud2";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$cartItemsTables = new CartItemsTable();
$bookTable = new BooksTable();
$user = null;
$userId = null;
// $cartItems = null;


$cartItems = [
  [
    'id' => 1,
    'bookId' => 1,
    'cartId' => 1,
    'name' => 'Sách tiếng Anh lớp 4 tập 1',
    'image' => 'https://phuongnam.edu.vn/storage/media/bia-sach/202306/1f14b7c9-5e35-4c50-bc96-5aa3cf29feab.jpg',
    'price' => 224000,
    'original_price' => 250000,
    'amount' => 1
  ],
  [
    'id' => 2,
    'bookId' => 2,
    'cartId' => 1,
    'name' => 'Sách tiếng Việt lớp 3 tập 2',
    'image' => 'https://salt.tikicdn.com/cache/w1200/media/catalog/producttmp/73/6a/92/e1d4722f73c36ff77c9f81b197.jpg',
    'price' => 180000,
    'original_price' => 200000,
    'amount' => 2
  ],
  [
    'id' => 3,
    'bookId' => 3,
    'cartId' => 2,
    'name' => 'Sách toán nâng cao lớp 5',
    'image' => 'https://salt.tikicdn.com/cache/w1200/media/catalog/producttmp/09/5d/20/b6d60c240845aaf17038fd4fd2.jpg',
    'price' => 150000,
    'original_price' => 165000,
    'amount' => 1
  ]
];


// Assign the session userId to $userId
if (isset($_SESSION["userId"]) && $_SESSION["userId"] != null) {
  $userId = $_SESSION["userId"]; // Assign the session userId here

  if ($userId == null) { // This condition will no longer always be true
    header("Location: http://localhost/LTW-UD2/");
    unset($_SESSION["userId"]);
    exit();
  }
  $cartItems = $cartItemsTables->getAllItemsFromUserId($userId);

  $user = $userTable->getUserDetailsById($userId);
} else {
  // header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../TailWind.css">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>

<body>

  <?php include_once "../zui/header2.php" ?>

  <div class="bg-[#fff1f2] gap-6 flex flex-col p-[7%] items-center">
    <section class="bg-white w-full flex flex-col items-center rounded-lg gap-3 p-10">
      <img src="../images/empty-cart.png" class="w-[20%]" alt="">
      <p>Chưa có sản phẩm trong giỏ hàng của bạn.</p>
      <a href="../index.php">

        <button class="flex-1 bg-red-500 text-white py-2 px-4 font-semibold rounded-lg">
          MUA SẮM NGAY
        </button>
      </a>
    </section>
    <?php if ($user == null): ?>

      <section class="w-full gap-4 flex flex-row">
        <section class="flex-3 bg-white rounded-lg p-4">

          <div class="flex items-center mb-4">
            <div class="flex-10 checkbox-wrapper-13">
              <input
                type="checkbox"


                class="mr-2"
                id="select-all" />
              <label htmlFor="select-all">Chọn tất cả (1 sản phẩm)</label>
            </div>
            <div class="flex-3">Số lượng</div>
            <div class="flex-3">Thành tiền</div>
            <div class="flex-1"></div>
          </div>

          <div class="flex flex-col gap-4">


            <?php

            function renderCartItems($cartItems)
            {
              $bookTable = new BooksTable();


              foreach ($cartItems as $item) {
                $book = $bookTable->getBookById($item['bookId']);
                $id = htmlspecialchars($item['id']);
                $name = htmlspecialchars($book['bookName']);
                $image = htmlspecialchars($book['imageURL']);
                $price = number_format($book['currentPrice'] * $item['amount'], 0, ',', '.') . ' đ';
                $originalPrice = number_format($book['oldPrice'] * $item['amount'], 0, ',', '.') . ' đ';
                $quantity = intval($item['amount']);
                $total = number_format($item['price'] * $quantity, 0, ',', '.') . ' đ';

                echo '
    <div class="flex flex-row gap-3">
    <div class="flex-10 flex flex-row gap-3">
    
    <input
    type="checkbox" 
    class="mr-2"
    id="select-all" />
    
    <img src=' . $image . ' class="w-[100px] object-cover h-[120px]" alt="">
    <div class="flex flex-col items-start justify-center gap-8">
    <p>' . $name . '</p>
    <div class="flex flex-row gap-2 items-center">
    <p class="font-semibold text-lg">' . $price . '</p>
    <p class=" text-md text-gray-400 line-through">' . $originalPrice . '</p>
    </div>
    </div>
    </div>
    <div class="flex flex-3 flex-row items-center gap-2">
    <button class="cursor-pointer text-2xl hover:ml-[-2px] hover:text-4xl duration-300 mt-[-2px] hover:mt-[-4px]">-</button>
    <p>' . $quantity . '</p>
    <button class="cursor-pointer hover:text-2xl hover:mr-[-2px] duration-300 ">+</button>
    </div>
    <div class="flex-3 text-xl font-bold text-[#FB2C36] items-center flex">
    224.000 đ
    </div>
    <div class="flex-1 flex items-center justify-center cursor-pointer">
    <img src="https://www.iconpacks.net/icons/1/free-trash-icon-347-thumb.png" class="w-[24px] hover:scale-130 duration-300" alt="">
    </div>
    </div>
    ';
              }
            }
            if ($cartItems != null) {
              # code...
              renderCartItems($cartItems);
            }

            ?>
          </div>




          <!-- <div class="flex flex-row gap-3">
            <div class="flex-10 flex flex-row gap-3">

              <input
                type="checkbox"
                class="mr-2"
                id="select-all" />

              <img src="https://phuongnam.edu.vn/storage/media/bia-sach/202306/1f14b7c9-5e35-4c50-bc96-5aa3cf29feab.jpg" class="w-[100px] h-[150px]" alt="">
              <div class="flex flex-col items-start justify-center gap-8">
                <p>sách tiếng anh lớp 4 tập 1</p>
                <div class="flex flex-row gap-2 items-center">
                  <p class="font-semibold text-lg">224.000 đ</p>
                  <p class=" text-md text-gray-400 line-through">250.000 đ</p>
                </div>
              </div>
            </div>
            <div class="flex flex-3 flex-row items-center gap-2">
              <button class="cursor-pointer">-</button>
              <p>1</p>
              <button class="cursor-pointer">+</button>
            </div>
            <div class="flex-3 text-xl font-bold text-[#FB2C36] items-center flex">
              224.000 đ
            </div>
            <div class="flex-1 flex items-center justify-center cursor-pointer">
              <img src="https://www.iconpacks.net/icons/1/free-trash-icon-347-thumb.png" class="w-[30px]" alt="">
            </div>
          </div> -->
        </section>
        <section class="flex-2 bg-white rounded-lg p-4">

          <div class="p-4 mb-4">
            <div class="flex justify-between mb-2">
              <div>Thành tiền</div>
              <div>0₫</div>
            </div>
            <div class="flex justify-between font-bold">
              <div>Tổng Số Tiền (gồm VAT)</div>
              <div class="text-[red] font-bold text-2xl">0₫</div>

            </div>
          </div>

          <div class="p-4 mb-4">
            <div class="mb-4">
              <label for="name" class="block text-gray-700 font-bold mb-2">Họ và tên:</label>
              <input type="text" id="name" name="name" class="w-full border rounded-lg p-2" placeholder="Nhập họ và tên của bạn">
              <div id="name-error" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-4">
              <label for="address" class="block text-gray-700 font-bold mb-2">Địa chỉ:</label>
              <input type="text" id="address" name="address" class="w-full border rounded-lg p-2" placeholder="Nhập địa chỉ của bạn">
              <div id="address-error" class="text-red-500 text-sm mt-2"></div>
            </div>
            <div class="mb-4">
              <label for="phone" class="block text-gray-700 font-bold mb-2">Số điện thoại:</label>
              <input type="text" id="phone" name="phone" class="w-full border rounded-lg p-2" placeholder="Nhập số điện thoại của bạn">
              <div id="phone-error" class="text-red-500 text-sm mt-2"></div>
            </div>
          </div>
          <button class="thanhtoanbutton w-full bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-4 rounded">
            THANH TOÁN
          </button>
          <div id="error-message" class="text-red-500 text-sm mt-2"></div>
        </section>
      <?php endif; ?>
      </sec>
  </div>
</body>

<script type="module" src="./index.js"></script>

</html>