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
        <canvas id="MonthSalesChart"></canvas>
    </div>
    <div>
        <canvas id="TopCustomerChart"></canvas>
    </div>



</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


document.getElementById('ChartSelect').addEventListener('change', function () {
    const selectedValue = this.value;

    // Get the chart canvas elements
    const monthSalesChart = document.getElementById('MonthSalesChart');
    const topCustomerChart = document.getElementById('TopCustomerChart');

    // Toggle visibility based on the selected value
    if (selectedValue === '6month') {
        monthSalesChart.style.display = 'block';
        topCustomerChart.style.display = 'none';
    } else if (selectedValue === 'topCustomer') {
        monthSalesChart.style.display = 'none';
        topCustomerChart.style.display = 'block';
    }
});

// Set default visibility (optional)
document.getElementById('MonthSalesChart').style.display = 'block';
document.getElementById('TopCustomerChart').style.display = 'none';





    const MonthSalesChart = document.getElementById('MonthSalesChart');
    const TopCustomerChart = document.getElementById('TopCustomerChart');


    new Chart(MonthSalesChart, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            datasets: [{
                label: 'So luong san pham da ban qua 6 thang qua',
                data: [12, 19, 3, 5, 2, 3, 9, 10, 11, 12, 30, 14, 15],
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
                data: <?php echo json_encode(array_column($top5User, 'totalBooksOrdered')); ?> ,
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