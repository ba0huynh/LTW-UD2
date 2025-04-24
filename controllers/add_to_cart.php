<?php
session_start();
header('Content-Type: application/json'); // Phản hồi JSON

// DEBUG khi dev (xoá khi đưa lên server)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Kết nối thất bại: ' . $conn->connect_error]);
    exit;
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$book_id = intval($_POST['book_id'] ?? 0);

if ($book_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
    exit;
}

// Lấy hoặc tạo giỏ hàng
$check_cart = $conn->query("SELECT idCart FROM cart WHERE idUser = $user_id LIMIT 1");
if ($check_cart->num_rows > 0) {
    $cart_id = $check_cart->fetch_assoc()['idCart'];
} else {
    $conn->query("INSERT INTO cart (idUser) VALUES ($user_id)");
    $cart_id = $conn->insert_id;
}

// Kiểm tra xem sách đã có trong giỏ chưa
$check_item = $conn->query("SELECT * FROM cartitems WHERE cartId = $cart_id AND bookId = $book_id");
if ($check_item->num_rows > 0) {
    // Tăng số lượng nếu đã có
    $conn->query("UPDATE cartitems SET amount = amount + 1 WHERE cartId = $cart_id AND bookId = $book_id");
} else {
    // Thêm mới nếu chưa có
    $conn->query("INSERT INTO cartitems (cartId, bookId, amount) VALUES ($cart_id, $book_id, 1)");
}

// ✅ Trả kết quả về
echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
?>
