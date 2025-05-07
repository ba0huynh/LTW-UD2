<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"  && !isset($_POST['login'])) {
    $phone = $_POST['user_telephone'];
    $password = $_POST['user_password'];

    $query = "SELECT * FROM users WHERE phoneNumber = '$phone'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($result && mysqli_num_rows($result) > 0 && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"]; // Lưu session
        header("Location: index.php"); // Redirect sang trang chính
        exit;
    } else {
        $error = "Sai số điện thoại hoặc mật khẩu!";
    }
}
?>




<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old = $_POST['user_old_password'] ?? '';
    $new = $_POST['user_new_password'] ?? '';
    $confirm = $_POST['user_confirm_new_password'] ?? '';

    // Kiểm tra rỗng
    if (empty($old) || empty($new) || empty($confirm)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
    } elseif ($new !== $confirm) {
        echo "<script>alert('Mật khẩu mới và nhập lại không khớp.');</script>";
    } else {
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($old, $user['password'])) {
            $hashedNewPassword = password_hash($new, PASSWORD_DEFAULT);

            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashedNewPassword, $user_id);

            if ($update_stmt->execute()) {
                echo "<script>alert('Cập nhật mật khẩu thành công!'); window.location.href='account.php';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật mật khẩu.');</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu hiện tại không đúng.');</script>";
        }
    }
}
*/
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatePassword'])) {
    $old_pass = $_POST['user_old_password'] ?? '';
    $new_pass = $_POST['user_new_password'] ?? '';
    $confirm_pass = $_POST['user_confirm_new_password'] ?? '';
    if (empty($old_pass) || empty($new_pass) || empty($confirm_pass)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.');  window.history.back();</script>";
        exit();
    }

    // Lấy mật khẩu từ DB
    $query = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];
        // Kiểm tra mật khẩu cũ
        if (!password_verify($old_pass, $db_password)) {
            var_dump($user_id, $old_pass, $db_password);
            echo "<script>alert('Mật khẩu hiện tại không đúng! $old_pass $db_password');  window.history.back();</script>";
            exit();
        } elseif ($new_pass !== $confirm_pass) {
            echo "<script>alert('Mật khẩu mới không khớp!');  window.history.back();</script>";
            exit();
        } elseif (strlen($new_pass) < 6) {
            echo "<script>alert('Mật khẩu mới phải có ít nhất 6 ký tự.');  window.history.back();</script>";
            exit();
        } else {
            // Hash mật khẩu mới
            $new_hashed = password_hash($new_pass, PASSWORD_DEFAULT);

            // Update vào DB
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update_sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $new_hashed, $user_id);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Đổi mật khẩu thành công!'); window.history.back();</script>";
                    exit();
                } else {
                    echo "<script>alert('Lỗi khi cập nhật mật khẩu.');  window.history.back();</script>";
                    exit();
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Không thể chuẩn bị câu truy vấn.');  window.history.back();</script>";
                exit();
            }
        }
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    $fields = [];
    $values = [];
    $types = '';

    $userName = trim($_POST['userName']) ?? '';
    $fullName = trim($_POST['fullName']) ?? '';
    $phoneNumber = trim($_POST['phoneNumber']) ?? '';
    $date = trim($_POST['dateOfBirth']) ?? '';
    $month = trim($_POST['monthOfBirth']) ?? '';
    $year = trim($_POST['yearOfBirth']) ?? '';

    if (!empty($userName)) {
        $fields[] = "userName = ?";
        $values[] = $userName;
        $types .= 's';
    }

    if (!empty($fullName)) {
        $fields[] = "fullName = ?";
        $values[] = $fullName;
        $types .= 's';
    }

    if (!empty($phoneNumber)) {
        $fields[] = "phoneNumber = ?";
        $values[] = $phoneNumber;
        $types .= 's';
    }

    if (!empty($date) && !empty($month) && !empty($year)) {
        // Format date: YYYY-MM-DD
        $dob = sprintf("%04d-%02d-%02d", intval($year), intval($month), intval($date));
        $fields[] = "dateOfBirth = ?";
        $values[] = $dob;
        $types .= 's';
    }

    if (count($fields) > 0) {
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
        $types .= 'i';
        $values[] = $user_id;

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Cập nhật thông tin thành công!');  </script>";
                exit();
            } else {
                echo "<script>alert('Lỗi khi cập nhật: " . mysqli_stmt_error($stmt) . "');  window.history.back();</script>";
                exit();
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Lỗi chuẩn bị truy vấn: " . mysqli_error($conn) . "');  window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Không có trường nào để cập nhật.');  window.history.back();</script>";
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <!-- Tailwindcss -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body>

    <?php
    include_once "./components/header2.php";
    if (isset($_SESSION["user_id"])) {
        include_once "./components/changeInforUser.php";
    } else {
        include_once "./components/login2.php";
    }
    include_once "./components/footer.php";
    ?>
    <script>
        function showForm(formClass) {
            const mainForm = document.querySelector('.mainForm');
            const changePass = document.querySelector('.changePass');

            if (formClass === 'mainForm') {
                mainForm.classList.remove('hidden');
                changePass.classList.add('hidden');
            } else if (formClass === 'changePass') {
                changePass.classList.remove('hidden');
                mainForm.classList.add('hidden');
            }
        }
    </script>
</body>

</html>