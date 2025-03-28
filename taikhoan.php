<?php
require_once("./database/database.php");
$servername="localhost";
$username="root";
$password="";
$dbname="ltw&ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
session_start();
if(isset($_GET['userId'])){
    $userId=$_GET['userId'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <style>
        .outeraccount{
            display: grid;
            grid-template-columns: 10% 80% 10%;
            height: 100vh;
        }
        .container_account{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .left_account{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
            height: 100%;
        }
        .right_account{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
            height: 100%;
            background-color: blue;
        }
    </style> -->
    <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    .account-box {
      width: 280px;
      border-radius: 12px;
      border: 1px solid #eee;
      background-color: #fff;
      padding: 16px;
    }

    .account-level {
      text-align: center;
      margin-bottom: 16px;
    }

    .account-level img {
      width: 60px;
      height: 60px;
      opacity: 0.4;
    }

    .account-level p {
      margin: 4px 0;
      font-size: 14px;
      color: gray;
    }

    .upgrade-info {
      font-size: 12px;
      color: #888;
    }

    .account-menu {
      border-top: 1px solid #eee;
      margin-top: 12px;
      padding-top: 12px;
    }

    .menu-section {
      margin-bottom: 16px;
    }

    .menu-title {
      display: flex;
      align-items: center;
      font-weight: bold;
      color: #c10000;
      margin-bottom: 8px;
    }

    .menu-title::before {
      content: "🧍";
      margin-right: 8px;
    }

    .menu-item {
      margin-left: 24px;
      font-size: 14px;
      color: #333;
      margin-bottom: 6px;
      cursor: pointer;
    }

    .menu-item.active {
      color: red;
      font-weight: bold;
    }

    .menu-icon-section {
      margin-top: 16px;
    }

    .menu-icon-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      font-size: 14px;
      color: #333;
      cursor: pointer;
    }

    .menu-icon-item img {
      width: 18px;
      margin-right: 8px;
    }

    .badge {
      background-color: red;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 12px;
      margin-left: 6px;
    }
        .tablinks{
            padding:10px;
            color:#1e1e1e;
            font-weight: bold;
            /* color:aqua; */
        }
        .inputHeader>input{
            outline:none;
        }
        #menuLogo:hover{
            cursor:pointer;
        }
        .menuContent{
            display:none;
        }
        body {
      font-family: Arial, sans-serif;
      background: #f8f8f8;
      margin: 0;
      padding: 20px;
    }

    .warning {
      background-color: #fff3f3;
      color: #d60000;
      border: 1px solid #ffcaca;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      font-size: 14px;
    }

    .warning a {
      color: red;
      font-weight: bold;
      text-decoration: none;
      margin-left: 5px;
    }

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      max-width: 700px;
      margin: auto;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    .form-group {
      display: flex;
      margin-bottom: 15px;
      align-items: center;
    }

    .form-group label {
      width: 150px;
      font-size: 14px;
      color: #333;
    }

    .form-group label::after {
      content: '*';
      color: red;
      margin-left: 4px;
    }

    .form-group input,
    .form-group select {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group input[disabled] {
      background: #f3f3f3;
      color: #999;
    }

    .form-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 30px;
    }

    .form-footer .note {
      font-size: 12px;
      color: #888;
    }

    .form-footer button {
      background-color: #d60000;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #007bff;
      font-size: 14px;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

  </style>
  <link rel="stylesheet" href="./css/header.css">
</head>
<body>
<?php 
    include_once("zui/header.php");

    ?>




    <div class="account-menu">
      <div class="menu-section">
        <div class="menu-title">Thông tin tài khoản</div>
        <div class="menu-item">Hồ sơ cá nhân</div>
        <div class="menu-item active">Sổ địa chỉ</div>
        <div class="menu-item">Đổi mật khẩu</div>
        <div class="menu-item">Thông tin xuất hóa đơn GTGT</div>
        <div class="menu-item">Ưu đãi thành viên</div>
      </div>

      <div class="menu-icon-section">
        <div class="menu-icon-item">🛍️ Đơn hàng của tôi</div>
        <div class="menu-icon-item">🎟️ Ví voucher <span class="badge">15</span></div>
        <div class="menu-icon-item">💰 Tài Khoản F-Point / Freeship</div>
      </div>
    </div>
    <div class="right">

  <div class="warning">
    Bạn vui lòng cập nhật thông tin tài khoản:
    <a href="#">Cập nhật thông tin ngay</a>
  </div>

  <div class="form-container">
    <h2>Thêm địa chỉ mới</h2>

    <form>
      <div class="form-group">
        <label for="lastname">Họ</label>
        <input type="text" id="lastname" placeholder="Họ*">
      </div>

      <div class="form-group">
        <label for="firstname">Tên</label>
        <input type="text" id="firstname" placeholder="Tên*">
      </div>

      <div class="form-group">
        <label for="phone">Điện thoại</label>
        <input type="text" id="phone" placeholder="Ex: 0972xxxx">
      </div>

      <div class="form-group">
        <label for="country">Quốc gia</label>
        <select id="country">
          <option selected>Việt Nam</option>
        </select>
      </div>

      <div class="form-group">
        <label for="province">Tỉnh/Thành phố</label>
        <select id="province">
          <option>Vui lòng chọn</option>
        </select>
      </div>

      <div class="form-group">
        <label for="district">Quận/Huyện</label>
        <input type="text" id="district">
      </div>

      <div class="form-group">
        <label for="ward">Xã/Phường</label>
        <input type="text" id="ward">
      </div>

      <div class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" id="address" placeholder="Địa chỉ">
      </div>

      <div class="form-group">
        <label for="zipcode">Mã bưu điện</label>
        <input type="text" id="zipcode" value="Mã bưu điện VN: 700000" disabled>
      </div>

      <div class="form-footer">
        <span class="note">(*): bắt buộc</span>
        <button type="submit">LƯU ĐỊA CHỈ</button>
      </div>
    </form>

    <a href="#" class="back-link">« Quay lại</a>
  </div>
    </div>
  </div>
  
</body>
</html>

    <!-- <div class="outer_account">
        <div></div>
        <div class="container_account">
            <div class="left_account">
                <div>
                    <div>
                        <img src="./images/forHeader/default avatar.png" alt="">
                    </div>
                    <div> Mikasa Chan</div>
                </div>
                <div class="line"></div>
                <div>
                    Thông tin tài khoản
                    <div>
                        <div>Hồ sơ cá nhân</div>
                        <div>Sổ địa chỉ</div>
                        <div>Đổi mật khẩu</div>
                    </div>
                </div>
                <div>Đơn hàng của tôi</div>
                <div>Thông báo</div>
                <div>Sản phẩm yêu thích</div>
                <div>Nhận xét của tôi</div>
                <div></div>
            </div>
            <div class="right_account">

            </div>
        </div>
        <div></div>
    </div> -->
</body>
</html>