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
if(isset($_SESSION["user_id"])){
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
  $sql2 = "SELECT * FROM thongTinGiaoHang where id_user".$_SESSION["user_id"];
  $result = $conn->query($sql);


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
      $sql2 = "SELECT * FROM thongTinGiaoHang where id_user".$_SESSION["user_id"] ."and status=1";
      $result = $conn->query($sql);
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
      ?>
      <div class="flex flex-wrap justify-between items-start text-sm text-gray-800 font-medium">
        <div class="flex-1">
          <span class="font-bold text-gray-900"><?php echo $row["tennguoinhan"]?></span> 
          <span class="text-gray-700"><?php echo $row["sdt"]?></span><br>
          <?php echo $row["diachi"]?>, <?php //echo $row["duong"]?>
          ,Phường <?php //echo $row["phuong"]?>,Quận <?php echo $row["quan"]?>, <?php //echo $row["thanhpho"]?>
        </div>

        <div class="flex gap-3 items-center mt-2 sm:mt-0">
          <span class="text-xs border border-red-500 text-red-500 px-2 py-1 rounded">Mặc Định</span>
          <a href="#" onclick="toggleAddressPopup()" class="text-blue-600 text-sm font-medium hover:underline">Thay Đổi</a>
        </div>
      </div>
      <?php }}else{?>
      <div class="flex flex-wrap justify-between items-start text-sm text-gray-800 font-medium">
        <a href="#" onclick="toggleAddressPopup()" class="text-blue-600 text-sm font-medium hover:underline">Thêm</a>
      </div>
      <?php }?>
    </div>
  </div>

  <form method="POST" action="/cart/confirm">
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
        }
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
            type="submit"
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

<div id="addressPopup" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden transition duration-300 ease-out">
  <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-4 font-sans">
    <h2 class="text-lg font-bold text-gray-800 mb-2">Địa Chỉ Của Tôi</h2>
    <?php 
    $sql2 = "SELECT * FROM thongTinGiaoHang where id_user".$_SESSION["user_id"] ."and status=1";
    $result = $conn->query($sql);
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
    ?>
    <div class="flex items-start space-x-3 border-b pb-4">
      <input type="radio" name="diachi" value="<?php echo $row['id'] ?>" class="mt-1 text-red-600" <?php if($row["status"]) echo "checked" ?> />
      <div class="flex-1 space-y-1">
        <div class="flex justify-between items-center">
          <span class="font-semibold text-gray-800"><?php echo $row["tennguoinhan"]?></span>
          <a href="#" class="text-blue-600 text-sm hover:underline">Cập nhật</a>
        </div>
        <div class="text-sm text-gray-700"><?php echo $row["sdt"]?></div>
        <div class="text-sm text-gray-600">
        <?php echo $row["diachi"]?>, <?php echo $row["duong"]?>
        <br>Phường <?php echo $row["phuong"]?>, Quận <?php echo $row["quan"]?>, TP. <?php echo $row["thanhpho"]?>
        </div>
        <?php if ($row["status=1"]){?>
        <span class="text-xs border border-red-500 text-red-500 px-2 py-1 rounded inline-block mt-1">Mặc định</span>
        <?php }?>
      </div>
    </div>
    <?}}?>



    <!-- Thêm địa chỉ -->
    <button onclick="toggleAddressForm()" class="flex items-center gap-2 border border-gray-300 text-gray-700 rounded px-4 py-2 mt-2 hover:bg-gray-100 transition">
      <span class="text-xl">＋</span> Thêm Địa Chỉ Mới
    </button>

    <!-- Hủy và Xác nhận -->
    <div class="flex justify-end gap-4 mt-6">
      <button type="button" onclick="toggleAddressPopup()" class="px-5 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Hủy</button>
      <button onclick="toggleAddressPopup()" type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition font-semibold">Xác nhận</button>
    </div>
  </div>
</div>

<!-- Popup Địa Chỉ Mới -->
<div  id="new-address-form" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden ">
  <div class="bg-white w-full max-w-xl p-6 rounded-xl shadow-lg animate-fade-in space-y-4">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 Địa chỉ mới</h2>

    <!-- Họ tên + SĐT -->
    <div class="grid grid-cols-2 gap-4">
      <input type="text" id="tennguoinhan" name="tennguoinhan" placeholder="Họ và tên" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
      <input type="text" id="sdt" name="sdt" placeholder="Số điện thoại" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
    </div>


    <input 
      id="phuong" 
      list="phuong" 
      placeholder="Tỉnh/Phường" 
      class="w-full px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" 
    />
    <datalist id="wards">
      <option value="Phường 1">
      <option value="Phường 2">
      <option value="Phường 3">
      <option value="Phường 4">
      <option value="Phường 5">
    </datalist>

    <input 
      id="quan" 
      list="districts" 
      placeholder="Quận/Huyện" 
      class="w-full px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500" 
    />
    <datalist id="districts">
      <option value="Quận 1">
      <option value="Quận 2">
      <option value="Quận 3">
      <option value="Quận 4">
      <option value="Quận 5">
      <option value="Quận 6">
      <option value="Quận 7">
      <option value="Quận 8">
      <option value="Quận 9">
      <option value="Quận 10">
      <option value="Quận 11">
      <option value="Quận 12">
      <option value="Quận Bình Thạnh">
      <option value="Quận Phú Nhuận">
      <option value="Quận Gò Vấp">
      <option value="Quận Bình Tân">
      <option value="Quận Tân Phú">
      <option value="Quận Tân Bình">
    </datalist>

    <select name="thanhpho" id="thanhpho" class="w-full px-4 py-2 border rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500">
      <option>Hồ Chí Minh</option>
    </select>

    <!-- Địa chỉ cụ thể -->
    <input name="diachi" id="diachi" type="text" placeholder="Địa chỉ cụ thể" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />

    <!-- Thêm vị trí -->
    <button disabled class="flex items-center justify-center gap-2 w-full border rounded-md py-2 text-gray-400 bg-gray-50">
      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Thêm vị trí
    </button>

    <!-- Loại địa chỉ -->
    <div>
      <p class="text-sm text-gray-600 mb-2">Loại địa chỉ:</p>
      <div class="flex gap-4">
        <button type="button" class="px-4 py-2 border rounded-md text-gray-700 hover:border-blue-500 hover:text-blue-600">Nhà Riêng</button>
        <button type="button" class="px-4 py-2 border rounded-md text-gray-700 hover:border-blue-500 hover:text-blue-600">Văn Phòng</button>
      </div>
    </div>

    <!-- Checkbox mặc định -->
    <label class="flex items-center gap-2 mt-2 text-sm text-gray-600">
      <input type="checkbox" id="macdinh" class="accent-red-500" />
      Đặt làm địa chỉ mặc định
    </label>

    <!-- Nút hành động -->
    <div class="flex justify-end gap-3 mt-6">
      <button onclick="toggleNewAddress()" class="px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Trở Lại</button>
      <button onclick="submitAddress()" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hoàn thành</button>
    </div>
  </div>
</div>
<script>
function submitAddress() {
  const data = {
    tennguoinhan: document.getElementById("tennguoinhan").value,
    sdt: document.getElementById("sdt").value,
    phuong: document.getElementById("phuong").value,
    district: document.getElementById("quan").value,
    thanhpho: document.getElementById("thanhpho").value,
    diachi: document.getElementById("diachi").value,
    macdinh: document.getElementById("macdinh").checked
  };

  fetch("../controller/sthem_dia_chi.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(result => {
    if (result.success) {
      alert("Thêm địa chỉ thành công!");
      toggleNewAddress(); // Ẩn form nếu bạn có hàm này
    } else {
      alert("Thêm thất bại: " + result.message);
    }
  })
  .catch(err => {
    alert("Lỗi kết nối server.");
    console.error(err);
  });
}
</script>


<script>
  function toggleAddressForm() {
    const form = document.getElementById("new-address-form");
    form.classList.toggle("hidden");
  }
</script>
<script>
  function toggleAddressPopup() {
    const popup = document.getElementById("addressPopup");
    popup.classList.toggle("hidden");
  }
</script>
<script>
  function toggleNewAddress() {
    document.getElementById("new-address-form").classList.add("hidden");
    document.getElementById("addressPopup").classList.remove("hidden");
  }
</script>
<script>
  function xacNhanThanhToan() {
    const selected = document.querySelector('input[name="diachi"]:checked');
    const selectedPayment = document.querySelector('input[name="payment"]:checked');
    if (!selected) {
      alert("Vui lòng chọn địa chỉ giao hàng.");
      return;
    }
    if (!selectedPayment) {
      alert("Vui lòng chọn phương thức thanh toán.");
      return;
    }
    const addressId = selected.value;
    
    fetch("../controllers/thanhtoan.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `address_id=${addressId}&payment_method=${encodeURIComponent(paymentMethod)}`
    })
    .then(response => response.text())
    .then(data => {
      alert("Thanh toán thành công!");
      window.location.href = "thankyouPage.php";
    })
    .catch(error => {
      console.error("Lỗi khi thanh toán:", error);
      alert("Thanh toán thất bại!");
    });
  }
</script>



</body>
</html>
