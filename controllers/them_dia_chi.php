<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
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


$data = json_decode(file_get_contents("php://input"), true);

$tennguoinhan = $conn->real_escape_string($data["tennguoinhan"]);
$sdt = $conn->real_escape_string($data["sdt"]);
$phuong = $conn->real_escape_string($data["phuong"]);
$district = $conn->real_escape_string($data["quan"]);
$thanhpho = $conn->real_escape_string($data["thanhpho"]);
$diachi = $conn->real_escape_string($data["diachi"]);
$macdinh = $data["macdinh"] ? 1 : 0;

$sql = "INSERT INTO thongTinGiaoHang (tennguoinhan, sdt, phuong, quan, thanhpho, diachi, status)
        VALUES ('$tennguoinhan', '$sdt', '$phuong', '$district', '$thanhpho', '$diachi', $macdinh)";

if ($conn->query($sql) === TRUE) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
