<?php
$isLogin = true;
?>

<div class="container">
    <div class="form-box">
        <!-- Tabs -->
        <div class="tab">
            <button id="loginTab" class="active" onclick="toggleTab(true)">Đăng nhập</button>
            <button id="registerTab" onclick="toggleTab(false)">Đăng ký</button>
        </div>

        <!-- Form Đăng nhập -->
        <form id="loginForm">
            <label for="loginAccount">Số điện thoại hoặc email</label>
            <input id="loginAccount" type="text" name="loginAccount" placeholder="Nhập số điện thoại hoặc email">

            <label for="loginPassword">Nhập mật khẩu</label>
            <div class="password-wrapper">
                <input id="loginPassword" type="password" name="loginPassword" placeholder="Nhập mật khẩu">
                <span id="toggleLoginPassword" class="toggle-password" onclick="togglePassword('loginPassword', 'toggleLoginPassword')">Hiện</span>
            </div>

            <span class="forgot-password">Quên mật khẩu?</span>
            <input type="submit" value="Đăng nhập">
        </form>

        <!-- Form Đăng ký -->
        <form id="registerForm" style="display: none;">
            <label for="registerAccount">Số điện thoại hoặc email</label>
            <div class="otp-wrapper">
                <input id="registerAccount" type="text" name="registerAccount" placeholder="Nhập số điện thoại hoặc email">
                <span class="send-otp">Gửi OTP</span>
            </div>

            <label for="otp">Nhập mã OTP</label>
            <input id="otp" type="text" name="otp" placeholder="Nhập mã OTP">

            <label for="registerPassword">Nhập mật khẩu</label>
            <div class="password-wrapper">
                <input id="registerPassword" type="password" name="registerPassword" placeholder="Nhập mật khẩu">
                <span id="toggleRegisterPassword" class="toggle-password" onclick="togglePassword('registerPassword', 'toggleRegisterPassword')">Hiện</span>
            </div>

            <input type="submit" value="Đăng ký">
        </form>
    </div>
</div>
<style>
.container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 350px;
}

.tab {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.tab > button {
    width: 50%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #eee;
}

.tab > button.active {
    border-bottom: 2px solid red;
    background-color: white;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.password-wrapper, .otp-wrapper {
    position: relative;
}

.toggle-password, .send-otp {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: blue;
    font-size: 14px;
}


.forgot-password {
    display: block;
    margin-top: 10px;
    color: blue;
    cursor: pointer;
}
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: none;
    border-radius: 10px;
    background-color: red;
    color: white;
    cursor: pointer;
}
input:focus {
    border: 1px solid red; 
    outline: none;
    box-shadow: 0 0 5px red; 
    transition: all 0.3s ease-in-out;
}

</style>
<script>
    function toggleTab(isLogin) {
        document.getElementById("loginForm").style.display = isLogin ? "block" : "none";
        document.getElementById("registerForm").style.display = isLogin ? "none" : "block";
        // Thêm/xóa class active cho tabs
        document.getElementById("loginTab").classList.toggle("active", isLogin);
        document.getElementById("registerTab").classList.toggle("active", !isLogin);
    }
    function togglePassword(inputId, toggleBtnId) {
        let passwordInput = document.getElementById(inputId);
        let toggleBtn = document.getElementById(toggleBtnId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleBtn.innerText = "Ẩn";
        } else {
            passwordInput.type = "password";
            toggleBtn.innerText = "Hiện";
        }
    }
</script>
