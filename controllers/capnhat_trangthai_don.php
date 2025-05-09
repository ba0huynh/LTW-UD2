<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}
?>
<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Kết nối thất bại']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$idBill = intval($data['idBill']);
$status = intval($data['statusBill']);
//$note = $conn->real_escape_string($data['note']);

//$update = "UPDATE hoadon SET statusBill = $status, ly_do_huy = '$note' WHERE idBill = $idBill";
$update = "UPDATE hoadon SET statusBill = $status  WHERE idBill = $idBill";
$insertHoadon_trangthai = "INSERT INTO hoadon_trangthai (idBill, trangthai) VALUES ($idBill, $status)";


if ($conn->query($update)) {
    if ($conn->query($insertHoadon_trangthai)) {
        echo json_encode([
            "success" => true,
            "message" => "Đã cập nhật đơn hàng #MD$idBill",
            "redirect" => "../admin/gui/quanlidon.php"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Đã cập nhật đơn hàng #MD$idBill, nhưng không ghi được lịch sử trạng thái."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi cập nhật."
    ]);
}
$conn->close();
?>
