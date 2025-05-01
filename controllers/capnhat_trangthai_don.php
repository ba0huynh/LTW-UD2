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
$note = $conn->real_escape_string($data['note']);

$update = "UPDATE hoadon SET statusBill = $status, ly_do_huy = '$note' WHERE idBill = $idBill";
if ($conn->query($update)) {
    echo json_encode(['success' => true, 'message' => "Đã cập nhật đơn hàng #MD$idBill"]);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật']);
}
$conn->close();
?>
