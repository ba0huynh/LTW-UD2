<?php
$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


// Tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Đếm tổng số bản ghi
$count_sql_search = "SELECT COUNT(*) AS total FROM hoadon,users WHERE  hoadon.statusBill=1 and hoadon.idUser=users.id and fullName LIKE '%$search%'";
$count_sql="SELECT COUNT(*) AS total FROM hoadon,users WHERE hoadon.statusBill=1 and hoadon.idUser=users.id ";
$show=empty($search)?$count_sql:$count_sql_search;
$count_result = $conn->query($show);
$total_rows = $count_result ->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);



?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>


<div class="w-full bg-white p-6 rounded-2xl mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Quản lí dơn hàng</h2>

    <div class="flex justify-between items-center mb-4">

        <form method="GET" action="">
            <input type="text" name="search" placeholder="Tìm kiếm" value="<?= htmlspecialchars($search) ?>" class="border px-4 py-2 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit">Tìm kiếm</button>
        </form>
        <button onclick="toggleFilterModal()" id="timeFilterBtn"
            type="button"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            🗓️ Thời gian
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl relative">
                <!-- Nút đóng -->
                <button onclick="toggleFilterModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>

                <!-- Tiêu đề -->
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bộ lọc nâng cao</h3>

                <form action="" method="GET" class="space-y-4 text-sm text-gray-700">
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
                    <div>
                        <label class="block font-medium mb-1">Ngày đặt từ:</label>
                        <input type="date" name="from_date" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Đến ngày:</label>
                        <input type="date" name="to_date" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Trạng thái:</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="">Tất cả</option>
                        <option value="1">Đang xử lý</option>
                        <option value="2">Đang giao</option>
                        <option value="3">Hoàn thành</option>
                        <option value="4">Đã hủy</option>
                        </select>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold text-sm shadow">
                        Áp dụng bộ lọc
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="overflow-x-auto">
      <table class="min-w-full border rounded-lg overflow-hidden">
        <thead>
          <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
            <th  class="px-6 py-4 text-left">Mã đơn</th>
            <th  class="px-6 py-4 text-left">Ngày đặt</th>
            <th  class="px-6 py-4 text-left">Tên khách hàng</th>
            <th class="px-6 py-4 text-left">Số điện thoại</th>
            <th class="px-6 py-4 text-left">Địa chỉ</th>
            <th class="px-6 py-4 text-left">Tổng hóa đơn</th>
            <th class="px-6 py-4 text-center">Trạng thái</th>
            <th class="px-6 py-4 text-center">Chức năng</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Dòng dữ liệu -->
          <?php
          $sql = empty($search)
            ? "SELECT userName,sdt,diachi,quan,huyen,thanhpho,hoadon.idBill,hoadon.totalBill,hoadon.statusBill,users.fullName,create_at,phoneNumber,paymentMethod
            FROM hoadon 
            JOIN users ON hoadon.idUser = users.id 
            JOIN thongTinGiaoHang ON hoadon.id_diachi = thongTinGiaoHang.id
            "
            : "SELECT userName,sdt,diachi,quan,huyen,thanhpho,hoadon.idBill,hoadon.totalBill,hoadon.statusBill,users.fullName,create_at,phoneNumber,paymentMethod
            FROM hoadon 
            JOIN users ON hoadon.idUser = users.id 
            JOIN thongTinGiaoHang ON hoadon.id_diachi = thongTinGiaoHang.id
            WHERE users.fullName LIKE '%$search%' 
            ";

            $result = $conn->query($sql);
            $texts = [
              1 => 'Đang xử lý',
              2 => 'Đang được giao', 3 => 'Giao hàng thành công',
              4 => 'Đơn hàng đã hủy'
            ];
            while ($row = $result->fetch_assoc()) { 
                  $text = $texts[$row['statusBill']] ?? 'Không xác định';
           ?>
            <tr>
                <td class="px-6 py-4"># MD<?= htmlspecialchars($row['idBill']) ?></td>
                <td class="px-6 py-4">
                  <div class=" bg-gray-50 px-2 py-1 rounded-md shadow-sm text-gray-700 text-sm inline-block mb-2">
                    📅 : <?= htmlspecialchars($row['create_at']) ?> 
                  </div>
                  
                </td>

                <td class="px-6 py-4"><?= htmlspecialchars($row['fullName']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['phoneNumber']) ?></td>

                <td class="px-6 py-4"><?= htmlspecialchars($row['diachi']) ?> 
                <?= htmlspecialchars($row['quan']) ?>
                <?= htmlspecialchars($row['huyen']) ?>
                <?= htmlspecialchars($row['thanhpho']) ?>
                </td>
                <td class="px-6 py-4 text-blue-600 font-semibold"><?= number_format($row['totalBill'], 0, ',', '.') ?>đ</td>
                <td class="px-6 py-4 text-center">
                    <form method="POST" style="display:inline;" action="../../controllers/duyetsanpham.php" >
                        <input type="hidden" name="idBill" value="<?= $row['idBill'] ?>">
                        <!-- <button type="submit" name="approve" class="bg-blue-100 text-blue-600 border border-blue-200 px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm hover:bg-blue-200 transition">Duyệt</button> -->
                        <div class="bg-blue-100 text-blue-600 border border-blue-200 px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm hover:bg-blue-200 transition"><?php echo $text;?></div>
                    </form>

                </td>

                <td class="px-6 py-4 text-center space-x-2">
                    <form  style="display:inline;">
                        <input type="hidden" name="idBill" value="<?= $row['idBill'] ?>">
                        <button 
                            class="btn-huy bg-green-100 text-green-600 border border-green-200 px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm hover:bg-green-200 transition"
                            data-id="<?= $row['idBill'] ?>"
                            onclick="huyDon(<?= $row['idBill'] ?>)"
                        >
                            Huỷ đơn
                        </button>


                    </form>
                    <button 
                    class="text-green-500 hover:text-green-700 text-xl"
                    onclick="showOrderDetail(this)"
                    data-id="<?= $row['idBill'] ?>"
                    data-name="<?= $row['fullName'] ?>"
                    data-date="<?= $row['create_at'] ?>"
                    data-district="<?= $row['quan'] ?>"
                    data-ward="<?= $row['huyen'] ?>"
                    data-address="<?= $row['diachi'] ?>"
                    data-city="<?= $row['thanhpho'] ?>"
                    data-phone="<?= $row['sdt'] ?>"
                    data-payment="<?= $row['paymentMethod'] ?>"
                    data-status="<?= htmlspecialchars($row['statusBill']) ?>"
                    data-products='<?= htmlspecialchars(json_encode($products), ENT_QUOTES, 'UTF-8') ?>'

                  >
                    👁️
                  </button>


                    <button 
                    class="p-2 bg-white border rounded hover:bg-gray-100"
                    onclick="openUpdateModal(this)"
                    data-id="<?php echo $row['idBill']?>"
                    data-name="<?php echo $row['userName']?>"
                    data-date="<?php echo $row['create_at']?>"
                    data-total="<?php echo $row['totalBill']?>"
                    <?php if(!empty($row['ly_do_huy'])){?>
                      data-note="<?php echo $row['ly_do_huy']?>"
                    <?php }?>

                    data-status="<?php echo $text?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            fill="currentColor" 
                            viewBox="0 0 24 24" 
                            class="w-5 h-5 text-purple-600">
                            <path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM21.41 6.34a1.25 1.25 0 0 0 0-1.77l-2-2a1.25 1.25 0 0 0-1.77 0l-1.83 1.83 3.75 3.75 1.85-1.81z"/>
                        </svg>
                    </button>


                </td>
            </tr>
            <?php } ?>
           <!--  -->

        </tbody>
      </table>
    </div>
    <div class="flex justify-center mt-6">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <div class="mx-1">
            <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>">
                <button class="bg-blue-600 text-white rounded-full w-8 h-8 text-sm font-bold <?= $i === $page ? 'bg-blue-800' : '' ?>">
                    <?= $i ?>
                </button>
            </a>
        </div>
    <?php endfor; ?>
    </div>

</div>
<div id="updateModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 space-y-4 relative">
        <!-- Nút đóng -->
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition text-xl font-semibold">&times;</button>

        <!-- Tiêu đề -->
        <h2 class="text-lg font-bold text-gray-800">
            Cập nhật trạng thái đơn hàng <span id="modalOrderId" class="text-indigo-600">#MD<?php ?></span>
        </h2>

        <!-- Thông tin đơn -->
        <div class="space-y-1 text-sm text-gray-700">
            <p><span class="font-semibold">Khách hàng:</span> <span id="modalCustomer"></span></p>
            <div class=" bg-gray-50 px-2 py-1 rounded-md shadow-sm text-gray-700 text-sm inline-block mb-2">
              📅 : <span id="modalDate"></span>
            </div>
            <p><span class="font-semibold">Tổng tiền:</span> <span id="modalTotal"></span></p>
            <p>
              <span class="font-semibold">Địa chỉ : </span> <span id="modalAddress"></span>,
              <span id="modalDistrict"></span>,
              <span id="modalCity"></span>,
              <span id="modalWard"></span>,

            </p>
        </div>

        <!-- Trạng thái -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái:</label>
            <select id="modalStatus"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option>Đang xử lý</option>
                <option>Đang giao hàng</option>
                <option>Giao hàng thành công</option>
                <option>Đã hủy</option>
            </select>
        </div>

        <!-- Ghi chú -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú (nếu có):</label>
            <div class="relative">
                <textarea id="modalNote" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
                <span class="absolute bottom-2 right-3 text-gray-400">✏️ </span>
            </div>
        </div>

        <!-- Nút lưu -->
        <div id="saveStatusBtn" class="pt-4">
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 rounded-lg transition shadow-md">
                Lưu thay đổi
            </button>
        </div>
    </div>
</div>
<div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 space-y-5 relative text-sm text-gray-800">
        <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition text-xl font-bold">&times;</button>
    <h2 class="text-lg font-bold text-gray-900">Chi tiết đơn hàng <span id="orderId" class="text-indigo-600"></span></h2>
    <div class="space-y-1 leading-relaxed">
        <p><strong>Khách hàng:</strong> <span id="idCustomer"></span></p>
        <p><strong>Ngày đặt:</strong> <span id="orderDate"></span></p>
        <p>
          <strong>Địa chỉ:</strong> 
          <span id="orderAddress"></span>,
          <span id="orderDistrict"></span>,
          <span id="orderWard"></span>,
          <span id="orderCity"></span>
        </p>
        <p><strong>SĐT:</strong> <span id="orderPhone"></span></p>
        <p><strong>Phương thức thanh toán:</strong> <span id="orderPayment"></span></p>
        <p><strong>Trạng thái:</strong> 
            <span id="orderStatus" class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold border border-blue-300 ml-1"></span>
        </p>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Chi tiết sản phẩm:</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg text-center text-sm" id="orderProducts">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="border px-3 py-1">Mã sản phẩm</th>
              <th class="border px-3 py-1">Sản phẩm</th>
              <th class="border px-3 py-1">SL</th>
              <th class="border px-3 py-1">Đơn giá</th>
              <th class="border px-3 py-1">Thành tiền</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="text-right text-sm font-medium space-y-1" id="orderSummary"></div>

        <div class="pt-4">
        <button onclick="closeDetailModal()" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 rounded-lg transition shadow-sm">
            Đóng
        </button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.btn-huy').forEach(button => {
    button.addEventListener('click', () => {
      const idBill = button.dataset.id;

      if (!confirm(`Bạn có chắc muốn huỷ đơn hàng #${idBill}?`)) return;

      fetch('../../controllers/huydon.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `idBill=${idBill}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          button.closest('tr').remove();
        } else {
          alert('❌ ' + data.message);
        }
      })
      .catch(err => {
        alert('Lỗi kết nối đến máy chủ.');
      });
    });
  });
});
</script>

<script>
    
function toggleFilterModal() {
  const modal = document.getElementById("filterModal");
  modal.classList.toggle("hidden");
}
</script>

<script>
function formatCurrency(n) {
  return new Intl.NumberFormat('vi-VN').format(n) + 'đ';
}
function showOrderDetail(btn) {
  const texts = {
    1: 'Đang xử lý',
    2: 'Đang được giao',
    3: 'Giao hàng thành công',
    4: 'Đơn hàng đã hủy'
  };

  document.getElementById("orderDetailModal").classList.remove("hidden");
  document.getElementById("orderId").textContent = "#MD" + btn.dataset.id;
  document.getElementById("idCustomer").textContent = btn.dataset.name;
  document.getElementById("orderDate").textContent = btn.dataset.date;
  document.getElementById("orderAddress").textContent = btn.dataset.address;
  document.getElementById("orderDistrict").textContent = btn.dataset.district;
  document.getElementById("orderWard").textContent = btn.dataset.ward;
  document.getElementById("orderCity").textContent = btn.dataset.city;
  document.getElementById("orderPhone").textContent = btn.dataset.phone;
  document.getElementById("orderPayment").textContent = btn.dataset.payment;
  document.getElementById("orderStatus").textContent = texts[btn.dataset.status] || "Không xác định";

  const tbody = document.querySelector("#orderProducts tbody");
  tbody.innerHTML = "";

  fetch("../../controllers/get_order_detail.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id=" + btn.dataset.id
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      console.log("✅ Danh sách sản phẩm:", data.products);
      let subtotal = 0;
      data.products.forEach((item, i) => {
        const total = item.price * item.quantity;
        subtotal += total;
        tbody.innerHTML += `
          <tr>
            <td class="border px-3 py-1">${item.id}</td>
            <td class="border px-3 py-1">${item.name}</td>
            <td class="border px-3 py-1">${item.quantity}</td>
            <td class="border px-3 py-1">${formatCurrency(item.price)}</td>
            <td class="border px-3 py-1">${formatCurrency(total)}</td>
          </tr>
        `;
      });

      document.getElementById("orderSummary").innerHTML = `
        <p>Tạm tính: <span class="text-gray-800 font-bold">${formatCurrency(subtotal)}</span></p>
        <p>Phí vận chuyển: <span class="text-gray-800 font-bold">0đ</span></p>
        <p class="text-base">Tổng cộng: <span class="text-indigo-700 text-lg font-bold">${formatCurrency(subtotal)}</span></p>
      `;
    } else {
      alert("❌ " + data.message);
      tbody.innerHTML = `<tr><td colspan="5" class="text-red-500 text-center">Không tìm thấy sản phẩm</td></tr>`;
    }
  })
  .catch(err => {
    console.error(err);
    tbody.innerHTML = `<tr><td colspan="5" class="text-red-500 text-center">Lỗi khi tải sản phẩm</td></tr>`;
  });
}



function closeDetailModal() {
  document.getElementById("orderDetailModal").classList.add("hidden");
}



</script>

<script>
function openUpdateModal(button) {
  document.getElementById("modalOrderId").textContent = "#MD" + button.dataset.id;
  document.getElementById("modalCustomer").textContent = button.dataset.name;
  document.getElementById("modalDate").textContent = button.dataset.date;
  document.getElementById("modalTotal").textContent = 
    new Intl.NumberFormat('vi-VN').format(button.dataset.total) + 'đ';
    const statusMap = {
    1: "Đang xử lý",
    2: "Đang giao hàng",
    3: "Giao hàng thành công",
    4: "Đã hủy"
  };
  document.getElementById("modalNote").textContent=button.dataset.note;
  const statusText = statusMap[button.dataset.status] || "Đang xử lý";
  document.getElementById("modalStatus").value = statusText;

  // Hiện modal
  document.getElementById("updateModal").classList.remove("hidden");
}

function closeModal() {
  document.getElementById("updateModal").classList.add("hidden");
}
</script>



<script>
document.getElementById('saveStatusBtn').addEventListener('click', function () {
  const idText = document.getElementById('modalOrderId').textContent;
  const idBill = idText.replace('#MD', ''); // Lấy số ID đơn
  const statusText = document.getElementById('modalStatus').value;
  const note = document.querySelector('#updateModal textarea').value;

  // Chuyển đổi trạng thái từ text sang số
  const statusMap = {
    "Đang xử lý": 1,
    "Đang giao hàng": 2,
    "Giao hàng thành công": 3,
    "Đã hủy": 4
  };

  const status = statusMap[statusText] || 1;

  // Gửi AJAX
  fetch('../../controllers/capnhat_trangthai_don.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      idBill: idBill,
      statusBill: status,
      note: note
    })
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || 'Cập nhật thành công');
    location.reload(); // Refresh trang
  })
  .catch(err => {
    console.error('Lỗi:', err);
    alert('Có lỗi xảy ra khi cập nhật trạng thái');
  });
});
</script>



</body>
</html>
<?php $conn->close(); ?>
