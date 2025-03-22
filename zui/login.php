<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../LTW-UD2/css/login.css">
</head>

<body>
    <div id="user" class="modal">
        <!--ĐĂNG NHẬP -->
        <div id="login" class="login-container">
            <form id="login-form" class="login-form">
                <h2>Đăng Nhập</h2>
                <label for="login-email"><i class="fas fa-user"></i> Email</label>
                <input type="text" id="login-email" name="email" placeholder="Nhập email..." required>

                <label for="password"><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" id="login-password" name="password" placeholder="Nhập mật khẩu" required>
                <!-- <p>Quên Mật Khẩu?</p> -->
                <input type="submit" value="Đăng Nhập">
                <p class="close">Bỏ Qua</p>
                <p>Chưa Có Tài Khoản? <a href="javascript:void(0)" onclick="switchToSignup()">Đăng Ký</a></p>
            </form>
        </div>

        <!--ĐĂNG KÝ-->
        <div id="signup" class="signup-container">
            <form id="signup-form" class="signup-form">
                <h2>Đăng Ký</h2>
                <label for="email"><i class="fa-solid fa-user"></i> Email:</label>
                <input type="text" name="email" id="email" placeholder="Nhập email..." required>
                <span class="loi" id="loiEmail"></span>

                <!-- <label for="name">Họ tên:</label>
                <input type="text" id="register-name" name="name" placeholder="Họ và Tên" required>
                <span class="loi" id="loiTen"></span> -->
                           
                <label for="name"><i class="fas fa-user-circle"></i> Mã xác nhận OTP</label>
                <input type="text" id="name" name="name" placeholder="6 ký tự" required>
                <span class="loi" id="loiOtp"></span>

                <label for="password"><i class="fas fa-lock"></i> Mật Khẩu</label>
                <input type="password" id="signup-password" name="password" placeholder="Nhập Mật Khẩu..." required>

                <!-- <label for="confirm-password"><i class="fas fa-lock"></i> Xác nhận mật khẩu:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Nhập lại mật khẩu..." required>
                <span class="loi" id="loiPass"></span><br> -->

                <!-- <label for="address">Địa Chỉ:</label>
                <input type="text" id="register-address" name="address" placeholder="Số nhà, đường, phường ..." required>
                <span class="loi" id="loiDchi"></span> -->

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

            
            const email = document.getElementById("email").value;
            const otp = document.getElementById("name").value;
            const passwd = document.getElementById("signup-password").value;
            // const confirmPasswd = document.getElementById("confirm-password").value;

            

            if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
                document.getElementById('loiEmail').innerText = "Email không hợp lệ!";
                document.getElementById('loiEmail').style.display = 'block';
                document.getElementById('email').focus();
                isValid = false;
            } else {
                document.getElementById('loiEmail').style.display = 'none';
            }

            if (otp.length !== 6) {
                document.getElementById('loiOtp').innerText = "Mã OTP phải có 6 ký tự!";
                document.getElementById('loiOtp').style.display = 'block';
                document.getElementById('name').focus();
                isValid = false;
            } else {
                document.getElementById('loiOtp').style.display = 'none';
            }

            
            // if (passwd !== confirmPasswd) {
            //     isValid = false;
            //     document.getElementById('loiPass').style.display = 'block';
            //     document.getElementById('loiPass').innerText = "Xác nhận mật khẩu không khớp!";
            // } else {
            //     document.getElementById('loiPass').innerText = "";
            //     document.getElementById('loiPass').style.display = 'none'; // Ẩn đi khi không có lỗi
            // }

            if (isValid) {
                document.getElementById("signup-form").submit();
            }
           
        });
    </script>
</body>

</html>