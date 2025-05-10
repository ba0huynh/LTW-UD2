<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$success_message = '';
$error_message = '';

// Process form submission
if (isset($_POST['submit'])) {
    // Use prepared statements to prevent SQL injection
    $vai_tro = $_POST['vai_tro'];
    $ten_nhan_vien = $_POST['ten_nhan_vien'];
    $muc_luong = $_POST['muc_luong'];
    $ngay_tao = date('Y-m-d');
    $ngay_chinh_sua = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO NhanVien (vai_tro, ten_nhan_vien, ngay_tao, ngay_chinh_sua, muc_luong) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $vai_tro, $ten_nhan_vien, $ngay_tao, $ngay_chinh_sua, $muc_luong);

    if ($stmt->execute()) {
        $success_message = "Nhân viên đã được thêm thành công!";
    } else {
        $error_message = "Lỗi: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên mới | Hệ thống quản lý</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'slide-down': 'slideDown 0.4s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '40%': { transform: 'scale(1.05)', opacity: '1' },
                            '60%': { transform: 'scale(0.95)', opacity: '1' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'inner-soft': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
                    }
                }
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f9fafb;
        }
        
        /* Modern form inputs */
        .form-input {
            @apply w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition-all duration-200 shadow-inner-soft;
        }
        
        .form-label {
            @apply block text-gray-700 text-sm font-medium mb-2;
        }
        
        .btn-primary {
            @apply w-full py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg hover:from-primary-600 hover:to-primary-700 active:shadow-sm transform hover:-translate-y-0.5 active:translate-y-0;
        }
        
        .btn-secondary {
            @apply w-full py-3 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:bg-gray-50 hover:shadow active:bg-gray-100 transform hover:-translate-y-0.5 active:translate-y-0;
        }
        
        .card {
            @apply bg-white rounded-2xl shadow-soft overflow-hidden border border-gray-100;
        }
        
        .card-header {
            @apply p-5 md:p-6 border-b border-gray-100 bg-white;
        }
        
        .card-body {
            @apply p-5 md:p-6;
        }
        
        /* Custom checkbox and radio styles */
        input[type="checkbox"], input[type="radio"] {
            @apply h-5 w-5 border-2 border-gray-300 rounded checked:border-primary-500 checked:bg-primary-500 focus:ring-2 focus:ring-primary-200;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
        
        /* Floating labels */
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .floating-label input,
        .floating-label select {
            height: 64px;
            padding-top: 24px;
            padding-bottom: 8px;
        }
        
        .floating-label label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity .15s ease-in-out, transform .15s ease-in-out;
        }
        
        .floating-label input:focus-within ~ label,
        .floating-label input:not(:placeholder-shown) ~ label,
        .floating-label select:focus-within ~ label,
        .floating-label select:not([value=""]):not(:focus) ~ label {
            transform: translateY(-0.5rem) translateY(0.15rem) scale(0.85);
            padding-top: 0.6rem;
            color: #0ea5e9;
        }
        
        /* Badge styles */
        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        
        .badge-primary {
            @apply bg-primary-100 text-primary-800;
        }
        
        .badge-green {
            @apply bg-green-100 text-green-800;
        }
        
        .badge-orange {
            @apply bg-orange-100 text-orange-800;
        }
        
        .badge-red {
            @apply bg-red-100 text-red-800;
        }
        
        .badge-purple {
            @apply bg-purple-100 text-purple-800;
        }
        
        /* Glass morphism for special elements */
        .glassmorphism {
            @apply backdrop-blur-md bg-white/90 border border-white/20 shadow-md;
        }
        
        /* Decorative elements */
        .decoration-dots {
            background-image: radial-gradient(circle, #e5e7eb 1px, transparent 1px);
            background-size: 15px 15px;
        }
        
        .decoration-grid {
            background-image: linear-gradient(to right, #f3f4f6 1px, transparent 1px),
                              linear-gradient(to bottom, #f3f4f6 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-50 custom-scrollbar">
    <main class="flex flex-row min-h-screen">
        <!-- Include Sidebar -->
        <?php include_once './gui/sidebar.php' ?>
        
        <!-- Main Content Area -->
        <div class="flex-1 p-4 md:p-6 lg:p-8 relative h-screen overflow-y-scroll">
            <!-- Decorative elements - subtle background pattern -->
            <div class="decoration-dots absolute inset-0 opacity-50 pointer-events-none"></div>
            
            <!-- Container for content -->
            <div class="max-w-4xl mx-auto relative">
                <!-- Glassmorphism floating header on scroll -->
                <div class="sticky top-0 z-10 mb-5 glassmorphism py-3 px-4 rounded-xl flex items-center justify-between transform animate-fade-in">
                    <h2 class="font-semibold text-gray-800">Thêm nhân viên mới</h2>
                    
                    <div class="flex gap-2">
                        <a href="nhanvien.php" class="inline-flex items-center px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-arrow-left mr-1.5 text-gray-500"></i>
                            Quay lại
                        </a>
                        
                        <button form="addEmployeeForm" type="submit" name="submit" class="inline-flex items-center px-3 py-1.5 text-sm bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg shadow-sm hover:shadow text-white">
                            <i class="fas fa-save mr-1.5"></i>
                            Lưu
                        </button>
                    </div>
                </div>
                
                <!-- Breadcrumbs -->
                <nav class="flex mb-5 text-sm animate-fade-in" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="dashboard.php" class="inline-flex items-center text-gray-600 hover:text-primary-600">
                                <i class="fas fa-home mr-2 text-gray-400"></i>
                                Trang chủ
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 9 4-4-4-4"/>
                                </svg>
                                <a href="nhanvien.php" class="text-gray-600 hover:text-primary-600">
                                    Quản lý nhân viên
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="text-gray-500">Thêm nhân viên mới</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <!-- Header -->
                <div class="mb-8 animate-slide-up">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-primary-400 to-primary-600 w-12 h-12 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-user-plus text-white text-lg"></i>
                        </div>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Thêm nhân viên mới</h1>
                            <p class="text-gray-500 mt-1">Nhập thông tin chi tiết để tạo hồ sơ nhân viên mới</p>
                        </div>
                    </div>
                </div>
                
                <!-- Success message -->
                <?php if (!empty($success_message)): ?>
                <div id="successAlert" class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-green-100 border border-green-200 text-green-700 animate-bounce-in flex items-start">
                    <div class="bg-green-500 rounded-full p-1.5 shadow-sm">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-green-800">Thao tác thành công!</h3>
                        <p class="mt-1 text-sm text-green-600"><?= $success_message ?></p>
                        <p class="mt-2 text-xs text-green-600">
                            <i class="fas fa-clock mr-1"></i> Tự động chuyển hướng sau <span id="countdown">3</span> giây...
                        </p>
                    </div>
                    <button type="button" onclick="document.getElementById('successAlert').style.display='none'" class="ml-auto text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php endif; ?>
                
                <!-- Error message -->
                <?php if (!empty($error_message)): ?>
                <div id="errorAlert" class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-red-100 border border-red-200 text-red-700 animate-bounce-in flex items-start">
                    <div class="bg-red-500 rounded-full p-1.5 shadow-sm">
                        <i class="fas fa-exclamation text-white text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-red-800">Đã xảy ra lỗi!</h3>
                        <p class="mt-1 text-sm text-red-600"><?= $error_message ?></p>
                    </div>
                    <button type="button" onclick="document.getElementById('errorAlert').style.display='none'" class="ml-auto text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php endif; ?>
                
                <!-- Form Card -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Main Form -->
                    <div class="md:col-span-2 animate-scale-in">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-id-card text-primary-500 mr-2"></i>
                                    Thông tin nhân viên
                                </h2>
                            </div>
                            
                            <div class="card-body">
                                <form action="add_nhanvien.php" method="POST" id="addEmployeeForm">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                        <!-- Vai Tro -->
                                        <div class="floating-label md:col-span-1">
                                            <select name="vai_tro" id="vai_tro" class="form-input peer" required>
                                                <option value="" disabled selected></option>
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
                                            <label for="vai_tro" class="flex items-center text-gray-500 peer-focus:text-primary-500">
                                                <i class="fas fa-user-tag mr-2 text-sm"></i>
                                                Vai trò
                                            </label>
                                        </div>
                                        
                                        <!-- Ten nhan vien -->
                                        <div class="floating-label md:col-span-1">
                                            <input type="text" id="ten_nhan_vien" name="ten_nhan_vien" 
                                                   placeholder=" " class="form-input" required>
                                            <label for="ten_nhan_vien" class="flex items-center text-gray-500 peer-focus:text-primary-500">
                                                <i class="fas fa-user mr-2 text-sm"></i>
                                                Họ tên nhân viên
                                            </label>
                                        </div>
                                        
                                        <!-- Muc luong -->
                                        <div class="md:col-span-2">
                                            <label for="muc_luong" class="form-label flex items-center">
                                                <i class="fas fa-money-bill-wave text-primary-500 mr-2"></i>
                                                Mức lương (VNĐ)
                                            </label>
                                            
                                            <div class="relative group">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                    <span class="text-gray-500">₫</span>
                                                </div>
                                                <input type="text" inputmode="numeric" id="muc_luong" name="muc_luong"
                                                       placeholder="VD: 10,000,000" 
                                                       class="form-input pl-8 pr-20" required>
                                                <div class="absolute inset-y-0 right-0 flex items-center">
                                                    <span id="formatted-salary-text" class="text-gray-500 text-sm bg-gray-100 h-full px-3 flex items-center rounded-r-xl border-l border-gray-200">
                                                        0 VNĐ
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="mt-1.5 text-sm text-gray-500 flex items-center">
                                                <i class="fas fa-info-circle mr-1.5 text-primary-400"></i>
                                                Nhập mức lương cơ bản của nhân viên
                                            </p>
                                        </div>
                                        
                                        <!-- Work status and department section -->
                                        <div class="md:col-span-2 mt-3">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <label class="form-label flex items-center">
                                                        <i class="fas fa-briefcase text-primary-500 mr-2"></i>
                                                        Trạng thái làm việc
                                                    </label>
                                                    <div class="flex space-x-4 mt-2">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="work_status" value="full_time" class="text-primary-500 focus:ring-primary-400" checked>
                                                            <span class="ml-2 text-gray-700">Toàn thời gian</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="work_status" value="part_time" class="text-primary-500 focus:ring-primary-400">
                                                            <span class="ml-2 text-gray-700">Bán thời gian</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label class="form-label flex items-center">
                                                        <i class="fas fa-building text-primary-500 mr-2"></i>
                                                        Phòng ban
                                                    </label>
                                                    <select class="form-input" name="department">
                                                        <option value="">-- Chọn phòng ban --</option>
                                                        <option value="sale">Phòng kinh doanh</option>
                                                        <option value="accounting">Phòng kế toán</option>
                                                        <option value="hr">Phòng nhân sự</option>
                                                        <option value="it">Phòng IT</option>
                                                        <option value="warehouse">Kho vận</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Contact Information -->
                                        <div class="md:col-span-2 border-t border-gray-100 pt-5 mt-2">
                                            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                                                <i class="fas fa-address-card text-primary-500 mr-2"></i>
                                                Thông tin liên hệ
                                            </h3>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                                <div>
                                                    <label for="email" class="form-label flex items-center">
                                                        <i class="fas fa-envelope text-primary-400 mr-2 text-sm"></i>
                                                        Email
                                                    </label>
                                                    <input type="email" id="email" name="email" placeholder="email@example.com" class="form-input">
                                                </div>
                                                
                                                <div>
                                                    <label for="phone" class="form-label flex items-center">
                                                        <i class="fas fa-phone text-primary-400 mr-2 text-sm"></i>
                                                        Số điện thoại
                                                    </label>
                                                    <input type="tel" id="phone" name="phone" placeholder="0xxxxxxxxx" class="form-input">
                                                </div>
                                                
                                                <div class="md:col-span-2">
                                                    <label for="address" class="form-label flex items-center">
                                                        <i class="fas fa-map-marker-alt text-primary-400 mr-2 text-sm"></i>
                                                        Địa chỉ
                                                    </label>
                                                    <textarea id="address" name="address" rows="2" placeholder="Nhập địa chỉ liên hệ" class="form-input"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Form Actions - Mobile Only -->
                        <div class="mt-6 flex flex-col space-y-3 md:hidden">
                            <button type="submit" form="addEmployeeForm" name="submit" class="btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Thêm nhân viên
                            </button>
                            <a href="nhanvien.php" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                    
                    <!-- Sidebar Info Card -->
                    <div class="md:col-span-1 space-y-6 animate-slide-up">
                        <!-- Role Info Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-base font-semibold text-gray-800">
                                    <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                                    Thông tin vai trò
                                </h3>
                            </div>
                            <div class="card-body" id="role-info-content">
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-user-tag text-4xl mb-3 text-gray-300"></i>
                                    <p>Chọn vai trò để xem thông tin</p>
                                </div>
                                
                                <!-- Dynamic role information will be loaded here -->
                            </div>
                        </div>
                        
                        <!-- Tips Card -->
                        <div class="card bg-gradient-to-br from-primary-50 to-blue-50">
                            <div class="card-body">
                                <h3 class="font-semibold text-primary-800 flex items-center mb-3">
                                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                    Gợi ý
                                </h3>
                                <ul class="space-y-3 text-sm text-primary-700">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2"></i>
                                        <span>Nhập đầy đủ họ tên của nhân viên để dễ dàng tìm kiếm sau này.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2"></i>
                                        <span>Nhập lương chính xác và đầy đủ để tránh nhầm lẫn trong tính toán.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-primary-500 mt-1 mr-2"></i>
                                        <span>Thông tin liên hệ giúp dễ dàng kết nối với nhân viên khi cần.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Recent Employees Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-base font-semibold text-gray-800">
                                    <i class="fas fa-history text-primary-500 mr-2"></i>
                                    Nhân viên gần đây
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                <ul class="divide-y divide-gray-100">
                                    <?php
                                    // Get recent employees
                                    $recent_query = "SELECT id, ten_nhan_vien, vai_tro, ngay_tao FROM NhanVien ORDER BY ngay_tao DESC LIMIT 3";
                                    $recent_result = $conn->query($recent_query);
                                    
                                    if ($recent_result && $recent_result->num_rows > 0) {
                                        while ($row = $recent_result->fetch_assoc()) {
                                            // Determine badge class based on role
                                            $badge_class = 'badge-primary';
                                            switch(strtolower($row["vai_tro"])) {
                                                case 'quản lý': $badge_class = 'badge-primary'; break;
                                                case 'nhân viên bán hàng': $badge_class = 'badge-green'; break;
                                                case 'kế toán': $badge_class = 'badge-purple'; break;
                                                case 'nhân viên kho': 
                                                case 'thủ kho': $badge_class = 'badge-orange'; break;
                                                case 'it support': $badge_class = 'badge-red'; break;
                                            }
                                    ?>
                                    <li class="p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800"><?= htmlspecialchars($row["ten_nhan_vien"]) ?></p>
                                                <span class="badge <?= $badge_class ?> mt-1">
                                                    <?= htmlspecialchars($row["vai_tro"]) ?>
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-500">
                                                <?= date('d/m/Y', strtotime($row["ngay_tao"])) ?>
                                            </span>
                                        </div>
                                    </li>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <li class="p-4 text-center text-gray-500">
                                        <p>Chưa có nhân viên nào</p>
                                    </li>
                                    <?php } ?>
                                </ul>
                                
                                <div class="p-4 border-t border-gray-100 text-center">
                                    <a href="nhanvien.php" class="text-primary-600 hover:text-primary-700 font-medium text-sm inline-flex items-center">
                                        <span>Xem tất cả nhân viên</span>
                                        <svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions - Desktop Only -->
                        <div class="hidden md:flex md:flex-col md:space-y-3">
                            <button type="submit" form="addEmployeeForm" name="submit" class="btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Thêm nhân viên
                            </button>
                            <a href="nhanvien.php" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role information data
            const roleInfo = {
                'Quản lý': {
                    icon: 'fas fa-user-tie',
                    color: 'text-blue-600',
                    bgColor: 'bg-blue-100',
                    description: 'Chịu trách nhiệm quản lý, điều hành và ra quyết định cho hoạt động kinh doanh.',
                    responsibilities: [
                        'Phát triển chiến lược kinh doanh',
                        'Quản lý hiệu suất nhân viên',
                        'Giám sát tình hình tài chính',
                        'Đưa ra quyết định chiến lược'
                    ]
                },
                'Nhân viên bán hàng': {
                    icon: 'fas fa-handshake',
                    color: 'text-green-600',
                    bgColor: 'bg-green-100',
                    description: 'Thực hiện việc bán hàng, tư vấn sản phẩm và chăm sóc khách hàng.',
                    responsibilities: [
                        'Bán hàng và tư vấn sản phẩm',
                        'Xây dựng quan hệ khách hàng',
                        'Giải quyết khiếu nại',
                        'Báo cáo doanh số'
                    ]
                },
                'Kế toán': {
                    icon: 'fas fa-calculator',
                    color: 'text-purple-600',
                    bgColor: 'bg-purple-100',
                    description: 'Quản lý tài chính, kiểm soát thu chi và lập báo cáo tài chính.',
                    responsibilities: [
                        'Lập báo cáo tài chính',
                        'Quản lý chi phí và ngân sách',
                        'Xử lý hóa đơn và thanh toán',
                        'Đảm bảo tuân thủ quy định kế toán'
                    ]
                },
                'Nhân viên kho': {
                    icon: 'fas fa-box',
                    color: 'text-orange-600',
                    bgColor: 'bg-orange-100',
                    description: 'Quản lý kho bãi, đảm bảo hàng hóa được lưu trữ và vận chuyển đúng cách.',
                    responsibilities: [
                        'Nhận và kiểm tra hàng hóa',
                        'Sắp xếp và bảo quản hàng hóa',
                        'Kiểm kê và quản lý tồn kho',
                        'Chuẩn bị hàng cho đơn hàng'
                    ]
                },
                'IT support': {
                    icon: 'fas fa-laptop-code',
                    color: 'text-red-600',
                    bgColor: 'bg-red-100',
                    description: 'Hỗ trợ kỹ thuật, bảo trì hệ thống máy tính và mạng.',
                    responsibilities: [
                        'Xử lý sự cố kỹ thuật',
                        'Bảo trì hệ thống CNTT',
                        'Hỗ trợ người dùng',
                        'Đảm bảo an ninh thông tin'
                    ]
                }
            };

            // Show role information when selecting a role
            const vaiTroSelect = document.getElementById('vai_tro');
            const roleInfoContent = document.getElementById('role-info-content');
            
            vaiTroSelect.addEventListener('change', function() {
                const selectedRole = this.value;
                const info = roleInfo[selectedRole] || null;
                
                if (info) {
                    roleInfoContent.innerHTML = `
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center ${info.bgColor} ${info.color} w-16 h-16 rounded-full mb-3">
                                <i class="${info.icon} text-2xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">${selectedRole}</h4>
                        </div>
                        <p class="text-gray-600 mb-4">${info.description}</p>
                        <h5 class="font-medium text-gray-700 mb-2">Trách nhiệm chính:</h5>
                        <ul class="space-y-2">
                            ${info.responsibilities.map(item => `
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle ${info.color} mt-1 mr-2"></i>
                                    <span class="text-gray-600 text-sm">${item}</span>
                                </li>
                            `).join('')}
                        </ul>
                    `;
                } else {
                    roleInfoContent.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-user-tag text-4xl mb-3 text-gray-300"></i>
                            <p>Chọn vai trò để xem thông tin</p>
                        </div>
                    `;
                }
            });
            
            // Format salary input with thousand separators
            const salaryInput = document.getElementById('muc_luong');
            const formattedSalaryText = document.getElementById('formatted-salary-text');
            
            salaryInput.addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = this.value.replace(/\D/g, '');
                
                // Save caret position
                const caretPos = this.selectionStart;
                const oldLength = this.value.length;
                
                // Format with commas for display
                if (value) {
                    const formattedValue = new Intl.NumberFormat('vi-VN').format(value);
                    this.value = formattedValue;
                    formattedSalaryText.textContent = `${formattedValue} VNĐ`;
                    
                    // Adjust caret position after formatting
                    const newLength = this.value.length;
                    const adjustment = newLength - oldLength;
                    this.setSelectionRange(caretPos + adjustment, caretPos + adjustment);
                } else {
                    this.value = '';
                    formattedSalaryText.textContent = '0 VNĐ';
                }
            });
            
            // Store the actual numeric value
            document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
                const salaryValue = salaryInput.value.replace(/\D/g, '');
                
                // Create a hidden input with the clean numeric value
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'muc_luong';
                hiddenInput.value = salaryValue;
                
                // Replace the formatted input with the hidden one
                salaryInput.name = 'formatted_muc_luong';
                this.appendChild(hiddenInput);
            });
            
            // Form validation
            const form = document.getElementById('addEmployeeForm');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const ten_nhan_vien = document.getElementById('ten_nhan_vien').value.trim();
                const muc_luong = salaryInput.value.replace(/\D/g, '');
                const vai_tro = document.getElementById('vai_tro').value;
                
                if (!vai_tro) {
                    isValid = false;
                    showValidationError('vai_tro', 'Vui lòng chọn vai trò cho nhân viên');
                }
                
                if (!ten_nhan_vien) {
                    isValid = false;
                    showValidationError('ten_nhan_vien', 'Vui lòng nhập tên nhân viên');
                } else if (ten_nhan_vien.length < 3) {
                    isValid = false;
                    showValidationError('ten_nhan_vien', 'Tên nhân viên phải có ít nhất 3 ký tự');
                }
                
                if (!muc_luong) {
                    isValid = false;
                    showValidationError('muc_luong', 'Vui lòng nhập mức lương');
                } else if (parseInt(muc_luong) < 0) {
                    isValid = false;
                    showValidationError('muc_luong', 'Mức lương không thể âm');
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
            
            function showValidationError(fieldId, message) {
                const field = document.getElementById(fieldId);
                const parentEl = field.parentElement;
                
                field.classList.add('border-red-500', 'bg-red-50');
                
                // Remove any existing error message
                const existingError = parentEl.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                // Add new error message with animation
                const errorDiv = document.createElement('p');
                errorDiv.className = 'error-message text-red-500 text-sm mt-1.5 flex items-center animate-slide-down';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1.5"></i>${message}`;
                
                parentEl.appendChild(errorDiv);
                
                // Remove error styling when field is edited
                field.addEventListener('input', function() {
                    this.classList.remove('border-red-500', 'bg-red-50');
                    const error = parentEl.querySelector('.error-message');
                    if (error) {
                        error.remove();
                    }
                }, { once: true });
            }
            
            <?php if (!empty($success_message)): ?>
            // Countdown for redirect after successful submission
            let countdownValue = 3;
            const countdownEl = document.getElementById('countdown');
            
            const countdownInterval = setInterval(function() {
                countdownValue--;
                countdownEl.textContent = countdownValue;
                
                if (countdownValue <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = 'nhanvien.php';
                }
            }, 1000);
            <?php endif; ?>
        });
    </script>
</body>
</html>