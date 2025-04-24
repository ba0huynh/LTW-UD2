<div id="notificationPanel" class="hidden absolute right-0 mt-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-30">
                <!-- Tiêu đề -->
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                  <h3 class="font-semibold text-gray-800 flex items-center gap-2 text-base">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Thông báo
                  </h3>
                </div>

                <ul class="divide-y divide-gray-200 max-h-72 overflow-y-auto">
                  <?php
                  if (!empty($user_id)) {
                    $query = "
                      SELECT * 
                      FROM hoadon 
                      JOIN hoadon_trangthai ON hoadon_trangthai.idBill = hoadon.idBill
                      JOIN chitiethoadon ON chitiethoadon.idHoadon = hoadon.idBill
                      JOIN books ON books.id = chitiethoadon.idBook
                      WHERE hoadon.idUser = $user_id
                      ORDER BY hoadon_trangthai.thoigian DESC
                    ";

                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        switch ($row['statusBill']) {
                          case 1:
                            $text = "đã được nhận";
                            break;
                          case 2:
                            $text = "đang xử lý";
                            break;
                          case 3:
                            $text = "đang được giao";
                            break;
                          case 4:
                            $text = "giao hàng thành công";
                            break;
                          case 5:
                            $text = "đơn hàng đã trả";
                            break;
                          case 6:
                            $text = "đơn hàng đã bị hủy";
                            break;
                          default:
                            $text = "không xác định";
                            break;
                        }
                  ?>
                        <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                          <div class="flex gap-3 items-start">
                            <div class="bg-blue-100 text-blue-600 rounded-full p-2">📦</div>
                            <div class="flex-1">
                              <p class="font-medium text-gray-800">
                                sản phẩm #<?= htmlspecialchars($row['bookName']) ?> - <?= $text ?>
                              </p>
                            </div>
                          </div>
                        </li>
                  <?php
                      }
                    }
                  } else {
                  ?>
                    <li class="px-4 py-3 text-center text-blue-600 hover:text-blue-800">
                      <a href="/LTW_UD2/account.php">Đăng nhập để xem thông báo</a>
                    </li>
                  <?php } ?>
                </ul>
              </div>