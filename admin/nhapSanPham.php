<?php 
session_start();
?>

<?php
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

// Initialize session for storing temporary import list
if (!isset($_SESSION['import_list'])) {
    $_SESSION['import_list'] = [];
}

// Get list of books and suppliers
$books_query = "SELECT id, bookName, classNumber, currentPrice, imageURL FROM books WHERE isActive = 1";
$books_result = $conn->query($books_query);
$books = $books_result->fetch_all(MYSQLI_ASSOC);

$suppliers_query = "SELECT id, name FROM nhacungcap";
$suppliers_result = $conn->query($suppliers_query);
$suppliers = $suppliers_result->fetch_all(MYSQLI_ASSOC);

// Handle form submission for adding to import list
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_list'])) {
    $book_id = intval($_POST['book_id']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $image = $_FILES['image']['name'];
    
    // Find selected book
    $selected_book = null;
    foreach ($books as $book) {
        if ($book['id'] == $book_id) {
            $selected_book = $book;
            break;
        }
    }
    
    // Validate input
    if (!$selected_book) {
        echo "<script>alert('Vui lòng chọn sách!');</script>";
    } elseif ($price <= 0) {
        echo "<script>alert('Giá nhập phải lớn hơn 0!');</script>";
    } elseif ($quantity <= 0) {
        echo "<script>alert('Số lượng phải lớn hơn 0!');</script>";
    } else {
        // Handle image upload
        if (!empty($image)) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            $image = $selected_book['imageURL'];
        }
        
        // Calculate total
        $total = $price * $quantity;
        
        // Add to session import list
        $_SESSION['import_list'][] = [
            'book_id' => $book_id,
            'book_name' => $selected_book['bookName'],
            'class_number' => $selected_book['classNumber'],
            'price' => $price,
            'quantity' => $quantity,
            'total' => $total,
            'image' => $image
        ];
        
        echo "<script>alert('Thêm sách vào danh sách thành công!');</script>";
    }
}

// Handle form submission for final import
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['import'])) {
    $import_code = trim($_POST['import_code']);
    $import_date = $_POST['import_date'];
    $supplier_id = intval($_POST['supplier']);
    $idNguoiNhap = 1; // Hard-code idNguoiNhap as 1 (Admin), update if needed
    $total = array_sum(array_column($_SESSION['import_list'], 'total'));
    
    if (empty($import_code)) {
        echo "<script>alert('Vui lòng nhập mã phiếu nhập!');</script>";
    } elseif (empty($supplier_id)) {
        echo "<script>alert('Vui lòng chọn nhà cung cấp!');</script>";
    } elseif (empty($_SESSION['import_list'])) {
        echo "<script>alert('Danh sách nhập đang rỗng!');</script>";
    } else {
        // Insert into hoadonnhap table
        $sql = "INSERT INTO hoadonnhap (tongtien, idNguoiNhap, date, status) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dis", $total, $idNguoiNhap, $import_date);
        $stmt->execute();
        
        $import_id = $conn->insert_id;
        
        // Insert into chitietphieunhap table
        foreach ($_SESSION['import_list'] as $item) {
            $sql = "INSERT INTO chitietphieunhap (idPhieuNhap, idBook, idCungCap, soluong, gianhap) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiidd", $import_id, $item['book_id'], $supplier_id, $item['quantity'], $item['price']);
            $stmt->execute();
            
            // Update books quantity (assuming quantitySold as inventory)
            $sql = "UPDATE books SET quantitySold = quantitySold + ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $item['quantity'], $item['book_id']);
            $stmt->execute();
        }
        
        // Clear import list after successful import
        $_SESSION['import_list'] = [];
        
        echo "<script>alert('Nhập hàng thành công!'); window.location.href='nhapSanPham.php';</script>";
    }
}

// Handle item deletion from import list
if (isset($_GET['delete'])) {
    $index = intval($_GET['delete']);
    if (isset($_SESSION['import_list'][$index])) {
        unset($_SESSION['import_list'][$index]);
        $_SESSION['import_list'] = array_values($_SESSION['import_list']);
    }
    header("Location: nhapSanPham.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhập hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>

<main class="flex flex-row">
        <?php include_once './gui/sidebar.php' ?>
        <div class="flex items-center w-full h-screen justify-center" style="max-height: 100vh; overflow-y: scroll; padding-top:90px !important;">
            <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-6 w-[80%]" style="padding: 0;">

<div class="container">
    <h2>Nhập Phiếu Nhập</h2><br>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="flex-container">
            <div class="form-group">
                <label>Mã Phiếu Nhập</label>
                <input type="text" name="import_code" placeholder="Nhập mã phiếu nhập" value="<?php echo isset($_POST['import_code']) ? htmlspecialchars($_POST['import_code']) : ''; ?>" required>
            </div>
        
            <div class="form-group">
                <label>Ngày nhập</label>
                <input type="date" name="import_date" value="<?php echo isset($_POST['import_date']) ? htmlspecialchars($_POST['import_date']) : date('Y-m-d'); ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label>Tên sách</label>
            <select name="book_id" required>
                <option value="">-- Chọn sách --</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?php echo $book['id']; ?>" <?php echo isset($_POST['book_id']) && $_POST['book_id'] == $book['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($book['bookName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex-container">
            <div class="form-group">
                <label>Lớp</label>
                <input type="text" value="<?php echo isset($_POST['book_id']) && ($selected_book = array_filter($books, fn($b) => $b['id'] == $_POST['book_id'])) ? reset($selected_book)['classNumber'] : ''; ?>" disabled>
            </div>

            <div class="form-group">
                <label>Số lượng tồn kho</label>
                <input type="text" value="<?php echo isset($_POST['book_id']) && ($selected_book = array_filter($books, fn($b) => $b['id'] == $_POST['book_id'])) ? reset($selected_book)['quantitySold'] : '0'; ?>" disabled>
            </div>
        </div>

        <div class="flex-container">
            <div class="form-group">
                <label>Giá nhập</label>
                <input type="number" name="price" placeholder="Giá nhập" step="0.01" min="0" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Số lượng nhập</label>
                <input type="number" name="quantity" placeholder="Số lượng nhập" min="1" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : ''; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Hình ảnh (tùy chọn)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="but-Contain">
            <button type="submit" name="add_to_list" class="btn inButton">Thêm vào danh sách nhập</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sách</th>
                <th>Lớp</th>
                <th>Giá nhập</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['import_list'])): ?>
                <tr>
                    <td colspan="7" class="text-center">Chưa có mặt hàng nào</td>
                </tr>
            <?php else: ?>
                <?php foreach ($_SESSION['import_list'] as $index => $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" class="book-img" alt="Book Image"></td>
                        <td><?php echo htmlspecialchars($item['book_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['class_number']); ?></td>
                        <td><?php echo number_format($item['price'], 2); ?>đ</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['total'], 2); ?>đ</td>
                        <td>
                            <a href="?delete=<?php echo $index; ?>" class="btn button-red" 
                               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <form method="POST" action="">
        <div class="flex-container">
            <div class="form-group">
                <label>Nhà cung cấp</label>
                <select name="supplier" required>
                    <option value="">-- Chọn nhà cung cấp --</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?php echo $supplier['id']; ?>" <?php echo isset($_POST['supplier']) && $_POST['supplier'] == $supplier['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($supplier['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tổng tiền danh sách nhập</label>
                <input type="text" value="<?php 
                    $total = array_sum(array_column($_SESSION['import_list'], 'total'));
                    echo number_format($total, 2) . 'đ';
                ?>" disabled>
            </div>
        </div>
        
        <input type="hidden" name="import_code" value="<?php echo isset($_POST['import_code']) ? htmlspecialchars($_POST['import_code']) : ''; ?>">
        <input type="hidden" name="import_date" value="<?php echo isset($_POST['import_date']) ? htmlspecialchars($_POST['import_date']) : date('Y-m-d'); ?>">
        
        <div class="but-Contain">
            <button type="submit" name="import" class="btn button-red">Nhập hàng</button>
        </div>
    </form>
</div>

          </div>
            </div>
</main>
</body>
</html>

<?php
$conn->close();
?>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 800px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: xx-large;

        }
        .flex-container {
            display: flex;
            gap: 20px; 
        }
        
        .flex-container .form-group {
            flex: 1;
        }
        
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:disabled {
            background-color: #e9ecef;
        }

        .btn {
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .inButton {
            background-color: #007bff;
            color: white;
        }

        .inButton:hover {
            background-color: #0056b3;
        }

        .button-red {
            background-color: #dc3545;
            color: white;
        }

        .button-red:hover {
            background-color: #a71d2a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
        }

        .text-center {
            text-align: center;
        }
        .but-Contain {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .book-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>