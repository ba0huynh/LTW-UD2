<?php 
session_start();

$servername="localhost";
$username="root";
$password="";
$dbname="ltw_ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>lịch sử mua hàng</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body >
<?php include_once "../components/header2.php";
    if(isset($_SESSION["user_id"])){
  echo $_SESSION["user_id"]."day laaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
}else{
  echo "khogn co";
}
?>
<div class="bg-gray-50 p-4">
  <div class="max-w-4xl mx-auto mb-4">
    <div class="flex justify-between border-b">
<a href="/lichsudonhang" class="tab-button px-4 py-2 ">
  Tất cả
</a>

<a href="/lichsudonhang?status=Cho xac nhan" class="tab-button px-4 py-2 ">
  Chờ giao hàng
</a>

<a href="/lichsudonhang?status=Da giao" class="tab-button px-4 py-2 ">
  Hoàn thành
</a>

<a href="/lichsudonhang?status=Da huy" class="tab-button px-4 py-2 ">
  Đã huỷ
</a>

<a href="/lichsudonhang?status=Tra hang" class="tab-button px-4 py-2 ">
  Trả hàng/Hoàn tiền
</a>


    </div>
    <!-- Search bar -->
    <div class="mt-2 bg-gray-100 rounded flex items-center px-4 py-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
      </svg>
      <input type="text" placeholder="Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm" class="w-full bg-gray-100 focus:outline-none text-sm text-gray-700">
    </div>
  </div>
<?php
$query="
select *
from hoadon
where hoadon.idUser=
".$_SESSION["user_id"];
$result=mysqli_query($conn,$query);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
?>
  <!-- Order Card -->
  <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-4 mt-4">
    <div class="bg-gray-50 px-4 py-2 rounded-md shadow-sm text-gray-700 text-lg inline-block mb-2">
      📅 Ngày đặt hàng: <?php echo $row["create_at"] ?> 
    </div>


    <div class="flex justify-between items-center  mb-4">
      <div class="flex items-center gap-3">
        <a href="/" class="border border-gray-300 text-base px-3 py-1 rounded hover:bg-gray-100 inline-block">
          🏪 Xem Shop
        </a>

      </div>

      <div class="flex items-center gap-3">
        <span class="text-green-500 flex items-center gap-1">
          <span class="{{TrangThaiColor}}"><?php echo $row["statusBill"]?></span>

        </span>
        <span class="text-gray-400">|</span>
        <span class="text-yellow-500 font-bold uppercase">HOÀN THÀNH </span>
      </div>
    </div>

    <?php
$query2="
select *
from chitiethoadon,books
where chitiethoadon.idBook=books.id and chitiethoadon.idHoadon=
".$row["idBill"];
$result2=mysqli_query($conn,$query2);
if ($result2->num_rows > 0) {
  while ($row2 = $result->fetch_assoc()) {
?>
      <div class="flex justify-between  pb-4 mb-4 border-t pt-4 mt-4">
        <div class="flex items-start gap-4">
          <img src="{{this.Anh}}" alt="math" class="w-24 h-24 object-cover rounded border">
          <div>
            <h2 class="font-semibold text-gray-700">Tên : <?php echo $row2["bookName"]?></h2>
            <p class="text-red-500 font-semibold mt-2">Giá : <?php echo $row2["currentPrice"]*(1+$row2["profit"]) ?></p>
            <p class="font-semibold mt-2">Số lượng :  <?php echo $row2["amount"]?></p>
          </div>
        </div>

        <div class="flex flex-col items-end justify-between">
          <div>
            <span class="text-lg font-medium text-gray-700">Thành tiền:</span>
            <span class="text-xl font-bold text-red-600 k"><?php echo $row2["amount"]*($row2["currentPrice"]*(1+$row2["profit"]) )?></span>
          </div>
          <div class="flex gap-2 mt-4">
            <form method="POST" action="/cart/addToCart" style="display: inline;">
              <input type="hidden" name="productId" value="{{../IDHoaDonXuat}}">
              <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium ">
                Mua Lại
              </button>
            </form>

            {{#unless ../DaHuy}}
            <form action="/order/huyDonHang" method="POST">
              <input type="hidden"  name="IDHoaDonXuat" value="{{../IDHoaDonXuat}}">

              <button type="submit" class="text-gray-800 border border-gray-300 px-6 py-2 rounded-lg hover:bg-gray-100 transition">
                Hủy
              </button>
            </form>
            {{/unless}}


          </div>
        </div>
      </div>

    <?php }}?>
    <div class="flex flex-col items-start justify-between border-t pt-4 mt-4">
      <div>
        <span class="text-lg font-medium text-gray-700 mr-4">Tổng :</span>
        <span class="text-xl font-bold text-red-600 "><?php echo $row["totalBill"]?></span>
      </div>
    </div>
  </div>
  

<?php }}?>
<?php include_once "../components/footer.php";?>
  <script>
    function formatCurrencyVND(amount) {
      if (typeof amount !== 'number') {
        amount = parseFloat(amount);
      }

      return amount.toLocaleString('vi-VN', {
        maximumFractionDigits: 0
      }) + ' đ';
    }

    document.addEventListener("DOMContentLoaded", function () {
      const tabs = document.querySelectorAll(".tab-button");
      const activeClass = "text-red-500 border-b-2 border-red-500 font-medium";

      tabs.forEach(tab => {
        tab.addEventListener("click", function () {
          tabs.forEach(t => t.classList.remove(...activeClass.split(" ")));
          this.classList.add(...activeClass.split(" "));
        });
      });
    });
  </script>
    </div>


</body>
</html>
