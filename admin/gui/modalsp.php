<?php

    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/book.php";

    $product = new BooksTable($pdo);

    if (isset($_POST['name'], $_POST['subject'], $_POST['class'], $_POST['image'], $_POST['description'], $_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $class = $_POST['class'];
        $image = $_POST['image'];
        $description = $_POST['description'];

        $subjectId = $subject;

        $updateSuccess = $product->updateBook($id,$name, $subjectId, $class, $image, $description); 

        echo $updateSuccess ? "success" : "error";
        exit; 
    }

    if (isset ($_POST['update-product'])) {
        $id = $_POST['id'];
        $products = $product->getBookById($id);
        $img = $products['imageURL'];
        $name = $products['bookName'];
        $sId = $products['subjectId'];
        $subject = $product->getSubjectNameById($sId);
        $class = $products['classNumber'];
        $price = $products['currentPrice'];
        $description = $products['description'];
        $subjects = $product->getAllSubject();
    }
?>

<h3>Cập nhật thông tin sách</h3>
<form id="editProductForm">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <label for="book-name">Tên sách:</label>
    <input type="text" id="book-name" name="name" value="<?php echo $name ?>" required>

    <label for="subject">Môn học:</label>
    <select id="subject" name="subject" required>
        <option value="">-- Chọn môn học --</option>
        <?php foreach ($subjects as $sub): ?>
            <option value="<?php echo $sub['id']; ?>" <?php if ($sub['subjectName'] == $subject) echo 'selected'; ?>>
                <?php echo $sub['subjectName']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="class">Lớp:</label>
    <select id="class" name="class" required>
        <option value="">-- Chọn lớp --</option>
        <?php 
            for ($i = 1; $i <= 12; $i++) { 
                $selected = ($i == $class) ? 'selected' : ''; 
        ?>
            <option value="<?php echo $i; ?>" <?php echo $selected; ?>>Lớp <?php echo $i; ?></option>
        <?php } ?>
    </select>

    <label for="image-url">Hình ảnh (đường dẫn):</label>
    <input type="text" id="image-url" name="image" value="<?php echo $img ?>" required>

    <label for="price">Giá:</label>
    <input type="text" id="price" name="price" value="<?php echo $price ?>" readonly>

    <label for="description">Mô tả:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

    <button type="submit">Lưu thay đổi</button>
</form>




<!-- 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
 -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
 <style>
.modal {font-family: 'Poppins', sans-serif;}




.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    /* display: flex; */
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 50%;
    min-width: 400px;
    max-width: 600px;
    padding: 25px 45px;
}

.modal-content input,
.modal-content select,
.modal-content textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.modal-content button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: calc(50% - 68px);
}

.modal-content button:hover {
    background-color: #0056b3;
}

.swal2-container {
    z-index: 10000 !important;
}

.modal-content h3 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}


 </style>