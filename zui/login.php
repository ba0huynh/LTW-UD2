<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>
    <div id="user" class="modal">
        <!--ĐĂNG NHẬP -->
        <div id="login" class="login-container" >
            <form id="login-form" class="login-form">
                <h2>Đăng Nhập</h2>
                <label for="username"><i class="fas fa-user"></i> Số điện thoại</label>
                <input type="text" id="login-username" name="username" placeholder="Nhập số điện thoại..." required>

                <label for="password"><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" id="login-password" name="password" placeholder="Nhập mật khẩu" required>
                <!-- <p>Quên Mật Khẩu?</p> -->
                <input type="submit" value="Đăng Nhập">
                <p class="close">Bỏ Qua</p>
                <p>Chưa Có Tài Khoản? <a href="javascript:void(0)" onclick="switchToSignup()">Đăng Ký</a></p>
            </form>
        </div>

        <!--ĐĂNG KÝ-->
        <div id="signup" class="signup-container" >
            <form id="signup-form" class="signup-form">
                <h2>Đăng Ký</h2>
                <label for="phone"><i class="fa-solid fa-phone"></i> Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" required>
                <span class="loi" id="loiSdt" ></span>

                <label for="name">Họ tên:</label>
                <input type="text" id="register-name" name="name" placeholder="Họ và Tên" required>
                <span class="loi" id="loiTen" ></span>
                <!--            
                <label for="name"><i class="fas fa-user-circle"></i> Mã xác nhận OTP</label>
                <input type="text" id="name" name="name" placeholder="6 ký tự" required> -->
                
                <label for="password"><i class="fas fa-lock"></i> Mật Khẩu</label>
                <input type="password" id="signup-password" name="password" placeholder="Nhập Mật Khẩu" required>
                <label for="confirm-password">Xác nhận mật khẩu:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Nhập lại mật khẩu" required>
                <span class="loi" id="loiPass" ></span>
                <label for="address">Địa Chỉ:</label>
                <input type="text" id="register-address" name="address" placeholder="Số nhà, đường, phường ..." required >
                <span class="loi" id="loiDchi" ></span>
                <input type="submit" value="Đăng Ký">
                <p class="close">Bỏ Qua</p>
                <p>Đã có tài khoản? <a href="javascript:void(0)" onclick="switchToLogin()">Đăng nhập</a></p>
            </form>
            <p>Bằng cách đăng ký, bạn đồng ý với Fahasa về <a href="#" id="termsBtn">Điều khoản Dịch vụ</a> và <a
                    href="#" id="privacyBtn">Chính sách Bảo mật</a>.</p>
        </div>

    </div>
    
    <script>
//===========chuyển form
        function openModal() {
            document.getElementById('user').style.display = 'flex'; 
        }
    
        function closeModal() {
            document.getElementById('user').style.display = 'none'; 
        }
    
        function switchToSignup() {
            document.getElementById('login').style.display = 'none';
            document.getElementById('signup').style.display = 'flex';
        }
    
        function switchToLogin() {
            document.getElementById('signup').style.display = 'none';
            document.getElementById('login').style.display = 'flex';
        }
    
        const closeBtns = document.querySelectorAll('.close');
        closeBtns.forEach(button => {
            button.addEventListener('click', closeModal);  
        });
    
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('user');
            if (event.target === modal) {
                closeModal(); 
            }
        });



        //====== kiểm tra đầu vào======
        document.getElementById('signup-form').addEventListener('submit', function(event) {
        event.preventDefault();

        let isValid = true;

        const phone = document.getElementById('phone').value;
        const name = document.getElementById('register-name').value;
        const address = document.getElementById('register-address').value;
        const passwd = document.getElementById('signup-password').value;
        const confirmPasswd = document.getElementById('confirm-password').value;

        if (!/^0[0-9]{9}$/.test(phone)) {
            document.getElementById('loiSdt').innerText = "Số điện thoại phải là 10 chữ số và bắt đầu bằng 0!";
            document.getElementById('loiSdt').style.display = 'block';
            document.getElementById('phone').focus();
            isValid = false;
        } else {
            document.getElementById('loiSdt').style.display = 'none';
        }

        if (!/^[a-zA-Z\s]+$/.test(name)) {
            document.getElementById('loiTen').innerText = "Họ tên chỉ được chứa chữ cái và dấu cách!";
            document.getElementById('loiTen').style.display = 'block';
            document.getElementById('register-name').focus();
            isValid = false;
        } else {
            document.getElementById('loiTen').style.display = 'none';
        }

        if (!/^[a-zA-Z0-9\s]+$/.test(address)) {
            document.getElementById('loiDchi').innerText = "Địa chỉ chỉ được chứa chữ cái, số và dấu cách!";
            document.getElementById('loiDchi').style.display = 'block';
            document.getElementById('register-address').focus();
            isValid = false;
        } else {
            document.getElementById('loiDchi').style.display = 'none';
        }

        if (passwd !== confirmPasswd) {
            document.getElementById('loiPass').innerText = "Mật khẩu và xác nhận mật khẩu không khớp!";
            document.getElementById('loiPass').style.display = 'block';
            document.getElementById('confirm-password').focus();
            isValid = false;
        } else {
            document.getElementById('loiPass').style.display = 'none';
        }

        if (isValid) {
            document.getElementById("signup-form").submit();
        }
    });

    </script>
</body>
</html>