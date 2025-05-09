<!-- them_nhan_vien.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
</head>
<body>
    <h2>Thêm Nhân Viên</h2>
    <form action="add_nhanvien.php" method="POST">
        <label for="vai_tro">Vai trò:</label>
        <select name="vai_tro" id="edit-vai-tro">
            <option value="Quản lý">Quản lý</option>
            <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
            <option value="Kế toán">Kế toán</option>
            <option value="Bảo vệ">Bảo vệ</option>
            <option value="Tạp vụ">Tạp vụ</option>
            <option value="Nhân viên kho">Nhân viên kho</option>
            <option value="Thủ kho">Thủ kho</option>
            <option value="Lễ tân">Lễ tân</option>
            <option value="IT support">IT support</option>
        </select><br><br>
        <label for="ten_nhan_vien">Tên Nhân Viên:</label>
        <input type="text" id="ten_nhan_vien" name="ten_nhan_vien" required><br><br>
        
        <label for="muc_luong">Mức Lương:</label>
        <input type="number" id="muc_luong" name="muc_luong" required><br><br>
        
        <input type="submit" name="submit" value="Thêm Nhân Viên">
    </form>
</body>
</html>
<style>
    /* Reset margin và padding để chuẩn hóa giao diện */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Đặt nền và font chữ chung cho trang */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9; /* Màu nền nhẹ nhàng */
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container chứa form */
.container {
    background-color: #ffffff; /* Nền trắng cho container */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px; /* Đặt chiều rộng tối đa */
    text-align: center;
}

/* Tạo kiểu cho tiêu đề */
h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
    font-weight: 600;
}

/* Kiểu cho nhãn (labels) */
label {
    font-size: 16px;
    color: #555;
    margin-bottom: 5px;
    display: block;
    text-align: left;
}

/* Kiểu cho các trường nhập liệu (inputs) và select */
input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #4CAF50; /* Màu viền khi focus */
    outline: none;
}

/* Kiểu cho nút submit */
input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50; /* Màu nền của nút */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #45a049; /* Màu nền khi hover */
}

input[type="submit"]:active {
    background-color: #3e8e41; /* Màu nền khi nhấn */
}

</style>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $vai_tro = $_POST['vai_tro'];
    $ten_nhan_vien = $_POST['ten_nhan_vien'];
    $muc_luong = $_POST['muc_luong'];
    $ngay_tao = date('Y-m-d');  // Lấy ngày hiện tại cho ngày tạo
    $ngay_chinh_sua = date('Y-m-d');  // Lấy ngày hiện tại cho ngày chỉnh sửa

    // Query để thêm nhân viên
    $sql = "INSERT INTO NhanVien (vai_tro, ten_nhan_vien, ngay_tao, ngay_chinh_sua, muc_luong)
            VALUES ('$vai_tro', '$ten_nhan_vien', '$ngay_tao', '$ngay_chinh_sua', '$muc_luong')";

    if ($conn->query($sql) === TRUE) {
        echo "Nhân viên đã được thêm thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
