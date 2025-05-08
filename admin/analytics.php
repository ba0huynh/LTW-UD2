<?php
session_start();
require_once("../database/database.php");
require_once("../database/user.php");
require_once("../database/book.php");
require_once("../database/hoadon.php");
require_once("../database/chitiethoadon.php");
$userTable = new UsersTable();
$bookTable = new BooksTable();
$hoadonTable = new HoadonTable();
$chiTietHoadonTable = new ChiTietHoadonTable();
$user = null;
if (isset($_SESSION["user"]) && $_SESSION["user"] != null) {
    $user = $userTable->getUserDetailsById($_SESSION["user"]);
    if ($user == null) {
        unset($_SESSION["user"]);
    }
}

// Get date range parameters
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-6 months'));
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// Get data based on date range
$top5User = $userTable->getTop5UsersByBooksOrdered();
$allHoaDon = $hoadonTable->getAllHoaDon();
$allUsers = $userTable->getAllUser();

// Get product sales data
$productSales = $chiTietHoadonTable->getProductSalesByDateRange($dateFrom, $dateTo);
$totalRevenue = 0;
foreach ($productSales as $product) {
    $totalRevenue += $product['total_revenue'];
}

// Sort products by revenue
$bestSellingProducts = $productSales;
usort($bestSellingProducts, function($a, $b) {
    return $b['total_revenue'] - $a['total_revenue'];
});
$worstSellingProducts = $bestSellingProducts;
$bestSellingProducts = array_slice($bestSellingProducts, 0, 5); // Top 5
$worstSellingProducts = array_slice(array_reverse($worstSellingProducts), 0, 5); // Bottom 5

// Get customer data
$customerSales = $userTable->getCustomerSalesByDateRange($dateFrom, $dateTo);
usort($customerSales, function($a, $b) {
    return $b['total_spent'] - $a['total_spent'];
});
$topCustomers = array_slice($customerSales, 0, 10); // Top 10 customers

// Monthly revenue data
$monthlyRevenue = $hoadonTable->getlast6Monthstotal();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê kinh doanh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @media (max-width: 640px) {
            .date-range-form {
                flex-direction: column;
                align-items: stretch;
            }
            .date-range-form > div {
                margin-bottom: 10px;
                margin-right: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <main class="flex flex-col md:flex-row min-h-screen">
        <!-- Mobile sidebar toggle button -->
        <div class="md:hidden p-4 bg-white border-b">
            <button id="mobileSidebarToggle" class="text-gray-500 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- Sidebar - hidden on mobile by default -->
        <div id="sidebar" class="hidden md:block md:w-64 bg-white shadow-md">
            <?php include_once './gui/sidebar.php' ?>
        </div>
        
        <div class="flex-1 p-3 sm:p-4 md:p-6 h-screen overflow-auto">
            <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-3 sm:p-4 md:p-6 w-full max-w-full">
                <!-- Date Range Selector -->
                <div class="mb-4 md:mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2 sm:mb-4">Thống kê kinh doanh</h1>
                    <form method="GET" action="" class="flex flex-wrap gap-3 md:flex-nowrap date-range-form">
                        <div class="w-full sm:w-auto">
                            <label class="block text-sm font-medium text-gray-700">Từ ngày</label>
                            <input type="date" name="date_from" value="<?php echo $dateFrom; ?>" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>
                        <div class="w-full sm:w-auto">
                            <label class="block text-sm font-medium text-gray-700">Đến ngày</label>
                            <input type="date" name="date_to" value="<?php echo $dateTo; ?>" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>
                        <input type="hidden" name="view" value="<?php echo $view; ?>">
                        <div class="w-full sm:w-auto sm:self-end">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent 
                                    rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Áp dụng
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation Tabs - Scrollable on mobile -->
                <div class="border-b border-gray-200 mb-4 md:mb-6 overflow-x-auto pb-2">
                    <nav class="flex space-x-4 md:space-x-6 min-w-max">
                        <a href="?view=dashboard&date_from=<?php echo $dateFrom; ?>&date_to=<?php echo $dateTo; ?>" 
                           class="<?php echo $view == 'dashboard' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> 
                           whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                            Tổng quan
                        </a>
                        <a href="?view=products&date_from=<?php echo $dateFrom; ?>&date_to=<?php echo $dateTo; ?>" 
                           class="<?php echo $view == 'products' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> 
                           whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                            Thống kê sản phẩm
                        </a>
                        <a href="?view=customers&date_from=<?php echo $dateFrom; ?>&date_to=<?php echo $dateTo; ?>" 
                           class="<?php echo $view == 'customers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> 
                           whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                            Thống kê khách hàng
                        </a>
                    </nav>
                </div>

                <?php if ($view == 'dashboard'): ?>
                <!-- Dashboard View -->
                <div>
                    <!-- Summary Cards - Responsive grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-4 md:mb-6">
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 flex flex-col items-start justify-center">
                            <h3 class="text-base md:text-lg font-semibold text-gray-700">Tổng sách</h3>
                            <div class="text-2xl md:text-4xl font-bold text-blue-500 mt-1 md:mt-2">
                                <?php $books = $bookTable->getAllBook(); echo count($books); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 flex flex-col items-start justify-center">
                            <h3 class="text-base md:text-lg font-semibold text-gray-700">Đơn hàng</h3>
                            <div class="text-2xl md:text-4xl font-bold text-blue-500 mt-1 md:mt-2">
                                <?php echo count($allHoaDon); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 flex flex-col items-start justify-center">
                            <h3 class="text-base md:text-lg font-semibold text-gray-700">Khách hàng</h3>
                            <div class="text-2xl md:text-4xl font-bold text-blue-500 mt-1 md:mt-2">
                                <?php echo count($allUsers); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 flex flex-col items-start justify-center">
                            <h3 class="text-base md:text-lg font-semibold text-gray-700">Tổng doanh thu</h3>
                            <div class="text-2xl md:text-4xl font-bold text-green-500 mt-1 md:mt-2">
                                <?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Revenue Table -->
                    <div class="bg-white p-3 sm:p-4 rounded-lg shadow mb-4 md:mb-6">
                        <h3 class="text-base md:text-lg font-medium text-gray-800 mb-2 md:mb-4">Doanh thu 6 tháng qua</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tháng</th>
                                        <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($monthlyRevenue as $month): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $month['month']; ?></td>
                                        <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-sm text-right text-gray-900 font-semibold"><?php echo number_format($month['total_bill'], 0, ',', '.'); ?>đ</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tables for Top Customers and Products -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                        <!-- Top 5 Customers Table -->
                        <div class="bg-white p-3 sm:p-4 rounded-lg shadow">
                            <h3 class="text-base md:text-lg font-medium text-gray-800 mb-2 md:mb-4">Top 5 khách hàng có doanh thu cao</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn hàng</th>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach (array_slice($customerSales, 0, 5) as $index => $customer): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-500">
                                                        <span class="font-medium"><?php echo $index + 1; ?></span>
                                                    </div>
                                                    <div class="ml-2 md:ml-3">
                                                        <div class="text-xs md:text-sm font-medium text-gray-900"><?php echo $customer['fullName']; ?></div>
                                                        <div class="text-xs text-gray-500 hidden sm:block"><?php echo $customer['email']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-xs md:text-sm text-right"><?php echo $customer['order_count']; ?></td>
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-xs md:text-sm text-right font-medium text-blue-600"><?php echo number_format($customer['total_spent'], 0, ',', '.'); ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Top 5 Products Table -->
                        <div class="bg-white p-3 sm:p-4 rounded-lg shadow">
                            <h3 class="text-base md:text-lg font-medium text-gray-800 mb-2 md:mb-4">Top 5 sản phẩm bán chạy</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                            <th scope="col" class="px-3 py-2 md:px-4 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($bestSellingProducts as $index => $product): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 rounded overflow-hidden">
                                                        <img class="h-8 w-8 object-cover" src="<?php echo $product['imageURL']; ?>" alt="Product">
                                                    </div>
                                                    <div class="ml-2 md:ml-3">
                                                        <div class="text-xs md:text-sm font-medium text-gray-900 line-clamp-1"><?php echo $product['bookName']; ?></div>
                                                        <div class="text-xs text-gray-500"><?php echo number_format($product['currentPrice'], 0, ',', '.'); ?>đ</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-xs md:text-sm text-right"><?php echo $product['quantity_sold']; ?></td>
                                            <td class="px-3 py-2 md:px-4 md:py-3 whitespace-nowrap text-xs md:text-sm text-right font-medium text-green-600"><?php echo number_format($product['total_revenue'], 0, ',', '.'); ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($view == 'products'): ?>
                <!-- Products Statistics View -->
                <div>
                    <div class="mb-4 md:mb-6">
                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-2 md:mb-4">Thống kê sản phẩm</h2>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                            <p class="text-gray-600">Tổng doanh thu: <span class="font-bold text-green-600"><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</span></p>
                            <div>
                                <label class="mr-2">Sắp xếp:</label>
                                <select id="productSort" class="border rounded p-2">
                                    <option value="revenue-desc">Doanh thu cao nhất</option>
                                    <option value="revenue-asc">Doanh thu thấp nhất</option>
                                    <option value="quantity-desc">Số lượng bán nhiều nhất</option>
                                    <option value="quantity-asc">Số lượng bán ít nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive table wrapper -->
                    <div class="overflow-x-auto -mx-4 sm:-mx-0">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá bán</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xem hoá đơn</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
                                    <?php foreach ($productSales as $index => $product): 
                                        $isBestSeller = $index < 3; // Top 3 best sellers
                                        $isWorstSeller = $index >= count($productSales) - 3; // Bottom 3 worst sellers
                                    ?>
                                    <tr class="<?php echo $isBestSeller ? 'bg-green-50' : ($isWorstSeller ? 'bg-red-50' : ''); ?>">
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                                    <img class="h-8 w-8 sm:h-10 sm:w-10 rounded" src="<?php echo $product['imageURL']; ?>" alt="">
                                                </div>
                                                <div class="ml-2 sm:ml-4">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900"><?php echo $product['bookName']; ?></div>
                                                    <?php if ($isBestSeller): ?>
                                                        <span class="hidden sm:inline-flex text-xs items-center px-2 py-0.5 rounded-full bg-green-100 text-green-800">
                                                            Bán chạy nhất
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if ($isWorstSeller): ?>
                                                        <span class="hidden sm:inline-flex text-xs items-center px-2 py-0.5 rounded-full bg-red-100 text-red-800">
                                                            Bán chậm nhất
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <?php echo number_format($product['currentPrice'], 0, ',', '.'); ?>đ
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <?php echo $product['quantity_sold']; ?>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <span class="font-semibold <?php echo $isBestSeller ? 'text-green-600' : ($isWorstSeller ? 'text-red-600' : 'text-gray-900'); ?>">
                                                <?php echo number_format($product['total_revenue'], 0, ',', '.'); ?>đ
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-right">
                                            <a href="./quanlidon.php?product_id=<?php echo $product['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Xem</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($view == 'customers'): ?>
                <!-- Customers Statistics View -->
                <div>
                    <div class="mb-4 md:mb-6">
                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-2 md:mb-4">Thống kê khách hàng</h2>
                    </div>

                    <!-- Responsive table wrapper -->
                    <div class="overflow-x-auto -mx-4 sm:-mx-0">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn hàng</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xem</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($topCustomers as $index => $customer): 
                                        $isTopCustomer = $index < 3; // Top 3 customers
                                    ?>
                                    <tr class="<?php echo $isTopCustomer ? 'bg-blue-50' : ''; ?>">
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                                    <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                        <i class="fas fa-user text-xs sm:text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-2 sm:ml-4">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900"><?php echo $customer['fullName']; ?></div>
                                                    <?php if ($isTopCustomer): ?>
                                                        <span class="hidden sm:inline-flex text-xs items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                                            Top <?php echo $index + 1; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <span class="hidden sm:inline"><?php echo $customer['email']; ?></span>
                                            <span class="sm:hidden"><?php echo substr($customer['email'], 0, 10); ?>...</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <?php echo $customer['order_count']; ?>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                            <span class="font-semibold <?php echo $isTopCustomer ? 'text-blue-600' : 'text-gray-900'; ?>">
                                                <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?>đ
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-right">
                                            <a href="./quanlidon.php?user_id=<?php echo $customer['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Xem</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Mobile sidebar toggle
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });

        // Handle responsiveness on window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 768) { // md breakpoint
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        });

        // Product sorting functionality
        document.getElementById('productSort')?.addEventListener('change', function() {
            const sortValue = this.value;
            const tableBody = document.getElementById('productTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            
            rows.sort((a, b) => {
                let aValue, bValue;
                
                if (sortValue.startsWith('revenue')) {
                    aValue = parseInt(a.querySelector('td:nth-child(4)').textContent.replace(/\D/g, ''));
                    bValue = parseInt(b.querySelector('td:nth-child(4)').textContent.replace(/\D/g, ''));
                } else {
                    aValue = parseInt(a.querySelector('td:nth-child(3)').textContent);
                    bValue = parseInt(b.querySelector('td:nth-child(3)').textContent);
                }
                
                return sortValue.endsWith('asc') ? aValue - bValue : bValue - aValue;
            });
            
            // Clear the table and append sorted rows
            tableBody.innerHTML = '';
            rows.forEach(row => tableBody.appendChild(row));
        });
    </script>
</body>
</html>