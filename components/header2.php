<?php


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $query_count_cart = "
    SELECT COUNT(*) as total 
    FROM cart 
    JOIN cartitems ON cartitems.cartId = cart.idCart 
    WHERE cart.idUser = $user_id
  ";

  $result = $conn->query($query_count_cart);
  $countOfCart = $result->fetch_assoc()['total'];
}


?>
        <div class="relative mx-auto w-full flex items-center justify-between py-2 px-[10%] bg-white shadow-sm">
          <div class="flex items-center gap-2">
            <a href="/LTW_UD2/"><img src="/LTW_UD2/images/forHeader/logo.jpg" alt="Logo" class="h-12"></a>
          </div>
          <img src="/LTW_UD2/images/menulogo.png" alt="" class=" h-10" id="menuTrigger">
          <div class="flex-1 max-w-2xl mx-4">
            <form action="/LTW_UD2/searchPage.php" method="GET" class="flex rounded border border-gray-300 overflow-hidden">
              <input
                type="text"
                name="search"
                placeholder="Tìm kiếm"
                class="flex-1 px-4 py-2 outline-none text-sm"
                required
              />
              <button type="submit" class="bg-[#D10024] px-4 text-white m-2 rounded">
                🔍
              </button>
            </form>

            </div>
            <div class="flex items-center gap-4 text-sm text-gray-600">
            <!-- Thông báo -->

            <div class="flex flex-col items-center">
              <div onclick="toggleNoti()" class="cursor-pointer text-center">
                <span class="text-xl">🔔</span><br>
                <span>Thông Báo</span>
              </div>

              <!--  -->
              <div id="notificationPanel" class=" hidden absolute right-50 mt-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-30">
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
SELECT 
  hoadon.idBill,
  hoadon.statusBill,
  hoadon.create_at AS thoigianmoi,
  hoadon_trangthai.trangthai AS trangthai_cu,
  hoadon_trangthai.create_at AS thoigiancu,
  books.bookName
FROM hoadon
LEFT JOIN hoadon_trangthai ON hoadon_trangthai.idBill = hoadon.idBill
JOIN chitiethoadon ON chitiethoadon.idHoadon = hoadon.idBill
JOIN books ON books.id = chitiethoadon.idBook
WHERE hoadon.idUser = $user_id
ORDER BY hoadon_trangthai.create_at DESC, hoadon.create_at DESC;

                    ";



                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        if (!empty($row['trangthai_cu'])) {
    $status = $row['trangthai_cu']; // trạng thái trong hoadon_trangthai
    $time = $row['thoigiancu'];
    $isOld = true;
} else {
    $status = $row['statusBill']; // trạng thái hiện tại trong hoadon
    $time = $row['thoigianmoi'];
    $isOld = false;
}
                        $icons = [
  1 => '📦', 2 => '🚚',
  3 => '✅', 4 => '↩️', 6 => '❌'
];

$texts = [
  1 => 'Đang xử lý',
  2 => 'Đang được giao', 3 => 'Giao hàng thành công',
  4 => 'Đơn hàng đã trả', 5 => 'Đơn hàng đã bị hủy'
];

$icon = $icons[$status] ?? 'ℹ️';
$text = $texts[$status] ?? 'Không xác định';
                  ?>

                        <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                          <div class="flex gap-3 items-start p-3 rounded-xl hover:bg-blue-50 transition duration-200">
                            <div class="bg-blue-100 text-blue-600 rounded-full p-2 shadow-sm">
                              <?= $icon ?>
                            </div>

                            <div class="flex-1 space-y-1">
                              <div class=" bg-gray-50 px-2 py-1 rounded-md shadow-sm text-gray-700 text-sm inline-block mb-2">
                                📅 : <?php echo $time ?> 
                              </div>

                              <!-- Thông báo -->
                              <p class="text-sm text-gray-700 leading-snug">
                                <span class="font-semibold text-gray-900">Sản phẩm:</span>
                                <span class="text-gray-800"><?= htmlspecialchars($row['bookName']) ?></span><br>
                                <span class="text-gray-500">Tình trạng:</span>
                                <span class="text-blue-600 font-medium"><?= $text ?></span>
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
                      <a href="/LTW_UD2/account.php">Đăng nhập </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>

<!-- 1.đang xử lí 📦(đợi duyệt hoặc hủy)trang duyệt/hủy-->
<!-- 2.đang được giao (duyệt xong chuyển sang đang xử lí giao hàng hoặc hủy) trang xử lí giao hàng 🚚-->
<!-- 3.giao hàng thành công ✅ ( giao xong hiện trong danh sách đơn hàng hoàn thành )danh sách đơn hàng hoàn thành-->
<!-- 4.đơn hàng đã trả ↩️ (các đơn hàng trong 10 ngày đầu được khách ấn trả)trang trả hàng/hủy-->
<!-- 5.đơn hàng đã bị hủy ❌-->
 








              <!--  -->
            </div>
            <!-- Giỏ hàng -->
             <a href="/LTW_UD2/zui/cart.php">

                 <div class="relative flex flex-col items-center">
                     
                    
                    <span class="text-xl">🛒  </span>
                    <span>Giỏ hàng</span>
                    <span id="cart-count" class="absolute -top-1 -right-2 text-xs bg-red-600 text-white rounded-full px-1">
                      <?php echo $countOfCart ?? 0 ?>
                    </span>

                </div>
            </a>




      
            <!-- Tài khoản -->
            <div class="flex flex-col items-center">
                <span class="text-xl"><a href="/LTW_UD2/account.php">👤</a></span>
                <a href="/LTW_UD2/account.php">Tài khoản</a>

            </div>
      
            <!-- Quốc kỳ -->
            <div id="vietNam" >
                <img  src="./images/forHeader/vietNam.png" alt="">

            </div>
            <a href="/LTW_UD2/components/logout.php"
              class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
              </svg>
            </a>
          </div>

      
<!-- MENU CONTENT -->
<div id="menuContent" class="menuContent hidden absolute top-full left-10 bg-white shadow-lg z-50 w-[90vw] rounded-xl overflow-hidden ">

  <div class="flex min-h-[300px]">

    <!-- SIDEBAR: Danh sách lớp -->
    <div class="w-60 bg-white border-r">
      <?php for ($i = 6; $i < 13; $i++) { ?>
        <div class="tablinks px-4 py-3 hover:bg-gray-100 cursor-pointer text-sm font-medium border-l-4 border-transparent hover:border-pink-500 transition-all"
             data-id="<?php echo $i; ?>">
          Lớp <?php echo $i ?>
        </div>
      <?php } ?>
    </div>

    <!-- NỘI DUNG CHI TIẾT -->
    <div class="flex-1 p-6">
      <div class="flex items-center gap-2 mb-4">
        <img src="./images/forHeader/menuBook.png" alt="" class="w-5 h-5">
        <span class="font-bold text-sm uppercase">Sách trong nước</span>
      </div>

      <div class="detailMenu grid grid-cols-2 gap-6 text-sm text-gray-700">

      </div>
    </div>
  </div>
</div>

          <div id="menuContent" class="menuContent hidden absolute top-full left-0  bg-white shadow-lg z-50">
                <div class="sideBarMenu">
                    <?php
                    for($i=6;$i<13;$i++){
                    ?>
                    <div class="tablinks " data-id="<?php echo $i;?>">Lớp <?php echo $i?></div>
                    <?php
                    }
                    ?>
                    <script>
                        document.querySelectorAll(".tablinks").forEach(tab=>{
                            tab.addEventListener("mouseenter",function(){
                                let Class=this.dataset.id;
                                openTab(this,Class);
                            })
                        })
                        function openTab(tab,Class){

                            const Tablinks=document.querySelectorAll(".tablinks");
                            for(let i=0;i<Tablinks.length;i++){
                                Tablinks[i].className=Tablinks[i].className.replace(" onTab","");
                            }
                            tab.classList.add("onTab");
                        }
                    </script>

                </div>
                <div class="line"></div>
                <div style="width: 100%;">
                    <div> 
                        <div><img src="./images/forHeader/menuBook.png" alt="">
                    </div>SÁCH TRONG NƯỚC</div>
                    <div class="detailMenu">
                        <!-- div*3 -->
                    </div>
                    <script>
                        const detailMenu=document.querySelector(".detailMenu");
                        const tablinks=document.querySelectorAll(".tablinks");
                        tablinks.forEach(tab=>{
                            tab.addEventListener("mouseenter",function(){
                                const Class=this.dataset.id;
                                fetch(`contentMenu.php/?Class=${Class}`).
                                then(response=>response.text()).
                                then(data=>{
                                    detailMenu.innerHTML=data;
                                })
                            })
                        })

                    </script>
                </div>
            </div>

            </div>
        </div>


      <script>
  const menuTrigger = document.getElementById('menuTrigger');
  const menuContent = document.getElementById('menuContent');

  menuTrigger.addEventListener('click', () => {
    menuContent.classList.toggle('hidden');
  });

  // Nếu bạn muốn ấn ra ngoài để ẩn luôn menu:
  document.addEventListener('click', (e) => {
    if (!menuTrigger.contains(e.target) && !menuContent.contains(e.target)) {
      menuContent.classList.add('hidden');
    }
  });
</script>

    
<script>


function showNoti() {
    clearTimeout(timeout);
    notiPanel.classList.remove('hidden');
}

function hideNoti() {
    timeout = setTimeout(() => {
    notiPanel.classList.add('hidden');
    }, 200);
}
                        
</script>
<script>
  const notiPanel = document.getElementById('notificationPanel');

  function toggleNoti() {
    notiPanel.classList.toggle('hidden');
  }

  // Nếu bạn muốn click ra ngoài sẽ tự ẩn panel:
  document.addEventListener('click', function (e) {
    const trigger = e.target.closest('[onclick="toggleNoti()"]');
    if (!trigger && !notiPanel.contains(e.target)) {
      notiPanel.classList.add('hidden');
    }
  });
</script>




                        