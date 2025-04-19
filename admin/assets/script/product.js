$(document).ready(function () {
    $('#searchInput').on('keyup change', function () {
        let keyword = $(this).val();

        $.ajax({
            type: 'POST',
            url: './gui/thongtinsanpham.php',
            data: {
                valueSearch: keyword
            },
            success: function (response) {
                $('.table-container').html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX lỗi:", error);
                console.log("Status:", status);
                console.log("Response:", xhr.responseText);
            }
        });
    });
});

function loadProducts(page = 1, search = "") {
    $.ajax({
        type: 'POST',
        url: './gui/thongtinsanpham.php',
        data: {
            valueSearch: search,
            currentPage: page
        },
        success: function (response) {
            $('.table-container').html(response);
        },
        error: function (xhr, status, error) {
            console.error("AJAX lỗi:", error);
        }
    });
}

$(document).on('keyup change', '#searchInput', function () {
    const keyword = $(this).val();
    loadProducts(1, keyword);
});

$(document).on('click', '.page-number', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    const search = $('#searchInput').val();
    loadProducts(page, search);
});

$(document).on('click', '.delete-icon', function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Bạn muốn xóa sản phẩm?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy bỏ",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Đã xóa sản phẩm",
                text: "",
                icon: "success",
            });
            $.ajax({
                type: "POST",
                url: "./gui/thongtinsanpham.php",
                data: {
                    id: id,
                    "delete-product": true,
                },
                dataType: "html",
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        url: "./gui/sanphan.php",
                        dataType: "html",
                        success: function (response) {
                            $('.sp-container').html(response);
                        },
                    });

                },
            });
        }
    });
});

$(document).on("click", ".update-icon", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $.ajax({
        type: "POST",
        url: "./gui/modalsp.php",
        data: {
            id: id,
            "update-product": true,
        },
        dataType: "html",
        success: function (response) {
            $(".modal-content").html(response);
            $("#myModal").css("display", "flex");

            $('#book-name').data('original', $('#book-name').val());
            $('#subject').data('original', $('#subject').val());
            $('#class').data('original', $('#class').val());
            $('#image-url').data('original', $('#image-url').val());
            $('#description').data('original', $('#description').val());
        },
        error: function () {
            alert("Có lỗi xảy ra khi lấy dữ liệu sản phẩm.");
        },
    });
});
$(window).on("click", function (event) {
    if ($(event.target).is("#myModal")) {
        $("#myModal").css("display", "none");
    }
});

function checkImageExists(url, callback) {
    const img = new Image();
    img.onload = function () {
        callback(true);
    };
    img.onerror = function () {
        callback(false);
    };
    img.src = url;
}

$(document).on("change", "#image-url", function () {
    const $input = $(this);
    const newUrl = $input.val().trim();
    const oldUrl = $input.data("original") || $input.attr("value");

    if (newUrl !== "") {
        checkImageExists(newUrl, function (exists) {
            if (!exists) {
                Swal.fire({
                    icon: "error",
                    title: "Hình ảnh không hợp lệ",
                    text: "Không tìm thấy ảnh từ đường dẫn bạn nhập.",
                });
                $input.val(oldUrl);
            } else {
                if (!$input.data("original")) {
                    $input.data("original", newUrl);
                }
            }
        });
    }
});


$(document).on("change", "#book-name", function () {
    const $input = $(this);
    const value = $input.val().trim();
    const original = $input[0].defaultValue;

    if (value === "") {
        Swal.fire({
            icon: "error",
            title: "Lỗi nhập liệu",
            text: "Tên sách không được để trống!",
        });
        $input.val(original);
    }
});


$(document).on("change", "#description", function () {
    const $textarea = $(this);
    const value = $textarea.val().trim();
    const original = $textarea.data("original");

    if (value === "") {
        Swal.fire({
            icon: "error",
            title: "Lỗi nhập liệu",
            text: "Mô tả không được để trống!",
        });

        $textarea.val(original);
    }
});

$(document).on('submit', '#editProductForm', function (e) {
    e.preventDefault();


    if (!hasChanges()) {
        Swal.fire({
            icon: "info",
            title: "Không có thay đổi",
            text: "Không có thay đổi nào để cập nhật!",
        });
        return;
    }


    let formData = new FormData(this);

    Swal.fire({
        title: "Bạn muốn cập nhật sản phẩm này?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Cập nhật",
        cancelButtonText: "Hủy bỏ",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: "./gui/modalsp.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: "Cập nhật thành công!",
                        icon: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });

                    $.ajax({
                        type: "POST",
                        url: "./gui/sanphan.php",
                        success: function (response) {
                            $('.sp-container').html(response);
                            $('#myModal').css('display', 'none');
                        }
                    });
                },
                error: function () {
                    Swal.fire({
                        title: "Có lỗi xảy ra trong quá trình cập nhật!",
                        icon: "error",
                    });
                }
            });
        }
    });
});


function hasChanges() {
    let isChanged = false;

    if ($('#book-name').val() !== $('#book-name').data('original')) isChanged = true;
    if ($('#subject').val() !== $('#subject').data('original')) isChanged = true;
    if ($('#class').val() !== $('#class').data('original')) isChanged = true;
    if ($('#image-url').val() !== $('#image-url').data('original')) isChanged = true;
    if ($('#description').val() !== $('#description').data('original')) isChanged = true;

    return isChanged;
}

