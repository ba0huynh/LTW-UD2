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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê kinh doanh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <main class="flex flex-row">
        <?php include_once './gui/sidebar.php' ?>
        <div class="flex-1 p-6 overflow-auto">
            <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-6 w-full">
                <!-- Date Range Selector -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Thống kê kinh doanh</h1>
                    <form method="GET" action="" class="flex items-center space-x-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Từ ngày</label>
                            <input type="date" name="date_from" value="<?php echo $dateFrom; ?>" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Đến ngày</label>
                            <input type="date" name="date_to" value="<?php echo $dateTo; ?>" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>
                        <input type="hidden" name="view" value="<?php echo $view; ?>">
                        <div class="pt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent 
                                    rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Áp dụng
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-6">
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
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-start justify-center">
                            <h3 class="text-lg font-semibold text-gray-700">Tổng sách</h3>
                            <div class="text-4xl font-bold text-blue-500 mt-2">
                                <?php $books = $bookTable->getAllBook(); echo count($books); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-start justify-center">
                            <h3 class="text-lg font-semibold text-gray-700">Đơn hàng</h3>
                            <div class="text-4xl font-bold text-blue-500 mt-2">
                                <?php echo count($allHoaDon); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-start justify-center">
                            <h3 class="text-lg font-semibold text-gray-700">Khách hàng</h3>
                            <div class="text-4xl font-bold text-blue-500 mt-2">
                                <?php echo count($allUsers); ?>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-start justify-center">
                            <h3 class="text-lg font-semibold text-gray-700">Tổng doanh thu</h3>
                            <div class="text-4xl font-bold text-green-500 mt-2">
                                <?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="bg-white p-4 rounded-lg shadow mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Doanh thu 6 tháng qua</h3>
                        <canvas id="MonthSalesChart"></canvas>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Top 5 khách hàng có doanh thu cao</h3>
                            <canvas id="TopCustomerChart"></canvas>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Top 5 sản phẩm bán chạy</h3>
                            <canvas id="TopProductChart"></canvas>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($view == 'products'): ?>
                <!-- Products Statistics View -->
                <div>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thống kê sản phẩm</h2>
                        <div class="flex items-center justify-between mb-4">
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá bán</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng đã bán</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xem hoá đơn</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
                                <?php foreach ($productSales as $index => $product): 
                                    $isBestSeller = $index < 3; // Top 3 best sellers
                                    $isWorstSeller = $index >= count($productSales) - 3; // Bottom 3 worst sellers
                                ?>
                                <tr class="<?php echo $isBestSeller ? 'bg-green-50' : ($isWorstSeller ? 'bg-red-50' : ''); ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded" src="<?php echo $product['imageURL']; ?>" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $product['bookName']; ?></div>
                                                <?php if ($isBestSeller): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Bán chạy nhất
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($isWorstSeller): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Bán chậm nhất
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo number_format($product['currentPrice'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $product['quantity_sold']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="font-semibold <?php echo $isBestSeller ? 'text-green-600' : ($isWorstSeller ? 'text-red-600' : 'text-gray-900'); ?>">
                                            <?php echo number_format($product['total_revenue'], 0, ',', '.'); ?>đ
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="./quanlidon.php?product_id=<?php echo $product['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Xem hóa đơn</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($view == 'customers'): ?>
                <!-- Customers Statistics View -->
                <div>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thống kê khách hàng</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số đơn hàng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xem hoá đơn</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($topCustomers as $index => $customer): 
                                    $isTopCustomer = $index < 3; // Top 3 customers
                                ?>
                                <tr class="<?php echo $isTopCustomer ? 'bg-blue-50' : ''; ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $customer['fullName']; ?></div>
                                                <?php if ($isTopCustomer): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Top <?php echo $index + 1; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $customer['email']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $customer['order_count']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="font-semibold <?php echo $isTopCustomer ? 'text-blue-600' : 'text-gray-900'; ?>">
                                            <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?>đ
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="./quanlidon.php?user_id=<?php echo $customer['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Xem hóa đơn</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dashboard Charts
        <?php if ($view == 'dashboard'): ?>
        // Monthly Sales Chart
        new Chart(document.getElementById('MonthSalesChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($hoadonTable->getlast6Monthstotal(), 'month')) ?>,
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: <?php echo json_encode(array_column($hoadonTable->getlast6Monthstotal(), 'total_bill')) ?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VND)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    }
                }
            }
        });

        // Top Customer Chart
        new Chart(document.getElementById('TopCustomerChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column(array_slice($customerSales, 0, 5), 'fullName')); ?>,
                datasets: [{
                    label: 'Top khách hàng (VND)',
                    data: <?php echo json_encode(array_column(array_slice($customerSales, 0, 5), 'total_spent')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top Product Chart
        new Chart(document.getElementById('TopProductChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($bestSellingProducts, 'bookName')); ?>,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: <?php echo json_encode(array_column($bestSellingProducts, 'total_revenue')); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>

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