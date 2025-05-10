<?php
$adminID = $_SESSION['admin_id'] ?? null;
if ($adminID == null) {
    header("Location: ./login.php");
    exit;
}
?>
<link rel="stylesheet" href="./assets/css/sidebar.css">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div id="sidebar" class="bg-[#1a2536] text-[rgb(204,200,200)] flex flex-col justify-between h-screen">
    <div class="flex flex-col gap-2">
        <div class="sidebar-header flex items-center justify-between px-4 py-3">
            <button id="toggle-sidebar" class="text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <a href="./analytics.php">
            <div class="menu-item">
                <i class="fas fa-chart-line"></i> <span>Thống kê</span>
            </div>
        </a>
        <div class="menu-item">
            <i class="fas fa-users"></i> <span>Quản lý khách hàng</span>
        </div>
        <div class="submenu">
            <a href="./thongTinKhachHang.php">         <div class="submenu-item">Danh sách khách </div></a>
        </div>
        <div class="menu-item">
            <i class="fas fa-user-tie"></i> <span>Quản lý nhân viên</span>
        </div>
        <div class="submenu">
            <a href="./nhanvien.php">         <div class="submenu-item">Danh sách nhân viên</div></a>
            <a href="./add_nhanvien.php">            <div class="submenu-item">Thêm nhân viên</div></a>
        </div>
        <a href="./review.php">

            <div class="menu-item">
                <i class="fas fa-star"></i> <span>Đánh giá</span>
            </div>
        </a>
        <div class="menu-item">
            <i class="fas fa-box"></i> <span>Quản lí sản phẩm</span>
        </div>
        <div class="submenu">
            <a href="./sanphan.php">            <div class="submenu-item">Danh sách sản phẩm</div></a>
            <a href="./themSanPham.php">        <div class="submenu-item">Thêm sản phẩm</div></a>
            <a href="./thongTinPhieuNhap.php">  <div class="submenu-item">Danh sách phiếu nhập</div></a>
            <a href="">  <div class="submenu-item">Thêm phiếu nhập</div></a>
        </div>
        <a href="./quanlidon.php">

            <div class="menu-item">
                <i class="fas fa-shopping-cart"></i> <span>Quản lý đơn hàng</span>
            </div>
        </a>
        <div class="submenu">
            <div class="submenu-item">Danh sách đơn hàng</div>
            <div class="submenu-item">Thêm đơn hàng</div>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="px-4 py-3">
        <form action="./logout.php" method="POST">
            <button type="submit" class="w-full bg-red-500 text-white font-medium py-2 rounded-lg hover:bg-red-600 transition">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>

<script>
    // Toggle sidebar collapse
    document.getElementById("toggle-sidebar").addEventListener("click", () => {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("collapsed");
    });

    // Toggle submenu visibility
    const menuItems = document.querySelectorAll(".menu-item");
    menuItems.forEach((item) => {
        item.addEventListener("click", () => {
            item.classList.toggle("open");
            const submenu = item.nextElementSibling;
            if (submenu && submenu.classList.contains("submenu")) {
                submenu.style.display = submenu.style.display === "flex" ? "none" : "flex";
            }
        });
    });
</script>