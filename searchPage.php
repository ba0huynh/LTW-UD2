<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Math Books UI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./css/login.css">
<link rel="stylesheet" href="./css/header.css">
</head>
<?php 

require_once("./database/database.php");

$servername="localhost";
$username="root";
$password="";
//$dbname="ltw&ud2";
$dbname="ltd2&ud2";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<body class="bg-gray-100 text-gray-800">
    <?php
    include './zui/header2.php'
    ?>
  <div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-12 gap-6">
      <!-- Sidebar -->
      <aside class="col-span-3 bg-white rounded-2xl shadow p-4">
        <h2 class="text-xl font-semibold mb-4">LỌC THEO</h2>

        <!-- Danh mục chính -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2">MÔN HỌC : <input type="text" value="toán"></h3>
          <h3 class="font-semibold mb-2">THỂ LOẠI : <input type="text" value="bài tập"></h3>
          <div class="accent-blue-500">
          Sách Tiếng Việt (206)
          </div>

        </div>

        <!-- Giá -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2">GIÁ</h3>
          <div class="space-y-1">
            <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">0đ - 150,000đ (187)</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">150,000đ - 300,000đ (11)</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">300,000đ - 500,000đ (7)</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">500,000đ - 700,000đ (1)</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">700,000đ Trở Lên</label>
          </div>
          <div class="mt-4">
            <input type="number" placeholder="0" class="w-1/2 border rounded p-1 text-sm"> - 
            <input type="number" placeholder="0" class="w-1/2 border rounded p-1 text-sm">
          </div>
        </div>

        <!-- Lứa tuổi -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2">LỨA TUỔI</h3>
          <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500"><input type="text" value="6"> - <input type="text" value="9"> </label>
          <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-500">nhập lớp : <input type="text" value="12"></label>
        </div>
        <button type="submit" class="bg-[#D10024] px-4 text-white m-2 rounded" >search</button>

        <!-- Nhà phát hành -->

      </aside>

      <!-- Main Content -->
      <main class="col-span-9">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">KẾT QUẢ TÌM KIẾM: <span class="text-blue-500">sách toán (206 kết quả)</span></h2>
          <div class="flex gap-2">
            <select class="border rounded p-1 text-sm">
              <option>Sắp xếp theo</option>
              <option>Giá tăng dần</option>
              <option>Giá giảm dần</option>
            </select>
            <select class="border rounded p-1 text-sm">
              <option>Độ liên quan</option>
            </select>
            <select class="border rounded p-1 text-sm">
              <option>Còn hàng</option>
            </select>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-4 gap-4">
          <!-- Product Card -->
          <div class="bg-white rounded-2xl shadow p-2">
            <img src="https://via.placeholder.com/150x200" alt="Book" class="rounded-xl mx-auto mb-2">
            <h3 class="text-sm font-semibold mb-1">Giải Sách Bài Tập Toán 9 - Tập 1</h3>
            <div class="text-red-600 font-semibold">37.700 đ <span class="text-xs text-gray-500 line-through">58.000 đ</span></div>
          </div>

          <!-- Repeat Product Cards as needed -->
        </div>
      </main>
    </div>
  </div>
</body>
</html>
