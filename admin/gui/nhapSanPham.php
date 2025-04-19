
<div class="container">
    <h2>Nhập sản phẩm</h2>
    <form>
        <div class="flex-container">
            <div class="form-group">
                <label>Hãng</label>
                <select>
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        
            <div class="form-group">
                <label>Thiết kế</label>
                <select>
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        </div>
        

        <div class="form-group">
            <label>Tên sản phẩm</label>
            <input type="text" placeholder="Nhập tên sản phẩm">
        </div>

        <div class="flex-container">
            <div class="form-group">
                <label>Size</label>
                <select>
                    <option></option>
                    <option></option>
                    <option>38</option>
                </select>
            </div>

            <div class="form-group">
                <label>Số lượng tồn kho</label>
                <input type="text" value="100" disabled>
            </div>
        </div>

        <div class="flex-container">
            <div class="form-group">
                <label>Giá</label>
                <input type="text" placeholder="Giá">
            </div>

            <div class="form-group">
                <label>Số lượng nhập</label>
                <input type="text" placeholder="Số lượng nhập">
            </div>
        </div>

        <div class="but-Contain">
            <button type="button" class="btn inButton">Thêm vào danh sách nhập</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Size</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="text-center">Chưa có mặt hàng nào</td>
            </tr>
        </tbody>
    </table>



    <div class="flex-container">
        <div class="form-group">
            <label>Nhà cung cấp</label>
            <select>
                <option>Golden Road Fashion</option>
                <option>ABC Shoes</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tổng tiền danh sách nhập</label>
            <input type="text" value="0đ" disabled>
        </div>
    </div>
    
    <div class="but-Contain">
        <button type="button" class="btn button-red">Nhập hàng</button>
    </div>
</div>


<style>
        /* Định dạng tổng thể */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 800px;
            background: white;
            padding: 20px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
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

        .button-redr:hover {
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
        .but-Contain{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

    </style>
