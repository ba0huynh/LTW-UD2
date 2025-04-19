
<div class="container">
    <h2>Thông tin phiếu nhập</h2>
    <div class="filter-container">
        <label for="show-Number">Hiển thị</label>
        <input type="number" id="show-Number" value="10" min="0">
        <span>phiếu nhập</span>
    </div>


    <table>
        <thead>
            <tr>
                <th>Người nhập</th>
                <th>Nhà cung cấp</th>
                <th>Tổng tiền</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <tr class="empty-row">
                <td colspan="4">Không tìm thấy phiếu nhập</td>
            </tr>
        </tbody>
    </table>

    <div class="phan-trang">
        <button>&laquo;</button>
        <button>&raquo;</button>
    </div>
</div>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-container label {
            font-size: 14px;
            color: #6c757d;
            font-weight: bold;
        }

        .filter-container input {
            width: 60px;
            padding: 6px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border-bottom: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
            background-color: #fff;
        }

        td {
            font-size: 14px;
            background-color: #f8f9fa;
        }

        .empty-row {
            background-color: #f1f1f1;
            font-weight: bold;
            color: #6c757d;
        }

        .phan-trang{
            display: flex;
            margin-top: 10px;
        }

        .phan-trang button {
            border: 1px solid #ccc;
            background-color: white;
            color: #333;
            padding: 6px 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 50%;
            margin: 0 5px;
        }

        .phan-trang button:hover {
            background-color: #ddd;
        }

    </style>