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
$ward = $conn->real_escape_string($data["ward"]);
$district = $conn->real_escape_string($data["quan"]);
$thanhpho = $conn->real_escape_string($data["thanhpho"]);
$diachi = $conn->real_escape_string($data["diachi"]);

$sql = "INSERT INTO thongTinGiaoHang (tennguoinhan, sdt, phuong, quan, thanhpho, diachi)
        VALUES ('$tennguoinhan', '$sdt', '$phuong', '$district', '$thanhpho', '$diachi')";

if ($conn->query($sql) === TRUE) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
