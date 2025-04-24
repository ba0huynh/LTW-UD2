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


$address_id = $_POST['address_id'] ?? null;
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

// Lấy sản phẩm trong giỏ hàng
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

// Tính tổng tiền
$tongtien = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $bookId = $row['bookId'];
    $amount = $row['amount'];
    $price = $row['currentPrice'];
    $thanhtien = $amount * $price;
    $tongtien += $thanhtien;
    $items[] = [
        'bookId' => $bookId,
        'amount' => $amount,
        'thanhtien' => $thanhtien
    ];
}


$conn->query("INSERT INTO hoadon (idUser, id_address, totalBill, create_at) VALUES ($user_id, $address_id, $tongtien, NOW())");

$hoadon_id = $conn->insert_id;

foreach ($items as $item) {
    $bookId = $item['bookId'];
    $amount = $item['amount'];
    $price = $item['thanhtien'];
    $conn->query("INSERT INTO chitiethoadon (idHoadon, idBook, amount, thanhtien) 
                  VALUES ($hoadon_id, $bookId, $amount, $thanhtien)");
}

$conn->query("DELETE FROM cartitems WHERE idCart IN (SELECT idCart FROM cart WHERE idUser = $user_id)");

echo "Thanh toán thành công!";
?>
