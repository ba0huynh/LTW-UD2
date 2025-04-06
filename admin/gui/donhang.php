

<!DOCTYPE html>
<html>
<head>
    <title>Quản lí giao hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['giaohang'])) {
    $idBill = $_POST['idBill'];
    $updateQuery = "UPDATE quanlihoadon SET status =2 WHERE idBill=$idBill";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Đã giao $idBill'); window.location.href=window.location.href;</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

if(isset($_POST['trahang'])){
    $idBill=$_POST["idBill"];
    $deleteQuery="update hoadon set statusBill=-1 where idBill=$idBill";
    if($conn->query($deleteQuery)){
        echo "<script>alert('đã xóa');window.location.href=window.location.href;</script>";
    }else{
        echo "lỗi".$conn->error;
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
// Tìm kiếm
// $search = isset($_GET['search']) ? $_GET['search'] : '';
if(!empty($_GET["search"])){
    $search = $conn->real_escape_string($search); // Bảo vệ khỏi SQL Injection
}
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Đếm tổng số bản ghi
$count_sql_search = "SELECT COUNT(*) AS total FROM hoadon,users,quanlihoadon WHERE   hoadon.idUser=users.id and fullName LIKE '%$search%' and quanlihoadon.idBill=hoadon.idBill and quanlihoadon.status=2 ";
$count_sql="SELECT COUNT(*) AS total FROM hoadon,quanlihoadon WHERE    quanlihoadon.idBill=hoadon.idBill and quanlihoadon.status=2  ";
$show=empty($search)?$count_sql:$count_sql_search;

$count_result = $conn->query($show);
$total_rows = $count_result ->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);


$query=empty($search)?"select * from hoadon 
        join quanlihoadon on hoadon.idBill=quanlihoadon.idBill 
        join thongtinhoadon on hoadon.idBill=thongtinhoadon.idHoadon
        join users on hoadon.idUser=users.id
      where  quanlihoadon.status=2
      LIMIT $limit OFFSET $offset"
      :"select * from hoadon 
      join quanlihoadon on hoadon.idBill=quanlihoadon.idBill 
      join thongtinhoadon on hoadon.idBill=thongtinhoadon.idHoadon
      join users on hoadon.idUser=users.id
      where  quanlihoadon.status=2 and fullName like '%$search%' 
      LIMIT $limit OFFSET $offset";

$result=$conn->query($query);
?>

    <div class="w-full bg-white p-6 rounded-2xl mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Đơn hàng đã hoàn thành</h2>

    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center space-x-2">
        <label class="text-gray-600">Hiển thị</label>
        <select class="border rounded px-2 py-1 text-sm">
          <option>10</option>
          <option>25</option>
          <option>50</option>
        </select>
        <span class="text-gray-600">dòng</span>
      </div>
      <form method="GET" action="">
        <input type="text" name="search" placeholder="Tìm kiếm" value="<?= htmlspecialchars($search) ?>" class="border px-4 py-2 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit">Tìm kiếm</button>
      </form>
    </div>
    <br>
    <div class="overflow-x-auto">
      <table class="min-w-full border rounded-lg overflow-hidden">
        <thead>
          <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
            <th  class="px-6 py-4 text-left">Người nhận</th>
            <th class="px-6 py-4 text-left">Số điện thoại</th>
            <th class="px-6 py-4 text-left">Địa chỉ</th>
            <th class="px-6 py-4 text-left">Tổng hóa đơn</th>
            <th class="px-6 py-4 text-center">Giao hàng</th>
            <th class="px-6 py-4 text-center">Chức năng</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Dòng dữ liệu -->
          <?php if ($result->num_rows == 0) { ?>
            <tr>
                <td colspan="6" class="text-center py-4">Không có đơn hàng nào</td>
            </tr>
          <?php }else{ ?>
          <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td class="px-6 py-4"><?= htmlspecialchars($row['fullName']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['phoneNumber']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['shippingAddress']) ?></td>
                <td class="px-6 py-4 text-blue-600 font-semibold"><?= number_format($row['totalBill'], 0, ',', '.') ?>đ</td>
                <td class="px-6 py-4 text-center space-x-2">
                    <button class="text-green-500 hover:text-green-700 text-xl">👁️</button>
                </td>
            </tr>
        <?php }} ?>
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
</body>
</html>
<?php $conn->close(); ?>
