<?php
// filepath: c:\xampp\htdocs\LTW-UD2\admin\gui\sidebar.php
$adminID = $_SESSION['admin_id'] ?? null;
if ($adminID == null) {
    header("Location: ./login.php");
    exit;
}

// Get current page to highlight active menu item
$current_page = basename($_SERVER['PHP_SELF']);

// Helper function to check if a page is active
function isActive($page) {
    global $current_page;
    return $current_page == $page ? 'active' : '';
}

// Helper function to check if a section has an active page
function isSectionActive($pages) {
    global $current_page;
    return in_array($current_page, $pages) ? 'section-active' : '';
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Sidebar Styles */
    .sidebar {
        --sidebar-width: 240px;
        --sidebar-collapsed-width: 70px;
        --primary-color: #2563eb;
        --primary-hover: #1e40af;
        --sidebar-bg: #1a2536;
        --sidebar-item-hover: rgba(255, 255, 255, 0.05);
        --sidebar-item-active-bg: rgba(37, 99, 235, 0.1);
        --sidebar-item-active-border: #2563eb;
        --text-color: #e2e8f0;
        --text-muted: #94a3b8;
        --transition-speed: 0.25s;
    }
    
    .sidebar {
        position: fixed;
        height: 100vh;
        width: var(--sidebar-width);
        background-color: var(--sidebar-bg);
        color: var(--text-color);
        transition: width var(--transition-speed) ease;
        z-index: 50;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }
    
    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }
    
    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .logo {
        display: flex;
        align-items: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        transition: opacity var(--transition-speed);
    }
    
    .logo-icon {
        font-size: 1.5rem;
        margin-right: 0.75rem;
        color: var(--primary-color);
    }
    
    .collapse-button {
        cursor: pointer;
        background: transparent;
        border: none;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }
    
    .collapse-button:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .menu-container {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 1rem 0;
    }
    
    .menu-container::-webkit-scrollbar {
        width: 5px;
    }
    
    .menu-container::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }
    
    .menu-container::-webkit-scrollbar-track {
        background-color: transparent;
    }
    
    .menu-section {
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.05em;
        overflow: hidden;
        white-space: nowrap;
        opacity: 1;
        transition: opacity var(--transition-speed);
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--text-color);
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all var(--transition-speed);
        position: relative;
        cursor: pointer;
        margin-bottom: 2px;
    }
    
    .menu-item:hover {
        background-color: var(--sidebar-item-hover);
        color: white;
    }
    
    .menu-item.active {
        background-color: var(--sidebar-item-active-bg);
        border-left-color: var(--sidebar-item-active-border);
        color: white;
    }
    
    .menu-item i {
        min-width: 1.5rem;
        margin-right: 0.75rem;
        text-align: center;
        font-size: 1rem;
        transition: margin var(--transition-speed);
    }
    
    .menu-item span {
        opacity: 1;
        transition: opacity var(--transition-speed);
        white-space: nowrap;
    }
    
    .menu-arrow {
        margin-left: auto;
        transition: transform var(--transition-speed);
    }
    
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height var(--transition-speed);
        background-color: rgba(0, 0, 0, 0.15);
    }
    
    .submenu.open {
        max-height: 500px; /* Adjust if needed */
    }
    
    .submenu-item {
        display: flex;
        align-items: center;
        padding: 0.65rem 1rem 0.65rem 3.25rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: all var(--transition-speed);
        position: relative;
        white-space: nowrap;
    }
    
    .submenu-item:hover {
        color: white;
        background-color: var(--sidebar-item-hover);
    }
    
    .submenu-item.active {
        color: white;
        background-color: var(--sidebar-item-active-bg);
    }
    
    .submenu-item::before {
        content: "";
        position: absolute;
        left: 1.65rem;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background-color: var(--text-muted);
        transition: background-color var(--transition-speed);
    }
    
    .submenu-item:hover::before,
    .submenu-item.active::before {
        background-color: white;
    }
    
    /* User profile section */
    .user-profile {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin-top: auto;
        transition: padding var(--transition-speed);
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        color: white;
        font-weight: bold;
        flex-shrink: 0;
    }
    
    .user-info {
        overflow: hidden;
        transition: opacity var(--transition-speed), width var(--transition-speed);
        opacity: 1;
        width: auto;
    }
    
    .user-name {
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-role {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .logout-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        background-color: rgba(239, 68, 68, 0.15);
        color: rgb(239, 68, 68);
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        font-weight: 600;
        margin: 1rem;
        transition: background-color 0.2s;
    }
    
    .logout-button:hover {
        background-color: rgba(239, 68, 68, 0.25);
    }
    
    .logout-button i {
        margin-right: 0.5rem;
    }
    
    /* Collapsed state styles */
    .sidebar.collapsed .logo span {
        opacity: 0;
        width: 0;
    }
    
    .sidebar.collapsed .menu-section,
    .sidebar.collapsed .menu-item span,
    .sidebar.collapsed .menu-arrow {
        opacity: 0;
    }
    
    .sidebar.collapsed .menu-item {
        padding: 0.75rem 0;
        justify-content: center;
    }
    
    .sidebar.collapsed .menu-item i {
        margin-right: 0;
        font-size: 1.25rem;
    }
    
    .sidebar.collapsed .submenu {
        position: absolute;
        left: var(--sidebar-collapsed-width);
        top: 0;
        width: 200px;
        background-color: var(--sidebar-bg);
        box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 10;
        max-height: 0;
        border-radius: 0 0.375rem 0.375rem 0;
    }
    
    .sidebar.collapsed .has-submenu:hover .submenu {
        max-height: 500px;
    }
    
    .sidebar.collapsed .submenu-item {
        padding-left: 1rem;
    }
    
    .sidebar.collapsed .submenu-item::before {
        display: none;
    }
    
    .sidebar.collapsed .user-info {
        opacity: 0;
        width: 0;
    }
    
    .sidebar.collapsed .user-profile {
        padding: 1rem 0;
        justify-content: center;
    }
    
    .sidebar.collapsed .user-avatar {
        margin-right: 0;
    }
    
    .sidebar.collapsed .logout-button span {
        display: none;
    }
    
    .sidebar.collapsed .logout-button {
        padding: 0.75rem;
        border-radius: 50%;
        margin: 1rem auto;
        width: 42px;
        height: 42px;
    }
    
    .sidebar.collapsed .logout-button i {
        margin-right: 0;
    }
    
    /* Mobile styles */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: var(--sidebar-width);
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        .sidebar-backdrop.show {
            display: block;
        }
    }
</style>

<div id="sidebar-backdrop" class="sidebar-backdrop"></div>
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fa-solid fa-book logo-icon"></i>
            <span>Admin Dashboard</span>
        </div>
     
    </div>
    
    <div class="menu-container">
        <div class="menu-section">Dashboard</div>
        
        <a href="./analytics.php" class="menu-item <?= isActive('analytics.php') ?>">
            <i class="fa-solid fa-chart-line"></i>
            <span>Thống kê</span>
        </a>
        
        <div class="menu-section">Quản lý người dùng</div>
        
        <div class="menu-item has-submenu <?= isSectionActive(['thongTinKhachHang.php']) ?>">
            <i class="fa-solid fa-users"></i>
            <span>Khách hàng</span>
            <i class="fa-solid fa-chevron-right menu-arrow"></i>
        </div>
        <div class="submenu <?= isSectionActive(['thongTinKhachHang.php']) ? 'open' : '' ?>">
            <a href="./thongTinKhachHang.php" class="submenu-item <?= isActive('thongTinKhachHang.php') ?>">
                Danh sách khách hàng
            </a>
        </div>
        
        <div class="menu-item has-submenu <?= isSectionActive(['nhanvien.php', 'add_nhanvien.php']) ?>">
            <i class="fa-solid fa-user-tie"></i>
            <span>Nhân viên</span>
            <i class="fa-solid fa-chevron-right menu-arrow"></i>
        </div>
        <div class="submenu <?= isSectionActive(['nhanvien.php', 'add_nhanvien.php']) ? 'open' : '' ?>">
            <a href="./nhanvien.php" class="submenu-item <?= isActive('nhanvien.php') ?>">
                Danh sách nhân viên
            </a>
            <a href="./add_nhanvien.php" class="submenu-item <?= isActive('add_nhanvien.php') ?>">
                Thêm nhân viên
            </a>
        </div>
        
        <div class="menu-section">Quản lý hệ thống</div>
        
        <a href="./review.php" class="menu-item <?= isActive('review.php') ?>">
            <i class="fa-solid fa-star"></i>
            <span>Đánh giá</span>
        </a>
        
        <div class="menu-item has-submenu <?= isSectionActive(['sanphan.php', 'themSanPham.php', 'supplier.php', 'thongTinPhieuNhap.php', 'nhapSanPham.php']) ?>">
            <i class="fa-solid fa-box"></i>
            <span>Sản phẩm</span>
            <i class="fa-solid fa-chevron-right menu-arrow"></i>
        </div>
        <div class="submenu <?= isSectionActive(['sanphan.php', 'themSanPham.php', 'supplier.php', 'thongTinPhieuNhap.php', 'nhapSanPham.php']) ? 'open' : '' ?>">
            <a href="./sanphan.php" class="submenu-item <?= isActive('sanphan.php') ?>">
                Danh sách sản phẩm
            </a>
            <a href="./themSanPham.php" class="submenu-item <?= isActive('themSanPham.php') ?>">
                Thêm sản phẩm
            </a>
            <a href="./supplier.php" class="submenu-item <?= isActive('supplier.php') ?>">
                Nhà cung cấp
            </a>
            <a href="./thongTinPhieuNhap.php" class="submenu-item <?= isActive('thongTinPhieuNhap.php') ?>">
                Danh sách phiếu nhập
            </a>
            <a href="./nhapSanPham.php" class="submenu-item <?= isActive('nhapSanPham.php') ?>">
                Thêm phiếu nhập
            </a>
        </div>
        
        <div class="menu-item has-submenu <?= isSectionActive(['quanlidon.php']) ?>">
            <i class="fa-solid fa-shopping-cart"></i>
            <span>Đơn hàng</span>
            <i class="fa-solid fa-chevron-right menu-arrow"></i>
        </div>
        <div class="submenu <?= isSectionActive(['quanlidon.php']) ? 'open' : '' ?>">
            <a href="./quanlidon.php" class="submenu-item <?= isActive('quanlidon.php') ?>">
                Danh sách đơn hàng
            </a>
            <a href="#" class="submenu-item">
                Thêm đơn hàng
            </a>
        </div>
        
        <div class="menu-item has-submenu <?= isSectionActive(['xemquyen.php', 'themquyen.php']) ?>">
            <i class="fa-solid fa-lock"></i>
            <span>Phân quyền</span>
            <i class="fa-solid fa-chevron-right menu-arrow"></i>
        </div>
        <div class="submenu <?= isSectionActive(['xemquyen.php', 'themquyen.php']) ? 'open' : '' ?>">
            <a href="./xemquyen.php" class="submenu-item <?= isActive('xemquyen.php') ?>">
                Xem quyền
            </a>
            <a href="./themquyen.php" class="submenu-item <?= isActive('themquyen.php') ?>">
                Thêm quyền
            </a>
        </div>
    </div>
    
    <div class="user-profile">
        <div class="user-avatar">
            <?php echo isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : 'A'; ?>
        </div>
        <div class="user-info">
            <div class="user-name">
                <?php echo $_SESSION['user_name'] ?? 'Admin User'; ?>
            </div>
            <div class="user-role">Administrator</div>
        </div>
    </div>
    
    <form action="./logout.php" method="POST">
        <button type="submit" class="logout-button">
            <i class="fa-solid fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggle-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const menuItems = document.querySelectorAll('.menu-item.has-submenu');
        const isMobile = window.innerWidth < 768;
        
        // Initialize sidebar state from localStorage if available
        if (localStorage.getItem('sidebarCollapsed') === 'true' && !isMobile) {
            sidebar.classList.add('collapsed');
        }
        
        // Sidebar toggle handler
        toggleSidebar.addEventListener('click', function() {
            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
                backdrop.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        });
        
        // Backdrop click handler (mobile)
        backdrop.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('show');
        });
        
        // Submenu toggle handlers
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                
                if (!sidebar.classList.contains('collapsed') || isMobile) {
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                        this.classList.remove('active');
                        this.querySelector('.menu-arrow').style.transform = '';
                    } else {
                        // Close other open submenus
                        document.querySelectorAll('.submenu.open').forEach(menu => {
                            if (menu !== submenu) {
                                menu.classList.remove('open');
                                menu.previousElementSibling.classList.remove('active');
                                menu.previousElementSibling.querySelector('.menu-arrow').style.transform = '';
                            }
                        });
                        
                        submenu.classList.add('open');
                        this.classList.add('active');
                        this.querySelector('.menu-arrow').style.transform = 'rotate(90deg)';
                    }
                }
            });
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const isMobileNow = window.innerWidth < 768;
            
            if (isMobileNow !== isMobile) {
                // Refresh the page or handle the transition
                if (isMobileNow) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.add('mobile-open');
                } else {
                    sidebar.classList.remove('mobile-open');
                    backdrop.classList.remove('show');
                    if (localStorage.getItem('sidebarCollapsed') === 'true') {
                        sidebar.classList.add('collapsed');
                    }
                }
            }
        });
    });
</script>