<div>
  <div class="flex justify-center mb-6">
    <div id="loginTab"
         class="text-red-600 text-lg font-semibold cursor-pointer border-b-2 border-red-600 mr-8"
         onclick="switchTab('login')">Đăng nhập</div>
    <div id="registerTab"
         class="text-gray-600 text-lg font-medium border-b-2 border-transparent hover:border-gray-400 cursor-pointer"
         onclick="switchTab('register')">Đăng ký</div>
  </div>

  <form id="formdangnhap" name="login" action="" method="POST" class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
      <input name="user_telephone" type="tel" placeholder="Nhập số điện thoại"
             class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mt-1">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
      <div class="relative mt-1">
        <input name="user_password" type="password" id="passwordInput" placeholder="Nhập mật khẩu"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
        <button type="button" onclick="togglePassword()" id="toggleBtn"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 text-sm font-medium">Hiện</button>
      </div>
    </div>

    <button type="submit"
            name="login_submit"
            class="hover:bg-red-500 hover:text-white transition w-full bg-gray-300 text-gray-600 font-semibold py-2 rounded-lg">
      Đăng nhập
    </button>
    
    <?php
      if (isset($_POST['login_submit'])) {
    $phone = $_POST['user_telephone'];
    $password = $_POST['user_password'];

    $query = "SELECT * FROM users WHERE phoneNumber = '$phone'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($result && mysqli_num_rows($result) > 0) {
        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Sai mật khẩu!');</script>";
        }
    } else {
        echo "<script>alert('Sai số điện thoại!');</script>";
    }
}
?>
  </form>
  <form id="formdangki" onsubmit="return validateRegisterForm(event)" class="space-y-4 hidden" action="" method="post">
    <div>
      <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
      <input name="newuser_telephone" type="tel" placeholder="Nhập số điện thoại"
             class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mt-1">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
      <div class="relative mt-1">
        <input name="user_password" type="password" id="password" placeholder="Nhập mật khẩu"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
        <button type="button" onclick="togglePassword('password', 'togglePasswordBtn')" id="togglePasswordBtn"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 text-sm font-medium">Hiện</button>
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Nhập lại mật khẩu</label>
      <div class="relative mt-1">
        <input name="user_comfirm_password" type="password" id="confirmPassword" placeholder="Nhập lại mật khẩu"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
        <button type="button" onclick="togglePassword('confirmPassword', 'toggleConfirmBtn')" id="toggleConfirmBtn"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 text-sm font-medium">Hiện</button>
      </div>
    </div>
    <button type="submit"
            name="submit_register"
            class="hover:bg-red-500 hover:text-white transition w-full bg-gray-300 text-gray-600 font-semibold py-2 rounded-lg">
      Đăng ký
    </button>
  </form>
</div>
<?php
$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if (isset($_POST['submit_register'])){
$phone = $_POST['newuser_telephone'] ?? '';
$password = $_POST['user_password'] ?? '';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$check = $conn->prepare("SELECT id FROM users WHERE phoneNumber = ?");
$check->bind_param("s", $phone);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "Số điện thoại đã tồn tại.";
    exit;
}
$stmt = $conn->prepare("INSERT INTO users (phoneNumber, password, fullName) VALUES (?, ?, ?)");
$fullName = 'New user';
$stmt->bind_param("sss", $phone, $hashedPassword, $fullName);
$stmt->execute();
$stmt->close();
$conn->close();
}
?>
