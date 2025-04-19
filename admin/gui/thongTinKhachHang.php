<div class="kh-container">
    <h2 class="kh-title">Thông tin khách hàng</h2>
    
    <div class="kh-filter-container">
        <div class="kh-display-control">
            <label class="kh-label" for="kh-show-number">Hiển thị</label>
            <input type="number" class="kh-input-number kh-show-number" value="10" min="0">
            <span class="kh-label">dòng</span>
        </div>
        <div class="kh-search-box">
            <label class="kh-label" for="kh-search-input">Tìm kiếm</label>
            <input type="text" class="kh-input-text kh-search-input" required>
        </div>
    </div>

    <table class="kh-table">
        <thead>
            <tr>
                <th class="kh-th">Tên</th>
                <th class="kh-th">Số điện thoại</th>
                <th class="kh-th">Avatar</th>
                <th class="kh-th">Tình trạng</th>
            </tr>
        </thead>
        <tbody class="kh-tbody">
            <!-- <tr class="kh-empty-row">
                <td colspan="4">Không tìm thấy khách hàng</td>
            </tr> -->
            <tr class="kh-tr">
                <td class="kh-td">Nguyễn Văn A</td>
                <td class="kh-td">0912345678</td>
                <td class="kh-td">
                    <img class="kh-avatar-img" src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Avatar">
                </td>
                <td class="kh-td">Đang hoạt động</td>
            </tr>
        </tbody>
    </table>

    <div class="kh-pagination">
        <button class="kh-pagination-btn">&laquo;</button>
        <button class="kh-pagination-btn">&raquo;</button>
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

    .kh-container {
        width: 90%;
        max-width: 1200px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .kh-title {
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    .kh-filter-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .kh-display-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kh-label {
        font-size: 14px;
        color: #6c757d;
        font-weight: bold;
    }

    .kh-input-number,
    .kh-input-text {
        width: 60px;
        padding: 6px;
        font-size: 14px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .kh-input-text {
        width: 150px;
    }

    .kh-search-box {
        margin-left: auto;
    }

    .kh-table {
        width: 100%;
        border-collapse: collapse;
    }

    .kh-th {
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        color: #333;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    .kh-td {
        font-size: 14px;
        background-color: #f8f9fa;
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .kh-avatar-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .kh-empty-row {
        background-color: #f1f1f1;
        font-weight: bold;
        color: #6c757d;
        text-align: center;
    }

    .kh-pagination {
        display: flex;
        justify-content: right;
        margin-top: 10px;
    }

    .kh-pagination-btn {
        border: 1px solid #ccc;
        background-color: white;
        color: #333;
        padding: 6px 12px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 50%;
        margin: 0 5px;
    }

    .kh-pagination-btn:hover {
        background-color: #ddd;
    }
</style>
