<?php

    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/book.php";

    $product = new BooksTable($pdo);
    $products = $product->getAllBook();

    if (isset($_POST['delete-product'])) {
        $id = $_POST['id'];
        $product->deleteById($id);
        exit();
    }

    $search = isset($_POST['valueSearch']) ? $_POST['valueSearch'] : "";

    $sql = "SELECT * FROM books
        WHERE books.status = 1";

    if ($search != "") {
        $sql .= " AND books.bookName like '%$search%'";
    }
    $products = $product->getBooksByCondition($sql);
?>


<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><div>Môn học</div></th>
                <th><div>Tên sách</div></th>
                <th><div>Lớp</div></th>
                <th><div>Giá cả</div></th>
                <th><div>Hình ảnh</div></th>
                <th><div>Số lượng bán</div></th>
                <th><div>Mô tả</div></th>

                <?php
                // if ($checkDeleteAndUpdate) {
                    ?>
                    <th>Chức năng</th>
                    <?php
                // }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!$products) {
                ?>

                <tr>
                    <td style="padding: 15px;" colspan="8">Không tìm thấy sản phẩm</td>
                </tr>
                <?php
            }
            $book = new BooksTable($pdo);
            $vnd ='đ';
            foreach ($products as $product) {
                ?>
                <tr>
                    <td>
                        <div>
                            <?php echo $book->getSubjectNameById($product['subjectId']) ?>
                        </div>
                        
                    </td>
                    <td>
                        <?php echo $product['bookName'] ?>
                    </td>
                    <td>
                        <div>
                            <?php echo $product['classNumber'] ?>
                        </div>
                    </td>
                    <td>
                        <div>
                        <?php echo $product['currentPrice'].$vnd; ?>
                        </div>
                    </td>
                    <td>
                        <?php
                        // $image = '.' . $product['image'] . "?" . time();
                        ?>
                        <div>
                        <img src="<?php echo $product['imageURL'] ?>" alt="" width="70" height="70">
                        </div>
                    </td>
                    <td>
                        <div>
                            <?php echo $product['quantitySold'] ?>
                        </div>
                        
                    </td>
                    <td>
                        <?php echo $product['description'] ?>
                    </td>

                    <td>
                        <div class="icon">
                            <i class="fa-solid fa-trash delete-icon" data-id="<?php echo $product['id'] ?>"></i>
                            <i id="openModalBtn" class="fa-regular fa-pen-to-square update-icon"  data-id="<?php echo $product['id'] ?>"></i>
                        </div>

                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>




<style>
.table-responsive{
    width: 100% !important;
    overflow-x: auto;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(33, 37, 41, 0.05);
}
.table-hover tbody tr:hover {
    background-color: rgba(33, 37, 41, 0.075);
}
.table > tbody > tr.active,
.table > tbody > tr.active > td {
    background-color: rgba(33, 37, 41, 0.1);
}
.table td:nth-child(3) div,
.table td:nth-child(6) div,
.table td:nth-child(4) div,
.table td:nth-child(5) div,
.table th:nth-child(3) div,
.table th:nth-child(6) div,
.table th:nth-child(4) div,
.table th:nth-child(5) div{
    text-align: center;
    padding: 20px;
}
.table th:nth-child(1),
.table td:nth-child(1) div{
    padding-left: 25px;
    padding-right: 15px;
}
.table th:nth-child(8){
    text-align: center;
    padding: 10px;
}
.table td:nth-child(8) {
    padding: 10px;
}
.th div{
    padding:150px;
}
.icon {
    display: flex;
    gap: 12px; 
    align-items: center;
}
.icon i {
    font-size: 20px;
    cursor: pointer;
    transition: color 0.2s ease;
}
.delete-icon {
    color: #C7422F;
}
.delete-icon:hover {
    color: #a00000;
    font-size: 23px;
}
.update-icon {
    color: #0079BC;
}
.update-icon:hover {
    color: #005f94;
    font-size: 23px;
}

</style>