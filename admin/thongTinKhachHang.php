<?php
// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle add customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $fullName = trim($_POST['fullName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $email = trim($_POST['email']);
    $password = password_hash('default123', PASSWORD_DEFAULT); // Default password
    $avatar = $_FILES['avatar']['name'];
    $status_user = $_POST['status_user'];
    
    // Validate input
    if (empty($fullName) || empty($phoneNumber) || empty($email)) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!');</script>";
    } else {
        // Handle avatar upload
        if (!empty($avatar)) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($avatar);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
        } else {
            $avatar = 'https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png';
        }
        
        // Insert into users table
        $sql = "INSERT INTO users (userName, fullName, phoneNumber, email, password, avatar, status_user) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $userName = $email; // Use email as username
        $stmt->bind_param("ssssssi", $userName, $fullName, $phoneNumber, $email, $password, $avatar, $status_user);
        if ($stmt->execute()) {
            echo "<script>alert('Thêm khách hàng thành công!'); window.location.href='customer_management.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi thêm khách hàng!');</script>";
        }
    }
}

// Handle delete customer
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM users WHERE id = ? AND role_id IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa khách hàng thành công!'); window.location.href='customer_management.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa khách hàng!');</script>";
    }
}

// Query customers with search and pagination
$search_query = $search ? "WHERE fullName LIKE ? OR phoneNumber LIKE ?" : "";
$sql = "SELECT id, fullName, phoneNumber, avatar, status_user FROM users WHERE role_id IS NULL $search_query LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($search) {
    $search_term = "%$search%";
    $stmt->bind_param("ssii", $search_term, $search_term, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
$customers = $result->fetch_all(MYSQLI_ASSOC);

// Count total customers for pagination
$sql_count = "SELECT COUNT(*) as total FROM users WHERE role_id IS NULL $search_query";
$stmt_count = $conn->prepare($sql_count);
if ($search) {
    $stmt_count->bind_param("ss", $search_term, $search_term);
}
$stmt_count->execute();
$total_customers = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_customers / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý khách hàng</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .kh-container {
            width: 90%;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .kh-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .kh-filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .kh-display-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .kh-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: bold;
        }

        .kh-input-number,
        .kh-input-text {
            width: 60px;
            padding: 6px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .kh-input-text {
            width: 150px;
        }

        .kh-search-box {
            margin-left: auto;
        }

        .kh-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kh-th {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .kh-td {
            font-size: 14px;
            background-color: #f8f9fa;
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .kh-avatar-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .kh-empty-row {
            background-color: #f1f1f1;
            font-weight: bold;
            color: #6c757d;
            text-align: center;
        }

        .kh-pagination {
            display: flex;
            justify-content: right;
            margin-top: 10px;
        }

        .kh-pagination-btn {
            border: 1px solid #ccc;
            background-color: white;
            color: #333;
            padding: 6px 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 50%;
            margin: 0 5px;
        }

        .kh-pagination-btn:hover {
            background-color: #ddd;
        }

        .kh-form-container {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .kh-form-group {
            margin-bottom: 10px;
        }

        .kh-form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kh-form-group input,
        .kh-form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .kh-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }

        .kh-btn:hover {
            background-color: #0056b3;
        }

        .kh-action-btn {
            padding: 6px 12px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .kh-edit-btn {
            background-color: #28a745;
        }

        .kh-edit-btn:hover {
            background-color: #218838;
        }

        .kh-delete-btn {
            background-color: #dc3545;
        }

        .kh-delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="kh-container">
    <h2 class="kh-title">Thông tin khách hàng</h2>

    <!-- Form to add new customer -->
    <div class="kh-form-container">
        <h3>Thêm khách hàng mới</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="kh-form-group">
                <label for="fullName">Họ và tên</label>
                <input type="text" name="fullName" id="fullName" required>
            </div>
            <div class="kh-form-group">
                <label for="phoneNumber">Số điện thoại</label>
                <input type="text" name="phoneNumber" id="phoneNumber" required>
            </div>
            <div class="kh-form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="kh-form-group">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>
            <div class="kh-form-group">
                <label for="status_user">Tình trạng</label>
                <select name="status_user" id="status_user" required>
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng hoạt động</option>
                </select>
            </div>
            <button type="submit" name="add_customer" class="kh-btn">Thêm khách hàng</button>
        </form>
    </div>

    <!-- Filter and search -->
    <div class="kh-filter-container">
        <div class="kh-display-control">
            <label class="kh-label" for="kh-show-number">Hiển thị</label>
            <input type="number" class="kh-input-number kh-show-number" id="kh-show-number" value="<?php echo $limit; ?>" min="1" onchange="updateLimit()">
            <span class="kh-label">dòng</span>
        </div>
        <div class="kh-search-box">
            <label class="kh-label" for="kh-search-input">Tìm kiếm</label>
            <input type="text" class="kh-input-text kh-search-input" id="kh-search-input" value="<?php echo htmlspecialchars($search); ?>" onkeyup="if(event.keyCode==13) searchCustomers()">
        </div>
    </div>

    <!-- Customer table -->
    <table class="kh-table">
        <thead>
            <tr>
                <th class="kh-th">Tên</th>
                <th class="kh-th">Số điện thoại</th>
                <th class="kh-th">Avatar</th>
                <th class="kh-th">Tình trạng</th>
                <th class="kh-th">Hành động</th>
            </tr>
        </thead>
        <tbody class="kh-tbody">
            <?php if (empty($customers)): ?>
                <tr class="kh-empty-row">
                    <td colspan="5">Không tìm thấy khách hàng</td>
                </tr>
            <?php else: ?>
                <?php foreach ($customers as $customer): ?>
                    <tr class="kh-tr">
                        <td class="kh-td"><?php echo htmlspecialchars($customer['fullName']); ?></td>
                        <td class="kh-td"><?php echo htmlspecialchars($customer['phoneNumber']); ?></td>
                        <td class="kh-td">
                            <img class="kh-avatar-img" src="<?php echo htmlspecialchars($customer['avatar']); ?>" alt="Avatar">
                        </td>
                        <td class="kh-td"><?php echo $customer['status_user'] ? 'Đang hoạt động' : 'Ngừng hoạt động'; ?></td>
                        <td class="kh-td">
                            <a href="edit_customer.php?id=<?php echo $customer['id']; ?>" class="kh-action-btn kh-edit-btn">Sửa</a>
                            <a href="?delete=<?php echo $customer['id']; ?>" class="kh-action-btn kh-delete-btn" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="kh-pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>" class="kh-pagination-btn">«</a>
        <?php else: ?>
            <button class="kh-pagination-btn" disabled>«</button>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>" class="kh-pagination-btn">»</a>
        <?php else: ?>
            <button class="kh-pagination-btn" disabled>»</button>
        <?php endif; ?>
    </div>
</div>

<script>
function updateLimit() {
    const limit = document.getElementById('kh-show-number').value;
    if (limit < 1) return;
    window.location.href = `?page=1&limit=${limit}&search=<?php echo urlencode($search); ?>`;
}

function searchCustomers() {
    const search = document.getElementById('kh-search-input').value;
    window.location.href = `?page=1&limit=<?php echo $limit; ?>&search=${encodeURIComponent(search)}`;
}
</script>

<?php
$conn->close();
?>
</body>
</html>