<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../");
    exit();
}


$servername="localhost";
$username="root";
$password="";
$dbname="ltw_ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
<?php

  $user_id=$_SESSION["user_id"];
  $sql = "
  SELECT 
    cart.totalPrice, 
    cartitems.amount, 
    books.currentPrice, 
    books.imageURL, 
    books.bookName
  FROM cart
  JOIN cartitems ON cart.idCart = cartitems.cartId
  JOIN books ON books.id = cartitems.bookId
  WHERE cart.idUser = $user_id AND cartitems.amount > 0
";
?>

<?php
  $sql2 = "SELECT * FROM thongTinGiaoHang where id_user = ".$_SESSION["user_id"];
  $result = $conn->query($sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {},
    }
  }
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }

  .animate-fade-in {
    animation: fadeIn 0.3s ease-out forwards;
  }
</style>

</head>
<body>
<?php include_once "../components/header2.php";?>

<div class="min-h-screen bg-gray-100">
  <div class="max-w-3xl mx-auto">

    <div class="bg-white p-6 border-b border-gray-200">
      <div class="border-t-4 border-dashed border-red-300 rounded-t-xl mb-4"></div>

      <div class="flex items-center gap-2 mb-3 text-red-600 font-semibold text-base">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 0l-4.243 4.243a8 8 0 1011.314 0z" />
        </svg>
        Địa Chỉ Nhận Hàng
      </div>

      <?php 
      $query_delivering = "SELECT * FROM thongTinGiaoHang where id_user=".$_SESSION["user_id"] ." and status=1";//địa chỉ mặc định
      $result = $conn->query($query_delivering);
      echo $query_delivering;
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
      ?>
      <div id="showAddressInfor" class="flex flex-wrap justify-between items-start text-sm text-gray-800 font-medium">
        <div class="flex-1">

          <input type="hidden" name="submitId_Diachi">
          
          <span class="font-bold text-gray-900"><span id="submitName"><?php echo $row["tennguoinhan"]?></span></span> 
          <span class="text-gray-700"> SĐT : <span id="submitSDT"><?php echo $row["sdt"]?></span></span><br>
          <span id="submitDiachi"><?php echo $row["diachi"]?></span>
          ,<span id="submitWard"><?php echo $row["huyen"]?></span> , 
          <span id="submitDistrict"><?php echo $row["quan"]?></span>, 
          <span id="submitCity"><?php echo $row["thanhpho"]?></span>
          <input type="hidden" id="macdinh" value="<?php echo $row["status"]?>">
        </div>

        <div class="flex gap-3 items-center mt-2 sm:mt-0">
          <span class="text-xs border border-red-500 text-red-500 px-2 py-1 rounded">
              Mặc Định
          </span>
          <a onclick="toggleAddressPopup()" class="cursor-pointer text-blue-600 text-sm font-medium hover:underline">Thay Đổi</a>
        </div>
      </div>
      <?php }}else{?>
      <div id="showAddressInfor" class="flex flex-wrap justify-between items-start text-sm text-gray-800 font-medium">
        <a onclick="toggleAddressPopup()" class="text-blue-600 text-sm font-medium hover:underline">Thêm</a>
      </div>
      <?php }?>
    </div>
  </div>


  <form method="POST" >
    <div class="bg-gray-100">

      <div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-md mt-10">

        <!-- PHƯƠNG THỨC THANH TOÁN -->
        <div>
          <h3
            class="text-lg font-semibold border-b pb-2 mb-4 text-gray-800 mt-4"
          >PHƯƠNG THỨC THANH TOÁN</h3>
          <div class="space-y-4">
            <label class="flex items-center space-x-3">
              <input
                type="radio"
                name="payment"
                value="Chuyen khoan"
                class="form-radio h-5 w-5 text-blue-600"
              />
              <span class="flex items-center space-x-2"><img
                  src="https://cdn.tgdd.vn/2020/04/GameApp/image-180x180.png"
                  class="w-6 h-6"
                />
                <span>Ví ZaloPay</span></span>
            </label>
            <label class="flex items-center space-x-3">
              <input
                type="radio"
                name="payment"
                value="Chuyen khoan"
                class="form-radio h-5 w-5 text-blue-600"
              />
              <span class="flex items-center space-x-2"><img
                  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s"
                  class="w-6 h-6"
                />
                <span>VNPAY</span></span>
            </label>

            <label class="flex items-center space-x-3">
              <input
                type="radio"
                name="payment"
                value="Tien mat"
                class="form-radio h-5 w-5 text-blue-600"
                checked
              />
              <span class="flex items-center space-x-2">💵
                <span>Thanh toán bằng tiền mặt khi nhận hàng</span></span>
            </label>
          </div>
        </div>

      </div>
      <div
        class="mb-10 mt-4 max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg p-6 font-sans"
      >
        <h2 class="text-lg font-bold text-gray-800 mb-4 uppercase">Kiểm tra lại
          đơn hàng</h2>
        <?php
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            

        ?>
        <div class="flex items-center justify-between border-t border-gray-200 pt-6 pb-6">
        <!-- Hình ảnh sách -->
          <div class="flex items-start gap-4">
            <div class="w-24 h-24 flex-shrink-0">
              <img
                src="<?php echo $row['imageURL']; ?>"
                alt="Sách"
                class="w-full h-full object-cover rounded shadow"
              />
          </div>

          <!-- Thông tin sách -->
          <div class="flex flex-col justify-center">
            <p class="text-gray-800 font-semibold text-base line-clamp-2 max-w-xs">
              Tên: <?php echo htmlspecialchars($row["bookName"]); ?>
            </p>
            <p class="text-sm text-red-600 font-semibold mt-1">
              Giá: <?php echo number_format($row["currentPrice"], 0, ',', '.'); ?> đ
            </p>
            <p class="text-sm text-gray-600 mt-1">
              Số lượng: <?php echo $row["amount"]; ?>
            </p>
          </div>
        </div>

        <!-- Thành tiền -->
        <div class="text-right">
          <span class="text-sm text-gray-500">Thành tiền : </span>
          <span class="text-red-600 text-lg font-bold">
            <?php echo number_format($row["amount"] * $row["currentPrice"], 0, ',', '.'); ?> đ
          </span>
        </div>
      </div>

        <?php
          }}

        ?>

      </div>

      <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md z-50">
        <div
          class="max-w-6xl mx-auto flex justify-between items-center px-4 py-3"
        >

          <!-- Checkbox và điều khoản -->
          <label class="flex items-center space-x-2 text-sm text-gray-600">
            <input
              type="checkbox"
              class="form-checkbox h-4 w-4 text-red-600"
              checked
            />
            <span>
              Bằng việc tiến hành Mua hàng, Bạn đã đồng ý với
              <a href="#" class="text-blue-600 hover:underline">Điều khoản & Điều
                kiện của shop</a>
            </span>
          </label>

          <!-- Nút thanh toán -->
          <button
            type="button"
            onclick="xacNhanThanhToan()"
            class="flex items-center gap-2 px-7 py-3 bg-gradient-to-r from-pink-500 to-red-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.25 6.75A2.25 2.25 0 014.5 4.5h15a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75zM2.25 9.75h19.5" />
            </svg>
            Xác nhận thanh toán
          </button>


        </div>

      </div>

    </div>

  </form>
</div>

<div id="addressPopup" class="animate-fade-in  fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden transition duration-300 ease-out">
  <div class="  max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-4 font-sans">
    <h2 class="text-lg font-bold text-gray-800 mb-2">Địa Chỉ Của Tôi</h2>
    <?php 
    $query = "SELECT * FROM thongTinGiaoHang where id_user =".$_SESSION["user_id"] ." and status=1";
    $result = $conn->query($query);
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
    ?>
    <div class="parentDiachi flex items-start space-x-3 border-b pb-4">
      <input type="radio" name="diachi" 
      value="<?php echo $row['id'] ?>" 
      class="mt-1 text-red-600" <?php if($row["status"]) echo "checked" ?> />
      
      <div class="flex-1 space-y-1">
        <div class="flex justify-between items-center">
          <span class="showTenNguoiNhan font-semibold text-gray-800">
            <?php echo $row["tennguoinhan"]?>
          </span>
          <a onclick="openEdit(this)" class="text-blue-600 text-sm hover:underline cursor-pointer"
          data-id="<?php echo $row["id_user"]?>"
          data-name="<?php echo $row["tennguoinhan"]?>"
          data-phone="<?php echo $row["sdt"]?>"
          data-address="<?php echo $row["diachi"]?>"
          data-city="<?php echo $row["thanhpho"]?>"
          data-district="<?php echo $row["quan"]?>"
          data-ward="<?php echo $row["huyen"]?>"
          data-status="<?php echo $row["status"]?>"
          >
            Cập nhật
          </a>
        </div>
        <div class="showSDT text-sm text-gray-700">
          SDT : <?php echo $row["sdt"]?>
        </div>
        <div class="text-sm text-gray-600">
          <span><?php echo $row["diachi"]?></span>
        
        <br><?php echo $row["huyen"]?>,<?php echo $row["quan"]?>, TP. <?php echo $row["thanhpho"]?>
        </div>
        <?php if ($row["status"]==1){?>
        <span class="text-xs border border-red-500 text-red-500 px-2 py-1 rounded inline-block mt-1">Mặc định</span>
        <?php }?>
      </div>
    </div>
    <?php }}?>


    <!-- Thêm địa chỉ -->
    <button onclick="toggleAddressForm()" class="flex items-center gap-2 border border-gray-300 text-gray-700 rounded px-4 py-2 mt-2 hover:bg-gray-100 transition">
      <span class="text-xl">＋</span> Thêm Địa Chỉ Mới
    </button>

    <!-- Hủy và Xác nhận -->
    <div class="flex justify-end gap-4 mt-6">
      <button type="button" onclick="toggleAddressPopup()" class="px-5 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Hủy</button>
      <button 
      onclick="showAddressChecked()"
      class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition font-semibold">
        Xác nhận
      </button>
    </div>
  </div>
</div>

<!-- Popup Địa Chỉ Mới -->
<div  id="new-address-form" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden ">
  <div class="bg-white w-full max-w-xl p-6 rounded-xl shadow-lg animate-fade-in space-y-4">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 Địa chỉ mới</h2>

    <!-- Họ tên + SĐT -->
    <div class="grid grid-cols-2 gap-4">
      
      <input type="text" id="tennguoinhan" placeholder="Họ và tên" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
      <input type="text" id="sdt" placeholder="Số điện thoại" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Tỉnh / Quận / Phường -->
    <div class="grid grid-cols-3 gap-4">
      <select name="province" id="province" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500">
        <option value="">Chọn Tỉnh/Thành phố</option>
      </select>
      <select name="district" id="district" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" disabled>
        <option value="">Chọn Quận/Huyện</option>
      </select>
      <select name="ward" id="ward" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" disabled>
        <option value="">Chọn Phường/Xã</option>
      </select>
    </div>


    <!-- Địa chỉ cụ thể -->
    <input type="text" id="diachi" placeholder="Địa chỉ cụ thể" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
    
    <!-- Nút hành động -->
    <div class="flex justify-end gap-3 mt-6">
      <button onclick="toggleBack()" class="px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Trở Lại</button>
      <button onclick="showNewAddress()" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hoàn thành</button>
    </div>
  </div>
</div>

<!-- Popup -->
<div id="updateDiachi" class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50">
  <div class="bg-white max-w-md w-full mx-4 p-6 rounded-2xl shadow-md space-y-4 animate-fade-in relative">
    <h2 class="text-xl font-semibold text-gray-800">Cập nhật địa chỉ</h2>

    <!-- Họ tên và số điện thoại -->
    <div class="grid grid-cols-2 gap-4">
      <!-- Họ và tên -->
      <div class="relative">
      <input type="hidden" id="edit_id" />
        <input type="text" id="edit_name" value=""
              class="peer w-full border border-gray-300 rounded-md pt-5 px-3 pb-2 text-sm text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Họ và tên" />
        <label for="edit_name"
              class="absolute left-3 -top-2.5 bg-white px-1 text-gray-500 text-xs transition-all
                      peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400
                      peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-gray-500">
          Họ và tên
        </label>
      </div>

      <!-- Số điện thoại -->
      <div class="relative">
        <input type="text" id="edit_phone" value=""
              class="peer w-full border border-gray-300 rounded-md pt-5 px-3 pb-2 text-sm text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Số điện thoại" />
        <label for="edit_phone"
              class="absolute left-3 -top-2.5 bg-white px-1 text-gray-500 text-xs transition-all
                      peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400
                      peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-gray-500">
          Số điện thoại
        </label>
      </div>
    </div>


    <div class="grid grid-cols-3 gap-4">
      <input type="hidden" id="edit_city_bk" />
      <input type="hidden" id="edit_district_bk" />
      <input type="hidden" id="edit_ward_bk" />
      <select name="province" id="edit_city" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500">
        <option value="">Chọn Tỉnh/Thành phố</option>
      </select>
      <select name="district" id="edit_district" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" disabled>
        <option value="">Chọn Quận/Huyện</option>
      </select>
      <select name="ward" id="edit_ward" class="px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" disabled>
        <option value="">Chọn Phường/Xã</option>
      </select>
    </div>

    <input type="text" id="edit_address" placeholder="Địa chỉ cụ thể" class="w-full rounded border border-gray-300 text-gray-700 px-6 py-2" value="" />

    <!-- Bản đồ -->
    <div class="w-full h-48 rounded-lg overflow-hidden">
      <iframe
        src="https://www.google.com/maps?q=506%2F49%2F60C%2C%20L%C3%A1c%20Long%20Qu%C3%A2n%2C%20TP.%20HCM&output=embed"
        class="w-full h-full border-0"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>

    <!-- Mặc định -->
    <div class="flex items-center space-x-2">
      <input type="checkbox" id="edit_status" value="" />
      <label for="default" class="text-sm text-gray-700">Đặt làm địa chỉ mặc định</label>
    </div>

    <!-- Nút -->
    <div class="flex justify-between pt-4">
      <button onclick="togglePopup()" class="px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Trở Lại</button>
      <button  class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700"
      onclick="saveAddress()">
        Hoàn thành
      </button>
    </div>
  </div>
</div>
<script>
  const data = {
    "Đà Nẵng": {
      "Quận Liên Chiểu": ["Hòa Khánh Bắc", "Hòa Khánh Nam", "Hòa Minh"],
      "Quận Hải Châu": ["Hải Châu 1", "Hải Châu 2"],
      "Quận Sơn Trà": ["An Hải Đông", "An Hải Tây"]
    },
    "Hà Nội": {
      "Quận Hoàn Kiếm": ["Phường Hàng Bạc", "Phường Hàng Bông"],
      "Quận Đống Đa": ["Phường Khâm Thiên", "Phường Văn Chương"]
    },
    "Hồ Chí Minh": {
      "Quận 1": ["Bến Nghé", "Bến Thành"],
      "Quận 2": ["Thủ Thiêm", "An Khánh"]
    },
    "Đồng Nai": {
      "Biên Hòa": ["An Bình", "Bửu Long"],
      "Long Thành": ["An Phước", "Bình Sơn"]
    },
    "Bình Dương": {
      "Thành phố Thủ Dầu Một": ["Phường Phú Hòa", "Phường Phú Lợi"],
      "Thị xã Dĩ An": ["Phường Bình An", "Phường Bình Thắng"]
    },
    "Long An": {
      "Thành phố Tân An": ["Phường 1", "Phường 2"],
      "Huyện Bến Lức": ["Thị trấn Bến Lức", "Xã Lương Bình"]
    },
    "Tiền Giang": {
      "Thành phố Mỹ Tho": ["Phường 1", "Phường 2"],
      "Huyện Châu Thành": ["Thị trấn Tân Hiệp", "Xã Tân Hương"]
    },
    "Bà Rịa - Vũng Tàu": {
      "Thành phố Vũng Tàu": ["Phường 1", "Phường 2"],
      "Huyện Long Điền": ["Thị trấn Long Điền", "Xã An Ngãi"]
    },
    "Khánh Hòa": {
      "Thành phố Nha Trang": ["Phường Vĩnh Hải", "Phường Vĩnh Nguyên"],
      "Huyện Cam Lâm": ["Thị trấn Cam Đức", "Xã Cam Thành Bắc"]
    },
    "Ninh Thuận": {
      "Thành phố Phan Rang-Tháp Chàm": ["Phường Đô Vinh", "Phường Mỹ Hải"],
      "Huyện Ninh Hải": ["Thị trấn Khánh Hải", "Xã Nhơn Hải"]
    },
    "Ninh Bình": {
      "Thành phố Ninh Bình": ["Phường Đông Thành", "Phường Nam Thành"],
      "Huyện Hoa Lư": ["Thị trấn Thiên Tôn", "Xã Ninh Hải"]
    },
    "Hà Tĩnh": {
      "Thành phố Hà Tĩnh": ["Phường Bắc Hà", "Phường Nam Hà"],
      "Huyện Hương Sơn": ["Thị trấn Phố Châu", "Xã Sơn Tây"]
    },
    "Hà Giang": {
      "Thành phố Hà Giang": ["Phường Trần Phú", "Phường Nguyễn Trãi"],
      "Huyện Đồng Văn": ["Thị trấn Đồng Văn", "Xã Lũng Cú"]
    },
    "Lào Cai": {
      "Thành phố Lào Cai": ["Phường Bắc Cường", "Phường Nam Cường"],
      "Huyện Sa Pa": ["Thị trấn Sa Pa", "Xã Tả Phìn"]
    },
    "Thái Nguyên": {
      "Thành phố Thái Nguyên": ["Phường Hoàng Văn Thụ", "Phường Tân Thịnh"],
      "Huyện Đại Từ": ["Thị trấn Hùng Sơn", "Xã Phú Lạc"]
    },
    "An Giang": {
      "Thành phố An Giang": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bạc Liêu": {
      "Thành phố Bạc Liêu": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bắc Giang": {
      "Thành phố Bắc Giang": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bắc Kạn": {
      "Thành phố Bắc Kạn": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bắc Ninh": {
      "Thành phố Bắc Ninh": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bến Tre": {
      "Thành phố Bến Tre": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bình Định": {
      "Thành phố Bình Định": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bình Phước": {
      "Thành phố Bình Phước": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Bình Thuận": {
      "Thành phố Bình Thuận": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Cà Mau": {
      "Thành phố Cà Mau": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Cao Bằng": {
      "Thành phố Cao Bằng": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Điện Biên": {
      "Thành phố Điện Biên": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Đắk Lắk": {
      "Thành phố Đắk Lắk": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Đắk Nông": {
      "Thành phố Đắk Nông": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Đồng Tháp": {
      "Thành phố Đồng Tháp": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Gia Lai": {
      "Thành phố Gia Lai": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Hà Nam": {
      "Thành phố Hà Nam": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Hải Dương": {
      "Thành phố Hải Dương": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Hòa Bình": {
      "Thành phố Hòa Bình": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Hưng Yên": {
      "Thành phố Hưng Yên": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Kiên Giang": {
      "Thành phố Kiên Giang": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Kon Tum": {
      "Thành phố Kon Tum": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Lai Châu": {
      "Thành phố Lai Châu": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Lâm Đồng": {
      "Thành phố Lâm Đồng": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Lạng Sơn": {
      "Thành phố Lạng Sơn": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Nam Định": {
      "Thành phố Nam Định": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Nghệ An": {
      "Thành phố Nghệ An": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Phú Thọ": {
      "Thành phố Phú Thọ": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Phú Yên": {
      "Thành phố Phú Yên": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Quảng Bình": {
      "Thành phố Quảng Bình": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Quảng Nam": {
      "Thành phố Quảng Nam": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Quảng Ngãi": {
      "Thành phố Quảng Ngãi": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Quảng Trị": {
      "Thành phố Quảng Trị": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Sóc Trăng": {
      "Thành phố Sóc Trăng": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Sơn La": {
      "Thành phố Sơn La": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Tây Ninh": {
      "Thành phố Tây Ninh": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Thái Bình": {
      "Thành phố Thái Bình": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Thanh Hóa": {
      "Thành phố Thanh Hóa": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Trà Vinh": {
      "Thành phố Trà Vinh": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Tuyên Quang": {
      "Thành phố Tuyên Quang": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Vĩnh Long": {
      "Thành phố Vĩnh Long": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Vĩnh Phúc": {
      "Thành phố Vĩnh Phúc": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    },
    "Yên Bái": {
      "Thành phố Yên Bái": ["Phường 1", "Phường 2"],
      "Huyện A": ["Xã A1", "Xã A2"]
    }
  };

  const provinceSelect = document.getElementById("province");
  const districtSelect = document.getElementById("district");
  const wardSelect = document.getElementById("ward");

  // Load tỉnh
  for (let province in data) {
    provinceSelect.innerHTML += `<option value="${province}">${province}</option>`;
  }

  // Khi chọn tỉnh
  provinceSelect.addEventListener("change", function () {
    const province = this.value;
    districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
    wardSelect.disabled = true;

    if (province && data[province]) {
      for (let district in data[province]) {
        districtSelect.innerHTML += `<option value="${district}">${district}</option>`;
      }
      districtSelect.disabled = false;
    } else {
      districtSelect.disabled = true;
    }
  });

  // Khi chọn quận
  districtSelect.addEventListener("change", function () {
    const province = provinceSelect.value;
    const district = this.value;
    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

    if (province && district && data[province][district]) {
      data[province][district].forEach(ward => {
        wardSelect.innerHTML += `<option value="${ward}">${ward}</option>`;
      });
      wardSelect.disabled = false;
    } else {
      wardSelect.disabled = true;
    }
  });
</script>
<script>
  function openEdit(element) {
    const popup = document.getElementById("updateDiachi");
    popup.classList.toggle("hidden");
    document.getElementById("addressPopup").classList.toggle("hidden");
    document.getElementById("new-address-form").classList.add("hidden");

    const id = element.dataset.id;
    const name = element.dataset.name;
    const phone = element.dataset.phone;
    const address = element.dataset.address;
    const city = element.dataset.city;
    const district = element.dataset.district;
    const ward = element.dataset.ward;
    const status = element.dataset.status;


    document.getElementById("edit_id").value = id;
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_phone").value = phone;
    document.getElementById("edit_address").value = address;
    document.getElementById("edit_status").value = status;
    if(status == 1) {
      document.getElementById("edit_status").checked = true;
    } else {
      document.getElementById("edit_status").checked = false;
    }

    document.getElementById("edit_city_bk").value = city;
    document.getElementById("edit_ward_bk").value = ward;
    document.getElementById("edit_district_bk").value = district;

    // Reset dropdowns
    const citySelect = document.getElementById("edit_city");
    const districtSelect = document.getElementById("edit_district");
    const wardSelect = document.getElementById("edit_ward");

    citySelect.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';
    for (let p in data) {
      citySelect.innerHTML += `<option value="${p}">${p}</option>`;
    }

    citySelect.value = city;
    districtSelect.disabled = false;
    districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
    for (let d in data[city]) {
      districtSelect.innerHTML += `<option value="${d}">${d}</option>`;
    }

    districtSelect.value = district;
    wardSelect.disabled = false;
    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
    
    if (data[city] && data[city][district]) {
      data[city][district].forEach(w => {
        wardSelect.innerHTML += `<option value="${w}">${w}</option>`;
      });
      wardSelect.disabled = false;
    } else {
      console.warn("Không tìm thấy dữ liệu phường cho:", city, district);
      wardSelect.disabled = true;
    }


    wardSelect.value = ward;

    popup.classList.remove("hidden");
  }


  function saveAddress() {
    const status = document.getElementById("edit_status").checked ? 1 : 0;
    const id = document.getElementById("edit_id").value;
    const name = document.getElementById("edit_name").value;
    const phone = document.getElementById("edit_phone").value;
    const address = document.getElementById("edit_address").value;
    const city = document.getElementById("edit_city").value || document.getElementById("edit_city_bk").value;
    const district = document.getElementById("edit_district").value || document.getElementById("edit_district_bk").value;
    const ward = document.getElementById("edit_ward").value || document.getElementById("edit_ward_bk").value;

    console.log(id, name, phone, address, city, district,"ward", ward);
    fetch('../controllers/update_dia_chi.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        id,
        name,
        phone,
        address,
        city,
        district,
        ward,
        status
      })
    })
    .then(res => res.json())
    .then(result => {
      if (result.success) {
        alert('Cập nhật thành công!');
        document.getElementById("updateDiachi").classList.add("hidden");
        location.reload(); // hoặc cập nhật giao diện bằng JS
      } else {
        alert('Cập nhật thất bại: ' + result.message);
      }
    })
    .catch(err => {
      alert('Lỗi khi gửi yêu cầu: ' + err);
    });
  }
</script>
<script>
  function togglePopup() {
    const popup = document.getElementById("updateDiachi");
    popup.classList.toggle("hidden");
    document.getElementById("addressPopup").classList.toggle("hidden");
    document.getElementById("new-address-form").classList.add("hidden");
  }
</script>



<script>
// function submitAddress() {
//   const data = {
//     tennguoinhan: document.getElementById("tennguoinhan").value,
//     sdt: document.getElementById("sdt").value,
//     phuong: document.getElementById("ward").value,
//     district: document.getElementById("district").value,
//     thanhpho: document.getElementById("province").value,

//     diachi: document.getElementById("diachi").value,
//     macdinh: document.getElementById("macdinh").checked
//   };

//   fetch("../controllers/them_dia_chi.php", {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/json"
//     },
//     body: JSON.stringify(data)
//   })
//   .then(res => res.json())
//   .then(result => {
//     if (result.success) {
//       alert("Thêm địa chỉ thành công!");
//       toggleBack(); // Ẩn form nếu bạn có hàm này
//     } else {
//       alert("Thêm thất bại: " + result.message);
//     }
//   })
//   .catch(err => {
//     alert("Lỗi kết nối server.");
//     console.error(err);
//   });
// }
</script>


<script>
  function toggleAddressForm() {
    const form = document.getElementById("new-address-form");
    form.classList.toggle("hidden");
    document.getElementById("addressPopup").classList.toggle("hidden");
    document.getElementById("updateDiachi").classList.add("hidden");
  }
</script>
<script>
  function toggleAddressPopup() {
    const popup = document.getElementById("addressPopup");
    popup.classList.toggle("hidden");
  }
</script>
<script>
  function toggleBack() {
    document.getElementById("new-address-form").classList.add("hidden");
    document.getElementById("addressPopup").classList.remove("hidden");
  }
</script>

<script>
// function addNewAddress() {
//   const ten = document.getElementById("tennguoinhan").value.trim();
//   const sdt = document.getElementById("sdt").value.trim();
//   const diachi = document.getElementById("diachi").value.trim();
//   const ward = document.getElementById("ward").value.trim();
//   const district = document.getElementById("district").value.trim();
//   const province = document.getElementById("province").value.trim();

//   if (!ten || !sdt || !diachi || !ward || !district || !province) {
//     alert("Vui lòng nhập đầy đủ thông tin địa chỉ!");
//     return;
//   }

//   const phoneRegex = /^0\d{9}$/;
//   if (!phoneRegex.test(sdt)) {
//     alert("Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng 10 số bắt đầu bằng 0.");
//     return;
//   }


//   const data = {
//     tennguoinhan: ten,
//     sdt,
//     diachi,
//     thanhpho: province,
//     district,
//     ward
//   };

//   fetch("../controllers/them_dia_chi.php", {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/json"
//     },
//     body: JSON.stringify(data)
//   })
//   .then(res => res.json())
//   .then(result => {
//     if (result.success) {
//       alert("Thêm địa chỉ thành công!");
//       location.reload();
//     } else {
//       alert("Thêm thất bại: " + result.message);
//     }
//   })
//   .catch(err => {
//     alert("Lỗi kết nối server.");
//     console.error(err);
//   });
//   document.getElementById("submitName").innerText = ten;
//   document.getElementById("submitSDT").innerText = sdt;
//   document.getElementById("submitDiachi").innerText = diachi;
//   document.getElementById("submitWard").innerText = ward;
//   document.getElementById("submitDistrict").innerText = district;
//   document.getElementById("submitCity").innerText = province;
//   document.getElementById("new-address-form").classList.add("hidden");
// }
function showNewAddress() {
  const ten = document.getElementById("tennguoinhan").value.trim();
  const sdt = document.getElementById("sdt").value.trim();
  const diachi = document.getElementById("diachi").value.trim();
  const ward = document.getElementById("ward").value.trim();
  const district = document.getElementById("district").value.trim();
  const province = document.getElementById("province").value.trim();

  if (!ten || !sdt || !diachi || !ward || !district || !province) {
    alert("Vui lòng nhập đầy đủ thông tin địa chỉ!");
    return;
  }

  const phoneRegex = /^0\d{9}$/;
  if (!phoneRegex.test(sdt)) {
    alert("Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng 10 số bắt đầu bằng 0.");
    return;
  }


  document.getElementById("submitName").innerText = ten;
  document.getElementById("submitSDT").innerText = sdt;
  document.getElementById("submitDiachi").innerText = diachi;
  document.getElementById("submitWard").innerText = ward;
  document.getElementById("submitDistrict").innerText = district;
  document.getElementById("submitCity").innerText = province;
  document.getElementById("new-address-form").classList.add("hidden");
}
</script>




<script>
function showAddressChecked() {
  const selected = document.querySelector('input[name="diachi"]:checked');
  if (!selected) {
    alert("Vui lòng chọn một địa chỉ!");
    return;
  }

  const parent = selected.closest(".parentDiachi");
  const ten = parent.querySelector(".showTenNguoiNhan")?.innerText.trim() || "";
  const sdtFull = parent.querySelector(".showSDT")?.innerText.trim() || "";
  const sdt = sdtFull.replace("SDT : ", "").trim();
  const diachiElement = parent.querySelector(".text-sm.text-gray-600");
  const spans = diachiElement.querySelectorAll("span");
  const diachi = spans[0]?.innerText.trim() || "";

  const addressLine = diachiElement.innerText.split("\n")[1]?.trim();
  const [huyen = "", quan = "", thanhpho = ""] = addressLine?.replace("TP. ", "").split(",") || [];

  document.getElementById("submitName").innerText = ten;
  document.getElementById("submitSDT").innerText = sdt;
  document.getElementById("submitDiachi").innerText = diachi;
  document.getElementById("submitWard").innerText = huyen.trim();
  document.getElementById("submitDistrict").innerText = quan.trim();
  document.getElementById("submitCity").innerText = thanhpho.trim();

  document.getElementById("addressPopup").classList.add("hidden");
}


</script>

<script>
  async function xacNhanThanhToan() {
    const tennguoinhan = document.getElementById("submitName").innerText.trim();
    const sdt = document.getElementById("submitSDT").innerText.trim();
    const selectedPayment = document.querySelector('input[name="payment"]:checked');
    // const diachi = document.getElementById("diachi")?.value;
    const diachi=document.getElementById("submitDiachi").innerText.trim();
    const ward = document.getElementById("submitWard").innerText.trim();
    const district = document.getElementById("submitDistrict").innerText.trim();
    const province = document.getElementById("submitCity").innerText.trim();
    const macdinh = document.getElementById("macdinh").value || 0;
    const selected = document.getElementById("submitId_Diachi").value || 0;

    if (!tennguoinhan || !sdt || !diachi || !ward || !district || !province) {
      alert("Vui lòng nhập địa chỉ giao hàng.");
      return;
    }
    if (!tennguoinhan ) {
      alert("Vui lòng nhập tên người nhân.");
      return;
    }

    let addressId = null;

    // Nếu không chọn địa chỉ cũ → người dùng đang nhập mới
    if (!selected) {
      const newAddress = {
        tennguoinhan,
        sdt,
        phuong: ward,
        district,
        thanhpho: province,
        diachi,
        macdinh
      };

      try {
        const res = await fetch("../controllers/them_dia_chi.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(newAddress)
        });

        const result = await res.json();
        if (!result.success) {
          alert("Không thể thêm địa chỉ mới: " + result.message);
          return;
        }

        addressId = result.address_id;
      } catch (err) {
        alert("Lỗi khi thêm địa chỉ mới.");
        return;
      }

    } else {
      // Nếu người dùng chọn địa chỉ cũ
      addressId = selected.value;
    }

    // Gửi request thanh toán
    const paymentMethod = selectedPayment.value;
    fetch("../controllers/thanhtoan.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `address_id=${addressId}&payment_method=${encodeURIComponent(paymentMethod)}`
    })
    .then(response => response.text())
    .then(data => {
      if (data.includes("Thanh toán thành công")) {
        alert("Thanh toán thành công!");
        window.location.href = "/LTW_UD2/zui/responseOrder.php";
      } else {
        alert("Đã xảy ra lỗi khi thanh toán: " + data);
      }
    })
    .catch(error => {
      console.error("Lỗi khi thanh toán:", error);
      alert("Thanh toán thất bại!");
    });
  }
</script>


</body>



</html>
