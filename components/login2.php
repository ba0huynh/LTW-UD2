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
            class="hover:bg-red-500 hover:text-white transition w-full bg-gray-300 text-gray-600 font-semibold py-2 rounded-lg">
      Đăng nhập
    </button>
    <?php
// Kết nối đến database
$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start(); // Bắt đầu session

// Lấy thông tin đăng nhập từ form
$phone = $_POST['user_telephone'] ?? '';
$password = $_POST['user_password'] ?? '';

// Kiểm tra số điện thoại và mật khẩu không rỗng
if (empty($phone) || empty($password)) {
    echo "Số điện thoại và mật khẩu không được để trống.";
    exit;
}

// Kiểm tra xem số điện thoại có tồn tại trong cơ sở dữ liệu không
$query = $conn->prepare("SELECT id, password FROM users WHERE phoneNumber = ?");
$query->bind_param("s", $phone);
$query->execute();
$query->store_result();

// Nếu số điện thoại tồn tại
if ($query->num_rows > 0) {
    $query->bind_result($user_id, $hashedPassword);
    $query->fetch();
    
    // Kiểm tra mật khẩu
    if (password_verify($password, $hashedPassword)) {
        // Đăng nhập thành công, lưu thông tin vào session
        $_SESSION['user_id'] = $user_id; // Lưu user_id vào session
        echo "Đăng nhập thành công!";
        // Chuyển hướng đến trang chính hoặc trang nào đó
        header("Location: index.php");
        exit;
    } else {
        // Mật khẩu không chính xác
        echo "Mật khẩu không chính xác.";
    }
} else {
    // Số điện thoại không tồn tại
    echo "Số điện thoại không tồn tại.";
}

$query->close();
$conn->close();
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

$phone = $_POST['newuser_telephone'] ?? '';
$password = $_POST['user_password'] ?? '';

// Mã hóa mật khẩu
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Kiểm tra xem số điện thoại đã tồn tại chưa
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
?>
