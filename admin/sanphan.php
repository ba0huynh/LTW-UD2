<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/script/product.js"></script>
    
</head>
<body>
<main class="flex flex-row">
        <?php include_once './gui/sidebar.php' ?>
        <div class="flex items-center w-full h-screen justify-center">
            <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-6 w-[80%]">





            <div class="sp-container">
    <h2 class="title">Thông tin sản phẩm</h2>

    <div class="tool">
        <div class="search">
            <!-- <input type="text" id="searchInput" placeholder="Tìm kiếm" class="search-bar" /> -->
                <input type="text" name="searchInput" id="searchInput" placeholder="Tìm kiếm" class="search-bar" />
            
            
        </div>
    </div>
    <div class="table-container">
        <?php require_once "./thongtinsanpham.php" ?>
    </div>


            





            </div>
            </div>
</main>
</body>
</html>






<style>
.sp-container{
    margin: 27px;
} 
.title {
    font-size: 23px;
    font-weight: 600;
    color: #444;
    line-height: 30px;
    margin-bottom: 20px;
}
.search-bar {
    font-size: 1rem;
    border-color: #ebedf2;
    padding: .6rem 1rem;
    height: inherit !important;
    border-width: 2px;
    width: 30%;
}
.table-container {
    color: #212529;
    background-color: #fff;
    border-color: #dee2e6;
    width: 100%;
    margin-bottom: 1rem;
    vertical-align: top;
}
</style>








