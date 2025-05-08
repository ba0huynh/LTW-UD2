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
<div class="relative mx-auto w-full flex justify-between py-2 px-[10%] bg-white shadow-sm">
  <div class="flex items-center gap-2">
    <a href="/LTW-UD2"><img src="/LTW-UD2/images/forHeader/logo.jpg" alt="Logo" class="h-12"></a>
  </div>
  <img src="/LTW-UD2/images/menulogo.png" alt="" class=" h-10" id="menuTrigger">
  <div class="flex-1 max-w-2xl mx-4">
    <form action="/LTW-UD2/searchPage.php" method="GET" class="flex rounded border border-gray-300 overflow-hidden">
      <input type="text" name="search" placeholder="Tìm kiếm" class="flex-1 px-4 py-2 outline-none text-sm" required />
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
      <div id="notificationPanel"
        class=" hidden absolute right-50 mt-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-30">
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
                  1 => '📦',
                  2 => '🚚',
                  3 => '✅',
                  4 => '↩️',
                  6 => '❌'
                ];

                $texts = [
                  1 => 'Đang xử lý',
                  2 => 'Đang được giao',
                  3 => 'Giao hàng thành công',
                  4 => 'Đơn hàng đã hủy'
                ];
                $text = $texts[$status] ?? '❌';
                $icon = $icons[$status] ?? '❌';


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
              <a href="/LTW-UD2/account.php">Đăng nhập </a>
            </li>
          <?php } ?>
        </ul>
      </div>

      <!-- 1.đang xử lí 📦(đợi duyệt hoặc hủy)trang duyệt/hủy-->
      <!-- 2.đang được giao (duyệt xong chuyển sang đang xử lí giao hàng hoặc hủy) trang xử lí giao hàng 🚚-->
      <!-- 3.giao hàng thành công ✅ ( giao xong hiện trong danh sách đơn hàng hoàn thành )danh sách đơn hàng hoàn thành-->
      <!-- 4.đơn hàng đã trả ↩️ (các đơn hàng trong 10 ngày đầu được khách ấn trả)trang trả hàng/hủy-->
      <!-- 5.đơn hàng đã bị hủy ❌-->

    </div>
    <!-- Giỏ hàng -->
    <?php
    if(isset($_SESSION['user_id'])){
    ?>
    <a href="/LTW-UD2/zui/cart.php">

      <div class="relative flex flex-col items-center">
        <span class="text-xl">🛒 </span>
        <span>Giỏ hàng</span>
        <span id="cart-count" class="absolute -top-1 -right-2 text-xs bg-red-600 text-white rounded-full px-1">
          <?php echo $countOfCart ?? 0 ?>
        </span>

      </div>
    </a>
    <?php }?>

    <!-- Tài khoản -->
    <div class="flex flex-col items-center cursor-pointer">
    <?php if(isset($_SESSION["user_id"])){
    ?>
      <span class="text-xl"><a href="/LTW-UD2/zui/account.php" class="cursor-pointer">
        👤</a>
      </span>
      <a href="/LTW-UD2/account.php" class="cursor-pointer text-gray-600 hover:text-gray-800 transition duration-200">Tài khoản</a>
    <?php
    }else{?>
      <span class="text-xl">
        <a href="javascript:void(0)" 
        onclick="openLoginModal()">👤</a>
      </span>
      <a href="javascript:void(0)" onclick="openLoginModal()">Tài khoản</a>
    <?php
    }?>
    </div>
    <!-- Modal -->
    <div id="loginModal"
      class="fixed inset-0 flex  justify-center items-center z-50 opacity-0 pointer-events-none transition-opacity duration-300 bg-black bg-opacity-0"
      onclick="handleBackdropClick(event)">
      <div id="modalContent"
        class="bg-white bg-opacity-95 p-6 rounded-xl w-[400px]   relative shadow-xl transform translate-y-[-20px] transition-transform duration-300">
        <div id="loginFormContent">Đang tải...</div>
      </div>
    </div>

<style>
  #loginModal.show {
    opacity: 1;
    pointer-events: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  #loginModal.show #modalContent {
    transform: translateY(0);
  }
</style>

<script>
  function openLoginModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.add('show');

    fetch('./components/login2.php')
      .then(res => res.text())
      .then(html => {
        document.getElementById('loginFormContent').innerHTML = html;
      })
      .catch(() => {
        document.getElementById('loginFormContent').innerHTML = "<p class='text-red-500'>Không thể tải form.</p>";
      });
  }
  function switchTab(tab) {
  console.log(tab);  

  const loginTab = document.getElementById('loginTab');
  const registerTab = document.getElementById('registerTab');
  const formLogin = document.getElementById('formdangnhap');
  const formRegister = document.getElementById('formdangki');
  console.log(loginTab.classList);

  if (tab === 'login') {
    loginTab.classList.add('text-red-600', 'font-semibold', 'border-red-600');
    loginTab.classList.remove('text-gray-600');

    registerTab.classList.remove('text-red-600', 'font-semibold', 'border-red-600');
    registerTab.classList.add('text-gray-600');

    formLogin.classList.remove('hidden');
    formRegister.classList.add('hidden');
  } else if (tab === 'register') {
    registerTab.classList.add('text-red-600', 'font-semibold', 'border-red-600');
    registerTab.classList.remove('text-gray-600');

    loginTab.classList.remove('text-red-600', 'font-semibold', 'border-red-600');
    loginTab.classList.add('text-gray-600');

    formRegister.classList.remove('hidden');
    formLogin.classList.add('hidden');
  } else {
    console.error('Tab không hợp lệ:', tab);
  }
}

  function togglePassword(inputId = 'passwordInput', buttonId = 'toggleBtn') {
    const passwordInput = document.getElementById(inputId);
    const toggleBtn = document.getElementById(buttonId);

    if (passwordInput && toggleBtn) {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.textContent = 'Ẩn';
      } else {
        passwordInput.type = 'password';
        toggleBtn.textContent = 'Hiện';
      }
    }
  }
  function isValidPhoneNumber(phone) {
  const regex = /^0\d{9}$/;
  return regex.test(phone);
}
//Bắt đầu bằng số 0
//Có tổng cộng 10 chữ số
function isValidPassword(password) {
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  return regex.test(password);
}
//Ít nhất 8 ký tự
//Ít nhất một chữ hoa
//Ít nhất một chữ thường
//Ít nhất một số
//Ít nhất một ký tự đặc biệt
function validateRegisterForm(event) {
  const phone = document.querySelector('#formdangki input[name="user_telephone"]').value.trim();
  const password = document.querySelector('#formdangki input[name="user_password"]').value.trim();
  const confirmPassword = document.querySelector('#formdangki input[name="user_comfirm_password"]').value.trim();

  if (!isValidPhoneNumber(phone)) {
    alert("Số điện thoại không hợp lệ. Phải có 10 số và bắt đầu bằng 0.");
    return false;
  }

  if (!isValidPassword(password)) {
    alert("Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt.");
    return false;
  }

  if (password !== confirmPassword) {
    alert("Mật khẩu xác nhận không khớp.");
    return false;
  }

  // Nếu mọi thứ OK
  return true;
}


  function closeLoginModal() {
    document.getElementById('loginModal').classList.remove('show');
  }

  // Đóng bằng phím ESC
  document.addEventListener('keydown', function (e) {
    if (e.key === "Escape") {
      closeLoginModal();
    }
  });

  // Đóng khi click ra ngoài modalContent
  function handleBackdropClick(event) {
    const modalContent = document.getElementById('modalContent');
    if (!modalContent.contains(event.target)) {
      closeLoginModal();
    }
  }
</script>


    <!-- Quốc kỳ -->
    <div id="vietNam">
      <img src="/LTW-UD2/images/forHeader/vietNam.png" alt="">

    </div>
    <?php
    if (isset($_SESSION['user_id'])) {
    
    ?>
    <a href="./components/logout.php"
      class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:text-white" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
      </svg>
    </a>
    <?php
    }
    ?>
  </div>


  <!-- MENU CONTENT -->
  <div id="menuContent"
    class="menuContent hidden absolute top-full left-10 bg-white shadow-lg z-50 w-[90vw] rounded-xl overflow-hidden ">

    <div class="flex min-h-[300px]">

      <!-- SIDEBAR: Danh sách lớp -->
      <div class="w-60 bg-white border-r">
        <?php for ($i = 6; $i < 13; $i++) { ?>
          <div
            class="tablinks px-4 py-3 hover:bg-gray-100 cursor-pointer text-sm font-medium border-l-4 border-transparent hover:border-pink-500 transition-all"
            data-id="<?php echo $i; ?>">
            Lớp <?php echo $i ?>
          </div>
        <?php } ?>
      </div>

      <!-- NỘI DUNG CHI TIẾT -->
      <div class="flex-1 p-6">
        <div class="flex items-center gap-2 mb-4">
          <img src="/LTW-UD2/images/forHeader/menuBook.png" alt="" class="w-5 h-5">
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
      for ($i = 6; $i < 13; $i++) {
        ?>
        <div class="tablinks " data-id="<?php echo $i; ?>">
          Lớp <?php echo $i ?>
        </div>
        <?php
      }
      ?>
      <script>
        document.querySelectorAll(".tablinks").forEach(tab => {
          tab.addEventListener("mouseenter", function () {
            let Class = this.dataset.id;
            openTab(this, Class);
          })
        })
        function openTab(tab, Class) {

          const Tablinks = document.querySelectorAll(".tablinks");
          for (let i = 0; i < Tablinks.length; i++) {
            Tablinks[i].className = Tablinks[i].className.replace(" onTab", "");
          }
          tab.classList.add("onTab");
        }
      </script>
    </div>
    <div class="line"></div>
    <div style="width: 100%;">
      <div>
        <div>
          <img src="/LTW-UD2/images/forHeader/menuBook.png" alt="">
        </div>
        SÁCH TRONG NƯỚC
      </div>
      <div class="detailMenu">
        <!-- div*3 -->
      </div>
      <script>
        const detailMenu = document.querySelector(".detailMenu");
        const tablinks = document.querySelectorAll(".tablinks");
        tablinks.forEach(tab => {
          tab.addEventListener("mouseenter", function () {
            const Class = this.dataset.id;
            fetch(`contentMenu.php/?Class=${Class}`).
              then(response => response.text()).
              then(data => {
                detailMenu.innerHTML = data;
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