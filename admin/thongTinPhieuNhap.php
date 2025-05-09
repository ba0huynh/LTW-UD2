<?php 
session_start();
include_once "../database/database.php";
include_once "../database/phieunhap.php";
include_once "../database/chitietphieunhap.php";

$phieunhap = new PhieuNhap($pdo);

// Xử lý xóa
if (isset($_POST['delete-product'])) {
    $id = $_POST['id'];
    $result = $phieunhap->deleteById($id);
    echo json_encode(['success' => $result]);
    exit();
}

// Phân trang và tìm kiếm
$itemPerPage = 6;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : "";

$currentPage = max(1, $currentPage);
$offset = ($currentPage - 1) * $itemPerPage;

$totalItems = $phieunhap->countAllPhieuNhap($search);
$totalPages = ceil($totalItems / $itemPerPage);
$currentPage = min($currentPage, $totalPages);

$data = $phieunhap->getPhieuNhapPagination($offset, $itemPerPage, $search);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phiếu nhập</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/nhap.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: red;
            font-size: xx-large;
        }
    </style>
</head>
<body>
<main class="flex flex-row">
    <?php include_once './gui/sidebar.php' ?>
    <div class="flex items-center w-full h-screen justify-center">
        <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-6 w-[80%]">
            <h2 class="text-2xl font-bold mb-4">Thông tin phiếu nhập</h2>

            <!-- Ô tìm kiếm -->
            <div class="mb-4">
                <form method="GET" action="" class="flex items-center">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search) ?>" 
                           placeholder="Tìm kiếm theo người nhập..." 
                           class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </form>
            </div>
            
            <!-- Bảng dữ liệu -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người nhập</th>
                            <th>Tổng tiền</th>
                            <th>Ngày nhập</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Không tìm thấy phiếu nhập</td>
                            </tr>
                        <?php else: ?>
                            <?php $stt = ($currentPage - 1) * $itemPerPage + 1; ?>
                            <?php foreach ($data as $pn): ?>
                                <tr>
                                    <td class="text-center"><?php echo $stt++ ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($pn['ten_nguoi_nhap'] ?? $pn['idNguoiNhap']) ?></td>
                                    <td class="text-center"><?php echo number_format($pn['tongtien'], 0, ',', '.') . 'đ';?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($pn['date']) ?></td>
                                    <td class="text-center">
                                        <div class="actions">
                                            <a href="#" class="view" data-id="<?php echo $pn['id']; ?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button onclick="deleteProduct(<?php echo $pn['id'] ?>)" class="delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-4 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo $currentPage - 1 ?>&search=<?php echo urlencode($search) ?>" 
                           class="px-3 py-1 border rounded hover:bg-gray-100">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                    
                    if ($startPage > 1) {
                        echo '<a href="?page=1&search='.urlencode($search).'" class="px-3 py-1 border rounded hover:bg-gray-100">1</a>';
                        if ($startPage > 2) {
                            echo '<span class="px-3 py-1">...</span>';
                        }
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $activeClass = ($i == $currentPage) ? 'bg-blue-500 text-white' : 'hover:bg-gray-100';
                        echo '<a href="?page='.$i.'&search='.urlencode($search).'" class="px-3 py-1 border rounded '.$activeClass.'">'.$i.'</a>';
                    }
                    
                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                            echo '<span class="px-3 py-1">...</span>';
                        }
                        echo '<a href="?page='.$totalPages.'&search='.urlencode($search).'" class="px-3 py-1 border rounded hover:bg-gray-100">'.$totalPages.'</a>';
                    }
                    ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo $currentPage + 1 ?>&search=<?php echo urlencode($search) ?>" 
                           class="px-3 py-1 border rounded hover:bg-gray-100">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Modal hiển thị chi tiết -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modalBody"></div>
    </div>
</div>

<script>
// Xử lý mở modal khi click vào nút xem
$(document).ready(function() {
    // Khi nhấn vào nút "Xem"
    $(document).on('click', '.view', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        $.ajax({
            url: './chitietphieunhap.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                $('#modalBody').html(response);
                $('#detailModal').show();
            },
            error: function() {
                Swal.fire('Lỗi', 'Không thể tải dữ liệu chi tiết', 'error');
            }
        });
    });
    
    $('.close').click(function() {
        $('#detailModal').hide();
    });
    
    $(window).click(function(event) {
        if (event.target == document.getElementById('detailModal')) {
            $('#detailModal').hide();
        }
    });
});

function deleteProduct(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Bạn sẽ không thể hoàn tác lại hành động này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    'delete-product': 1,
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Đã xóa!',
                            'Phiếu nhập đã được xóa.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Lỗi!',
                            'Không thể xóa phiếu nhập.',
                            'error'
                        );
                    }
                }
            });
        }
    });
}
</script>
</body>
</html>