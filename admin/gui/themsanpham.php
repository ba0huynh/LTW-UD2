<?php
// Bỏ qua output buffering phức tạp
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/book.php";

$product = new BooksTable($pdo);
$subjects = $product->getAllSubject();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $imageTmpName = $_FILES['imageFile']['tmp_name'];
        $imageName = uniqid() . '_' . basename($_FILES['imageFile']['name']);
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/LTW-UD2/images/Products/';
        $imagePath = $uploadDir . $imageName;
        
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            throw new Exception('Lỗi khi tải ảnh lên');
        }

        $dbImagePath = '/LTW-UD2/images/Products/' . $imageName;
        $result = $product->addBook(
            $_POST['name'],
            $_POST['subject'],
            $_POST['class'],
            $dbImagePath,
            $_POST['description']
        );

        if (!$result) {
            throw new Exception('Lỗi khi thêm vào database');
        }
        exit;
        
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit;
    }
}
?>

<form id="addProductForm" enctype="multipart/form-data">
    <br>
    <h2>Thêm sách</h2>

    <div class="addform-container">
        <div class="af-left">
            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; display: none;">
            <label for="imageFile" class="custom-file-upload">📁 Duyệt ảnh</label>
            <input type="file" id="imageFile" name="imageFile" accept="image/*" style="display: none;">
        </div>

        <div class="af-right">
            <label for="book-name">Tên sách:</label>
            <input type="text" id="book-name" name="name" required>
            <div class="af-right-top-container">
                <div class="af-right-top-left">
                    <label for="subject">Môn học:</label>
                    <select id="subject" name="subject" required>
                        <option value="">-- Chọn môn học --</option>
                        <?php foreach ($subjects as $sub): ?>
                            <option value="<?php echo $sub['id']; ?>"><?php echo $sub['subjectName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="af-right-top-right">
                    <label for="class">Lớp:</label>
                    <select id="class" name="class" required>
                        <option value="">-- Chọn lớp --</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>">Lớp <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
        </div>
    </div>

    <br>
    <div class="submit-container">
        <button type="submit">Thêm sách</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#imageFile').change(function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    $('#addProductForm').submit(function(e) {
        e.preventDefault();
        
        const name = $('#book-name').val().trim();
        const subject = $('#subject').val();
        const classVal = $('#class').val();
        const description = $('#description').val().trim();
        const imageFile = $('#imageFile')[0].files[0];
        
        let error = '';
        if (!name) error = 'Vui lòng nhập tên sách';
        else if (!subject) error = 'Vui lòng chọn môn học';
        else if (!classVal) error = 'Vui lòng chọn lớp';
        else if (!description) error = 'Vui lòng nhập mô tả';
        else if (!imageFile) error = 'Vui lòng chọn ảnh sách';
        
        if (error) {
            Swal.fire({
                title: 'Lỗi!',
                text: error,
                icon: 'error'
            });
            return;
        }
        
        Swal.fire({
            title: 'Xác nhận thêm sách?',
            text: "Bạn có chắc muốn thêm sách mới?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Đã thêm sách thành công',
                            icon: 'success'
                        }).then(() => {
                            $('#addProductForm')[0].reset();
                            $('#previewImg').attr('src', '').hide();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: xhr.responseText || 'Có lỗi xảy ra',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>



<style>
    * {
        box-sizing: border-box;
    }
    #addProductForm {
        max-width: 900px;
        margin: auto;
        padding: 20px 25px;
        background: #fff;
        border-radius: 8px;
        font-family: 'Public Sans', sans-serif;
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
    .addform-container {
        display: flex;
        gap: 20px;
    }
    .af-left {
        width: 29%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .af-left img {
        width: 100%;
        height: auto;
        border-radius: 6px;
        padding: 20px;
    }
    .af-right {
        width: 71%;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .af-right-top-container {
        display: flex;
        gap: 20px;
    }
    .af-right-top-left,
    .af-right-top-right {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    #addProductForm label {
        font-weight: 500;
        color: #444;
    }
    #addProductForm input,
    #addProductForm select{
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 18px;
        transition: border-color 0.3s;
        height: 45px;
    }
    #addProductForm textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 18px;
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
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    #addProductForm button[type="submit"]:hover {
        background-color: rgb(5, 96, 206);
    }
    .form-group.full-width {
        width: 100%;
    }
    .custom-file-upload {
        width: 150px;
        display: inline-block;
        padding: 8px 16px;
        background-color: #007bff;
        color: white !important;
        font-weight: 500;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }
    .custom-file-upload:hover {
        background-color: #0056b3;
    }
</style>