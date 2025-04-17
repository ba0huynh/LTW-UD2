<form id="addProductForm">
    <h2>Thêm sách</h2>

    <div class="form-row">
        <div class="form-group">
            <label for="book-name">Tên sách:</label>
            <input type="text" id="book-name" name="name" required>
        </div>

        <div class="form-group">
            <label for="class">Lớp:</label>
            <select id="class" name="class" required>
                <option value="">-- Chọn lớp --</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == 1) ? 'selected' : ''; ?>>
                        Lớp <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="subject">Môn học:</label>
            <select id="subject" name="subject" required>
                <option value="">-- Chọn môn học --</option>
                <?php foreach ($subjects as $sub): ?>
                    <option value="<?php echo $sub['id']; ?>" <?php echo ($sub['id'] == 1) ? 'selected' : ''; ?>>
                        <?php echo $sub['subjectName']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" id="price" name="price" required>
        </div>
    </div>

    <div class="form-group full-width">
        <label for="image-url">Hình ảnh (đường dẫn):</label>
        <input type="text" id="image-url" name="image" required>
    </div>

    <div class="form-group full-width">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea>
    </div>

    <div class="submit-container">
        <button type="submit">Thêm sách</button>
    </div>
</form>


<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    #addProductForm {
        width: 100%;
        min-width: 300px;
        max-width: 800px;
        margin: auto;
        padding: 20px 25px;
        background: #fff;
        border-radius: 8px;
        font-family: 'Public Sans', sans-serif;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    #addProductForm h2 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-align: center;
    }

    .form-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .full-width {
        width: 100%;
    }

    #addProductForm label {
        font-weight: 500;
        color: #444;
        margin-bottom: 5px;
    }

    #addProductForm input,
    #addProductForm select,
    #addProductForm textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        transition: border-color 0.3s;
    }

    #addProductForm input:focus,
    #addProductForm select:focus,
    #addProductForm textarea:focus {
        border-color: #5da3fa;
        outline: none;
    }

    #addProductForm textarea {
        resize: vertical;
        min-height: 80px;
    }

    .submit-container {
        text-align: center;
        margin-top: 10px;
    }

    #addProductForm button[type="submit"] {
        background-color: #5da3fa;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #addProductForm button[type="submit"]:hover {
        background-color: #428fef;
    }
</style>
