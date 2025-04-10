<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div class="flex flex-row gap-4">
        <div class="bg-white shadow-md rounded-lg p-6 flex-1 flex flex-col items-start justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-700">Sach</h3>
            <div class="text-4xl font-bold text-blue-500 mt-2">
                <?php $books = $bookTable->getAllBook();
                echo count($books); ?>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-1 flex-col items-start justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-700">Don hang</h3>
            <div class="text-4xl font-bold text-blue-500 mt-2">
                <?php
                echo count($allHoaDon); ?>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col flex-1 items-start justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-700">khach hang</h3>
            <div class="text-4xl font-bold text-blue-500 mt-2">
                <?php
                $users = $userTable->getAllUser();
                echo count($users); ?>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col flex-1 items-start justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-700">Da ban</h3>
            <div class="text-4xl font-bold text-blue-500 mt-2">
                <?php
                $daban = $chiTietHoadonTable->getAll();
                echo count($daban); ?>
            </div>
        </div>
    </div>

    <div>
        <select name="" id="ChartSelect" class="border border-gray-300 rounded-md p-2 mt-4">
            <option value="6month">6 tháng trước</option>
            <option value="topCustomer">Top khách hàng</option>
        </select>

    </div>
    <div>
      
    </div>
    <div>
        <canvas id="MonthSalesChart"></canvas>
    </div>
    <div>
        <canvas id="TopCustomerChart"></canvas>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const MonthSalesChart = document.getElementById('MonthSalesChart');
    const TopCustomerChart = document.getElementById('TopCustomerChart');
    TopCustomerChart.style.display = 'none';
    document.getElementById('ChartSelect').addEventListener('change', function() {
        const selectedValue = this.value;
        removeAllCharts();

        if (selectedValue === '6month') {
            MonthSalesChart.style.display = 'block';
        } else if (selectedValue === 'topCustomer') {
            TopCustomerChart.style.display = 'block';
        }
    });

    function removeAllCharts() {
        TopCustomerChart.style.display = 'none';
        MonthSalesChart.style.display = 'none';

    }

    new Chart(MonthSalesChart, {
        type: 'line',
        data: {
            labels:<?php echo json_encode(array_column($hoadonTable->getlast6Monthstotal(), 'month')) ?>,
            datasets: [{
                label: 'So luong san pham da ban qua 6 thang qua',
                data: <?php echo json_encode(array_column($hoadonTable->getlast6Monthstotal(), 'total_bill')) ?>,
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

    new Chart(TopCustomerChart, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($top5User, 'userName')); ?>,
            datasets: [{
                label: 'Top Customers',
                data: <?php echo json_encode(array_column($top5User, 'totalSpent')); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
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
</script>

</html>