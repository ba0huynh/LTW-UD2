<?php


$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']: 0;
$query_count_cart="select count(*) as total from cart,users,cartitems where cart.idUser=users.id and cartitems.cartId=cart.idCart";
$query_count_cart=$conn->query($query_count_cart);
$countOfCart=$query_count_cart->fetch_assoc()['total'];

?>
        <div class="relative mx-auto w-full flex items-center justify-between py-2 px-[10%] bg-white shadow-sm">
          <div class="flex items-center gap-2">
            <a href="/LTWUD2/"><img src="/LTWUD2/images/forHeader/logo.jpg" alt="Logo" class="h-12"></a>
          </div>
          <img src="/LTWUD2/images/menulogo.png" alt="" class=" h-10" id="menuTrigger">
          <div class="flex-1 max-w-2xl mx-4">
            <form action="/LTWUD2/searchPage.php" method="GET" class="flex rounded border border-gray-300 overflow-hidden">
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
              


                <div id="notificationPanel" class="hidden absolute right-60 mt-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50 ">
                    <!-- Tiêu đề -->
                    <div class="flex justify-between items-center p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2 text-base">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg> 
                        Thông báo
                        </h3>
                        <?php if(isset($_SESSION["user_id"])){?>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Xem tất cả</a>
                        <?php }?>
                    </div>
                
                    <!-- Danh sách thông báo -->
                    <ul class="divide-y divide-gray-200 max-h-72 overflow-y-auto">
                        <!-- <?php
                        //$query="select * from hoadon,chitiethoadon,hoadonxuat where hoadon.idBill=chitiethoadon.idBill and hoadonxuat.idBill=hoadon.idBill";
                        ?>
                        
                        <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                            <div class="flex gap-3 items-start">
                                <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                                📦
                                </div>
                                <div class="flex-1">
                                <p class="font-medium text-gray-800">Đơn hàng đã được xác nhận</p>
                                <p class="text-sm text-gray-500">Mã đơn #12345 đã được xử lý thành công</p>
                                <span class="text-xs text-gray-400">2 phút trước</span>
                                </div>
                            </div>
                        </li> -->
                        <?php
                        if(!empty($user_id)){
                        ?>
                        <?php
                        $query = "SELECT hoadon.idBill, hoadon.statusBill, hoadonxuat.status AS statusXuat 
                                FROM hoadon 
                                JOIN chitiethoadon ON hoadon.idBill = chitiethoadon.idHoadon
                                JOIN hoadonxuat ON hoadon.idBill = hoadonxuat.idBill and hoadon.idUser=$user_id";

                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            // Trạng thái duyệt đơn
                            $duyet = $row['statusBill'] == 1 ? "Đã duyệt" : "Chưa duyệt";

                            // Trạng thái giao hàng
                            $giaohang = $row['statusXuat'] == 1 ? "Đã giao hàng" : "Chưa giao hàng";
                        ?>
                            <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                                <div class="flex gap-3 items-start">
                                    <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                                        📦
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">Mã đơn #<?= $row['idBill'] ?> - <?= $duyet ?></p>
                                        <p class="text-sm text-gray-500">Mã đơn #<?= $row['idBill'] ?> - <?= $giaohang ?></p>
                                        <span class="text-xs text-gray-400">Vừa xong</span>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        <?php
                        }else{
                        ?>
                        <?php echo $user_id?>
                          <p class=" m-5 font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <a href="/LTWUD2/account.php">Đăng nhập</a>
                          </p>




                        <?php
                        }
                        ?>

                        <!-- <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                        <div class="flex gap-3 items-start">
                            <div class="bg-green-100 text-green-600 rounded-full p-2">
                            🎁
                            </div>
                            <div class="flex-1">
                            <p class="font-medium text-gray-800">Khuyến mãi mới!</p>
                            <p class="text-sm text-gray-500">Giảm 50% sách tham khảo trong hôm nay</p>
                            <span class="text-xs text-gray-400">1 giờ trước</span>
                            </div>
                        </div>
                        </li>
                        <li class="px-4 py-3 hover:bg-gray-50 transition-all duration-200">
                        <div class="flex gap-3 items-start">
                            <div class="bg-yellow-100 text-yellow-600 rounded-full p-2">
                            ⚠️
                            </div>
                            <div class="flex-1">
                            <p class="font-medium text-gray-800">Cập nhật bảo trì hệ thống</p>
                            <p class="text-sm text-gray-500">Website sẽ bảo trì từ 22:00 đến 23:00</p>
                            <span class="text-xs text-gray-400">Hôm qua</span>
                            </div>
                        </div>
                        </li> -->
                    </ul>
                </div>





              <!--  -->
            </div>
            <!-- Giỏ hàng -->
             <a href="/LTWUD2/zui/cart.php">

                 <div class="relative flex flex-col items-center">
                     
                    
                    <span class="text-xl">🛒  </span>
                    <span>Giỏ Hàng</span>
                    <span class="absolute -top-1 -right-2 text-xs bg-red-600 text-white rounded-full px-1"><?php echo $countOfCart?></span>
                </div>
            </a>




      
            <!-- Tài khoản -->
            <div class="flex flex-col items-center">
                <span class="text-xl"><a href="/LTWUD2/account.php">👤</a></span>
                <a href="/LTWUD2/account.php">Tài khoản</a>

            </div>
      
            <!-- Quốc kỳ -->
            <div id="vietNam" >
                <img  src="./images/forHeader/vietNam.png" alt="">

            </div>
            <a href="/LTWUD2/components/logout.php"
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

                        