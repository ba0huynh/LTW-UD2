<div class="sp-container">
    <h2 class="title">Thông tin sản phẩm</h2>

    <div class="tool">
        <div class="search">
            <!-- <input type="text" id="searchInput" placeholder="Tìm kiếm" class="search-bar" /> -->
                <input type="text" name="searchInput" id="searchInput" placeholder="Tìm kiếm" class="search-bar" />
            
            
        </div>
    </div>
    <div class="table-container">
        <?php require_once "thongtinsanpham.php" ?>
    </div>



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