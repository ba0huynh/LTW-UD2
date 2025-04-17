
<div class="container">
        <div class="alert">Bạn vui lòng cập nhật thông tin tài khoản: <a href="#" style="color: red; font-weight: bold;">Cập nhật ngay</a></div>

        <div class="wrap">
            <div class="header">
                <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Avatar">
                <div class="member-btn">
                    <button class="member">Thành viên <span>~></span></button>
                </div>
            </div>
            <div class="stats">
                <div class="left">
                    <div>
                        <p><strong>F-Point hiện có</strong></p>
                        <p style="color: red;">0</p>
                    </div>
                    <div>
                        <p><strong>Freeship hiện có</strong></p>
                        <p style="color: red;">0 lần</p>
                    </div>
                </div>
                <div class="right">
                    <div>
                        <p><strong>Số đơn hàng</strong></p>
                        <p style="color: red;">0 đơn hàng</p>
                    </div>
                    <div>
                        <p><strong>Đã thanh toán</strong></p>
                        <p style="color: red;">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="infor">
            <h3>Hồ sơ cá nhân</h3>
            <form class="profile-form">
                <label>Họ*</label>
                <input type="text" placeholder="Nhập họ">
                <label>Tên*</label>
                <input type="text" placeholder="Nhập tên">
                <label>Số điện thoại</label>
                <input type="text" value="0798223927" disabled>
                <label>Email</label>
                <input type="email" placeholder="Nhập email">
                <label>Giới tính*</label>
                <div class="gender">
                    <input type="radio" name="gender" value="Nam"> Nam
                    <input type="radio" name="gender" value="Nữ"> Nữ
                </div>
                <label>Ngày sinh*</label>
                <input type="date">

                <div class="but-contain">
                    <button class="btn">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 60%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .alert {
            background: #ffe6e6;
            padding: 10px;
            color: red;
            text-align: center;
            border-radius: 5px;
            font-weight: bold;
        }
        .header {
            text-align: center;
            padding: 20px;
            position: relative; /* Để định vị button tuyệt đối trong header */
        }
        
        .header img {
            width: 120px;
        }
        
        .member-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .member {
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            color: black;
        }
        
        .member:hover {
            background: #f0f0f0;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            gap: 20px;
        }
        .left p, .right p {
            margin-top: 5px;
            text-align: left;
        }
        .stats .left, .stats .right {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .stats .left div, .stats .right div {
            flex: 1;
            background: #f8f8f8;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            font-size: 16px;
            text-align: center;
        }
        .infor {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .profile-form {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 20px 20px;
            align-items: center;
        }
        .profile-form label {
            text-align: left;
            font-weight: bold;
        }
        .profile-form input {
            width: 80%;
            padding: 8px 12px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .gender {
            display: flex;
            gap: 15px;
            align-items: center;
            width: max-content;
        }
        .btn {
            width: 30%;
            background: red;
            color: white;
            text-align: center;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: darkred;
        }
        .but-contain {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
    