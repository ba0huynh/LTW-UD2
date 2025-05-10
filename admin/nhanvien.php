<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "ltw_ud2");
if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);

// Process edit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $vai_tro = $_POST['vai_tro'];
    $ten = $_POST['ten_nhan_vien'];
    $luong = $_POST['muc_luong'];
    $ngay = date('Y-m-d');

    $stmt = $conn->prepare("UPDATE NhanVien SET vai_tro=?, ten_nhan_vien=?, muc_luong=?, ngay_chinh_sua=? WHERE id=?");
    $stmt->bind_param("ssdsi", $vai_tro, $ten, $luong, $ngay, $id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
    exit;
}

// Process delete (GET)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM NhanVien WHERE id = $id")) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
    exit;
}

// Get employee data
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$search_condition = '';
if (!empty($search)) {
    $search_condition = " WHERE ten_nhan_vien LIKE '%$search%' OR vai_tro LIKE '%$search%'";
}

$result = $conn->query("SELECT * FROM NhanVien$search_condition ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        
        .employee-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .employee-table th {
            background-color: #0d507c;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 1rem;
            letter-spacing: 0.05em;
            text-align: left;
        }
        
        .employee-table tbody tr:hover {
            background-color: rgba(13, 80, 124, 0.05);
        }
        
        .employee-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        
        .employee-table tr:last-child td {
            border-bottom: none;
        }
        
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
            display: inline-block;
            text-align: center;
            white-space: nowrap;
        }
        
        .badge-blue {
            background-color: #ebf5ff;
            color: #0d507c;
        }
        
        .badge-green {
            background-color: #ecfdf5;
            color: #047857;
        }
        
        .badge-purple {
            background-color: #f5f3ff;
            color: #6d28d9;
        }
        
        .badge-orange {
            background-color: #fff7ed;
            color: #c2410c;
        }
        
        .badge-red {
            background-color: #fef2f2;
            color: #b91c1c;
        }
        
        .badge-gray {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .btn {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        
        .btn-blue {
            background-color: #0d507c;
            color: white;
        }
        
        .btn-blue:hover {
            background-color: #0c4366;
        }
        
        .btn-red {
            background-color: #ef4444;
            color: white;
        }
        
        .btn-red:hover {
            background-color: #dc2626;
        }
        
        .btn-gray {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .btn-gray:hover {
            background-color: #d1d5db;
        }
        
        /* Modal animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .animate-fade {
            animation: fadeIn 0.3s ease forwards;
        }
        
        .animate-slide {
            animation: slideIn 0.3s ease forwards;
        }
        
        /* Search bar styling */
        .search-container {
            position: relative;
        }
        
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .search-input {
            padding: 0.625rem 0.75rem 0.625rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            width: 100%;
            transition: border-color 0.15s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #0d507c;
            box-shadow: 0 0 0 3px rgba(13, 80, 124, 0.1);
        }
        
        /* Custom tooltip */
        .tooltip {
            position: relative;
        }
        
        .tooltip:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.25rem 0.5rem;
            background-color: #1f2937;
            color: white;
            font-size: 0.75rem;
            border-radius: 0.25rem;
            white-space: nowrap;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 10;
        }
        
        .tooltip:hover:before {
            visibility: visible;
            opacity: 1;
        }
        
        /* Page title */
        .page-title {
            position: relative;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            font-weight: 600;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 50px;
            background-color: #0d507c;
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .employee-table td, .employee-table th {
                padding: 0.75rem 0.5rem;
            }
            
            .employee-table th:nth-child(3), 
            .employee-table td:nth-child(3),
            .employee-table th:nth-child(4), 
            .employee-table td:nth-child(4) {
                display: none;
            }
            
            .btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <main class="flex flex-row min-h-screen bg-gray-50">
        <!-- Include Sidebar -->
        <?php include_once './gui/sidebar.php' ?>
        
        <!-- Main Content Area -->
        <div class="flex-1 h-screen overflow-y-scroll p-4 md:p-6 lg:p-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 page-title">Quản lý nhân viên</h1>
                    <p class="text-gray-600 mt-2">Xem, thêm, sửa và quản lý thông tin nhân viên</p>
                </div>
                
                <!-- Tools Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <!-- Search -->
                        <div class="search-container w-full md:w-auto md:min-w-[300px]">
                            <span class="search-icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <input 
                                type="text" 
                                id="searchInput" 
                                placeholder="Tìm kiếm theo tên hoặc vai trò..." 
                                class="search-input"
                            >
                        </div>
                        
                        <!-- Add Button -->
                        <button class="btn btn-blue" onclick="openAddPopup()">
                            <i class="fas fa-plus mr-2"></i>
                            Thêm nhân viên mới
                        </button>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user-tag mr-2"></i>Vai trò</th>
                                    <th><i class="fas fa-user mr-2"></i>Tên nhân viên</th>
                                    <th><i class="fas fa-calendar-plus mr-2"></i>Ngày tạo</th>
                                    <th><i class="fas fa-calendar-check mr-2"></i>Ngày chỉnh sửa</th>
                                    <th><i class="fas fa-money-bill-wave mr-2"></i>Mức lương</th>
                                    <th><i class="fas fa-cogs mr-2"></i>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="employeeTableBody">
                                <?php 
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()): 
                                        // Assign badge color based on role
                                        $badge_class = 'badge-gray';
                                        switch(strtolower($row["vai_tro"])) {
                                            case 'quản lý': $badge_class = 'badge-blue'; break;
                                            case 'nhân viên bán hàng': $badge_class = 'badge-green'; break;
                                            case 'kế toán': $badge_class = 'badge-purple'; break;
                                            case 'nhân viên kho': 
                                            case 'thủ kho': $badge_class = 'badge-orange'; break;
                                            case 'it support': $badge_class = 'badge-red'; break;
                                        }
                                ?>
                                <tr id="row-<?= $row['id'] ?>">
                                    <td>
                                        <span class="badge <?= $badge_class ?>">
                                            <?= htmlspecialchars($row["vai_tro"]) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-medium text-gray-800">
                                            <?= htmlspecialchars($row["ten_nhan_vien"]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm text-gray-600">
                                            <?= date('d/m/Y', strtotime($row["ngay_tao"])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm text-gray-600">
                                            <?= date('d/m/Y', strtotime($row["ngay_chinh_sua"])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-medium text-gray-900">
                                            <?= number_format($row["muc_luong"], 0, ',', '.') ?> ₫
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex space-x-2">
                                            <button 
                                                class="btn btn-blue tooltip" 
                                                data-tooltip="Chỉnh sửa"
                                                onclick='openEditPopup(<?= json_encode($row) ?>)'
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button 
                                                class="btn btn-red tooltip" 
                                                data-tooltip="Xóa"
                                                onclick='deleteNhanVien(<?= $row["id"] ?>)'
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-user-slash text-4xl mb-3 text-gray-300"></i>
                                            <p>Không tìm thấy nhân viên nào</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Popup overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden animate-fade"></div>

    <!-- Edit Popup -->
    <div id="editPopup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-2xl z-50 w-full max-w-md hidden animate-slide">
        <div class="p-5 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Chỉnh sửa thông tin nhân viên</h3>
                <button onclick="closePopup()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <form id="editForm" class="p-5">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="action" value="edit">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="edit-vai-tro">
                    Vai trò
                </label>
                <select 
                    name="vai_tro" 
                    id="edit-vai-tro"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="Quản lý">Quản lý</option>
                    <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
                    <option value="Kế toán">Kế toán</option>
                    <option value="Bảo vệ">Bảo vệ</option>
                    <option value="Tạp vụ">Tạp vụ</option>
                    <option value="Nhân viên kho">Nhân viên kho</option>
                    <option value="Thủ kho">Thủ kho</option>
                    <option value="Lễ tân">Lễ tân</option>
                    <option value="IT support">IT support</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="edit-ten">
                    Tên nhân viên
                </label>
                <input 
                    type="text" 
                    name="ten_nhan_vien" 
                    id="edit-ten"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="edit-luong">
                    Mức lương (VNĐ)
                </label>
                <input 
                    type="number" 
                    name="muc_luong" 
                    id="edit-luong"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    min="0"
                    step="100000"
                    required
                >
            </div>
            
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closePopup()" 
                    class="btn btn-gray"
                >
                    Hủy
                </button>
                <button 
                    type="submit" 
                    class="btn btn-blue"
                >
                    <i class="fas fa-save mr-2"></i>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>

    <!-- Add Employee Popup -->
    <div id="addPopup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-2xl z-50 w-full max-w-md hidden animate-slide">
        <div class="p-5 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Thêm nhân viên mới</h3>
                <button onclick="closePopup()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <form id="addForm" class="p-5">
            <input type="hidden" name="action" value="add">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="add-vai-tro">
                    Vai trò
                </label>
                <select 
                    name="vai_tro" 
                    id="add-vai-tro"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="Quản lý">Quản lý</option>
                    <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
                    <option value="Kế toán">Kế toán</option>
                    <option value="Bảo vệ">Bảo vệ</option>
                    <option value="Tạp vụ">Tạp vụ</option>
                    <option value="Nhân viên kho">Nhân viên kho</option>
                    <option value="Thủ kho">Thủ kho</option>
                    <option value="Lễ tân">Lễ tân</option>
                    <option value="IT support">IT support</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="add-ten">
                    Tên nhân viên
                </label>
                <input 
                    type="text" 
                    name="ten_nhan_vien" 
                    id="add-ten"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="add-luong">
                    Mức lương (VNĐ)
                </label>
                <input 
                    type="number" 
                    name="muc_luong" 
                    id="add-luong"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    min="0"
                    step="100000"
                    required
                >
            </div>
            
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closePopup()" 
                    class="btn btn-gray"
                >
                    Hủy
                </button>
                <button 
                    type="submit" 
                    class="btn btn-blue"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Thêm nhân viên
                </button>
            </div>
        </form>
    </div>

    <script>
        // Open edit popup
        function openEditPopup(data) {
            document.getElementById("edit-id").value = data.id;
            document.getElementById("edit-vai-tro").value = data.vai_tro;
            document.getElementById("edit-ten").value = data.ten_nhan_vien;
            document.getElementById("edit-luong").value = data.muc_luong;
            
            document.getElementById("overlay").style.display = "block";
            document.getElementById("editPopup").style.display = "block";
        }
        
        // Open add popup
        function openAddPopup() {
            // Reset form
            document.getElementById("addForm").reset();
            
            document.getElementById("overlay").style.display = "block";
            document.getElementById("addPopup").style.display = "block";
        }
        
        // Close all popups
        function closePopup() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("editPopup").style.display = "none";
            document.getElementById("addPopup").style.display = "none";
        }
        
        // Handle edit form submission
        document.getElementById("editForm").onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: "nhanvien.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.includes("success")) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Cập nhật thông tin nhân viên thành công',
                            icon: 'success',
                            confirmButtonText: 'Đóng'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi: ' + response,
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi gửi yêu cầu',
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });
                }
            });
        };
        
        // Add employee form handler
        document.getElementById("addForm").onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: "them_nhanvien.php", // Create this file to handle adding employees
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.includes("success")) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Thêm nhân viên mới thành công',
                            icon: 'success',
                            confirmButtonText: 'Đóng'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi: ' + response,
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi gửi yêu cầu',
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });
                }
            });
        };
        
        // Delete employee
        function deleteNhanVien(id) {
            Swal.fire({
                title: 'Xác nhận xóa?',
                text: "Bạn không thể hoàn tác hành động này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "nhanvien.php?delete=" + id,
                        type: "GET",
                        success: function(response) {
                            if (response.includes("success")) {
                                Swal.fire(
                                    'Đã xóa!',
                                    'Nhân viên đã được xóa thành công.',
                                    'success'
                                );
                                document.getElementById("row-" + id).remove();
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    'Đã xảy ra lỗi: ' + response,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi khi gửi yêu cầu.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            filterEmployees(searchTerm);
        });
        
        function filterEmployees(searchTerm) {
            const rows = document.querySelectorAll('#employeeTableBody tr');
            
            rows.forEach(row => {
                const roleContent = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const nameContent = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (roleContent.includes(searchTerm) || nameContent.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show "no results" message if needed
            const visibleRows = document.querySelectorAll('#employeeTableBody tr[style=""]').length;
            const noResultsRow = document.getElementById('noResultsRow');
            
            if (visibleRows === 0) {
                if (!noResultsRow) {
                    const tbody = document.getElementById('employeeTableBody');
                    const newRow = document.createElement('tr');
                    newRow.id = 'noResultsRow';
                    newRow.innerHTML = `
                        <td colspan="6" class="text-center py-8 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-search text-4xl mb-3 text-gray-300"></i>
                                <p>Không tìm thấy kết quả phù hợp</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        }
        
        // Close popups when clicking outside
        document.getElementById("overlay").addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });
        
        // Close popups with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                closePopup();
            }
        });
    </script>
</body>
</html>