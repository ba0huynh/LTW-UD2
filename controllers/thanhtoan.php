<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = (int)$_SESSION['user_id'];
$paymentMethod = isset($_POST['payment_method']) ? $conn->real_escape_string($_POST['payment_method']) : '';
$address_id = isset($_POST['address_id']) ? (int)$_POST['address_id'] : 0;

if ($address_id == 0 && isset($_POST['tennguoinhan'])) {
    $tennguoinhan = $conn->real_escape_string($_POST['tennguoinhan']);
    $sdt = $conn->real_escape_string($_POST['sdt']);
    $phuong = $conn->real_escape_string($_POST['phuong']);
    $quan = $conn->real_escape_string($_POST['district']);
    $thanhpho = $conn->real_escape_string($_POST['thanhpho']);
    $diachi = $conn->real_escape_string($_POST['diachi']);
    $macdinh = isset($_POST['macdinh']) && $_POST['macdinh'] == 'true' ? 1 : 0;

    $sqlInsertAddress = "
        INSERT INTO thongTinGiaoHang (id_user, tennguoinhan, sdt, diachi, huyen, quan, thanhpho, status)
        VALUES ($user_id, '$tennguoinhan', '$sdt', '$diachi', '$phuong', '$quan', '$thanhpho', $macdinh)
    ";

    if ($conn->query($sqlInsertAddress)) {
        $address_id = $conn->insert_id;
    } else {
        echo "Lỗi khi thêm địa chỉ mới: " . $conn->error;
        exit();
    }
}


$sql = "
    SELECT cartitems.bookId, cartitems.amount, books.currentPrice 
    FROM cart 
    JOIN cartitems ON cart.idCart = cartitems.cartId 
    JOIN books ON books.id = cartitems.bookId 
    WHERE cart.idUser = $user_id AND cartitems.amount > 0
";

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "Không có sản phẩm trong giỏ hàng!";
    exit();
}

$tongtien = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $bookId = (int)$row['bookId'];
    $amount = (int)$row['amount'];
    $price = (float)$row['currentPrice'];
    $thanhtien = $amount * $price;
    $tongtien += $thanhtien;
    $items[] = [
        'bookId' => $bookId,
        'amount' => $amount,
        'thanhtien' => $thanhtien
    ];
}

$address_value = ($address_id > 0) ? $address_id : "NULL";

$insertInvoice = "
    INSERT INTO hoadon (idUser, id_diachi, totalBill, create_at, ngay_cap_nhat, paymentMethod)
    VALUES ($user_id, $address_value, $tongtien, NOW(), NOW(), '$paymentMethod')
";


if (!$conn->query($insertInvoice)) {
    die("Lỗi khi tạo hóa đơn: " . $conn->error);
}

$hoadon_id = $conn->insert_id;

foreach ($items as $item) {
    $bookId = $item['bookId'];
    $amount = $item['amount'];
    $thanhtien = $item['thanhtien'];

    $insertDetail = "
        INSERT INTO chitiethoadon (idHoadon, idBook, amount)
        VALUES ($hoadon_id, $bookId, $amount)
    ";

    if (!$conn->query($insertDetail)) {
        echo "Lỗi khi thêm chi tiết hóa đơn: " . $conn->error;
        exit();
    }
}

$conn->query("
    DELETE FROM cartitems 
    WHERE cartId IN (SELECT idCart FROM cart WHERE idUser = $user_id)
    AND amount > 0
");

echo "Thanh toán thành công!";
?>
