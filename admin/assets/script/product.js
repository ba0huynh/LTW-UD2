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

$(document).on('click', '.check-icon', function () {
    const icon = $(this);
    const id = icon.data('id');
    const isCurrentlyActive = icon.hasClass('fa-toggle-on');
    const newStatus = isCurrentlyActive ? 0 : 1;

    const title = newStatus === 1 ? "Bạn muốn cho phép bán sản phẩm này?" : "Bạn muốn ngừng bán sản phẩm này?";

    Swal.fire({
        title: title,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "./gui/thongtinsanpham.php",
                data: {
                    id: id,
                    isActive: newStatus,
                    "update-status": true
                },
                dataType: "json",
                success: function (response) {
                    if (response && response.success) {
                        // Cập nhật trực tiếp icon mà không cần load lại trang
                        if (newStatus === 1) {
                            icon.removeClass('fa-toggle-off').addClass('fa-toggle-on');
                            icon.css('color', 'green');
                            icon.attr('title', 'Đang bán');
                        } else {
                            icon.removeClass('fa-toggle-on').addClass('fa-toggle-off');
                            icon.css('color', 'red');
                            icon.attr('title', 'Ngừng bán');
                        }

                        Swal.fire("Thành công", response.message, "success");
                    } else {
                        const errorMsg = response && response.message ? response.message : "Không thể cập nhật trạng thái!";
                        Swal.fire("Lỗi", errorMsg, "error");
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire("Lỗi", "Lỗi kết nối đến server: " + error, "error");
                }
            });
        }
    });
});
//===================================================================================



$(document).on("click", ".update-icon", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    console.log(id);
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

            // $('#book-name').data('original', $('#book-name').val());
            // $('#subject').data('original', $('#subject').val());
            // $('#class').data('original', $('#class').val());
            // $('#image-url').data('original', $('#image-url').val());
            // $('#description').data('original', $('#description').val());
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





















































//=============================


// $(document).ready(function () {
//     // Mở modal sửa sản phẩm
//     $(document).on("click", ".update-icon", function (e) {
//         e.preventDefault();
//         const id = $(this).data("id");

//         // Hiển thị loading khi đang tải dữ liệu
//         $(".modal-content").html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-3x"></i><p>Đang tải dữ liệu...</p></div>');
//         $("#myModal").css("display", "flex");

//         $.ajax({
//             type: "POST",
//             url: "./gui/modalsp.php",
//             data: {
//                 id: id,
//                 "update-product": true
//             },
//             dataType: "html",
//             success: function (response) {
//                 $(".modal-content").html(response);

//                 // Xử lý sự kiện submit form sau khi tải xong
//                 $("#editProductForm").submit(function (e) {
//                     e.preventDefault();

//                     // Validate form
//                     const name = $('#book-name').val().trim();
//                     const subject = $('#subject').val();
//                     const classVal = $('#class').val();
//                     const description = $('#description').val().trim();

//                     if (!name || !subject || !classVal || !description) {
//                         Swal.fire({
//                             icon: "error",
//                             title: "Lỗi",
//                             text: "Vui lòng điền đầy đủ thông tin!"
//                         });
//                         return;
//                     }

//                     Swal.fire({
//                         title: 'Xác nhận cập nhật?',
//                         text: "Bạn có chắc muốn cập nhật thông tin sách?",
//                         icon: 'question',
//                         showCancelButton: true,
//                         confirmButtonColor: '#3085d6',
//                         cancelButtonColor: '#d33',
//                         confirmButtonText: 'Xác nhận',
//                         cancelButtonText: 'Hủy'
//                     }).then((result) => {
//                         if (result.isConfirmed) {
//                             const formData = new FormData(this);

//                             $.ajax({
//                                 url: "./gui/modalsp.php",
//                                 type: "POST",
//                                 data: formData,
//                                 processData: false,
//                                 contentType: false,
//                                 success: function (response) {
//                                     try {
//                                         const data = JSON.parse(response);
//                                         if (data.success) {
//                                             Swal.fire({
//                                                 title: 'Thành công!',
//                                                 text: 'Cập nhật sách thành công',
//                                                 icon: 'success'
//                                             }).then(() => {
//                                                 location.reload();
//                                             });
//                                         } else {
//                                             throw new Error(data.error || 'Có lỗi xảy ra');
//                                         }
//                                     } catch (e) {
//                                         Swal.fire({
//                                             title: 'Lỗi!',
//                                             text: e.message,
//                                             icon: 'error'
//                                         });
//                                     }
//                                 },
//                                 error: function (xhr) {
//                                     Swal.fire({
//                                         title: 'Lỗi!',
//                                         text: xhr.responseText || 'Có lỗi khi cập nhật',
//                                         icon: 'error'
//                                     });
//                                 }
//                             });
//                         }
//                     });
//                 });
//             },
//             error: function (xhr) {
//                 let errorMsg = "Có lỗi xảy ra khi lấy dữ liệu sản phẩm";
//                 try {
//                     const response = JSON.parse(xhr.responseText);
//                     if (response.error) errorMsg = response.error;
//                 } catch (e) { }

//                 $(".modal-content").html(`
//                     <div class="error-message text-center py-4">
//                         <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
//                         <h4>${errorMsg}</h4>
//                         <button class="btn btn-secondary mt-3" onclick="$('#myModal').hide()">Đóng</button>
//                     </div>
//                 `);
//             }
//         });
//     });


//     // Xử lý preview ảnh
//     $(document).on("change", "#imageFile", function (e) {
//         const file = this.files[0];
//         if (file) {
//             // Kiểm tra kích thước ảnh (tối đa 5MB)
//             if (file.size > 5 * 1024 * 1024) {
//                 Swal.fire({
//                     icon: "error",
//                     title: "Lỗi",
//                     text: "Ảnh tải lên không được vượt quá 5MB"
//                 });
//                 $(this).val('');
//                 return;
//             }
//             // Kiểm tra loại file
//             const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
//             if (!validTypes.includes(file.type)) {
//                 Swal.fire({
//                     icon: "error",
//                     title: "Lỗi",
//                     text: "Chỉ chấp nhận file ảnh (JPEG, PNG, GIF)"
//                 });
//                 $(this).val('');
//                 return;
//             }

//             // Hiển thị preview
//             const reader = new FileReader();
//             reader.onload = function (e) {
//                 $('#previewImg').attr('src', e.target.result);
//             };
//             reader.readAsDataURL(file);
//         }
//     });
// });