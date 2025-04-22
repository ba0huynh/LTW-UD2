<footer class="bg-gray-100 text-gray-700 pt-12 w-full mt-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Logo & Description -->
      <div class="space-y-4">
        <img src="./images/login/image1.jpg" alt="Logo" class="w-20">
        <p class="text-sm">Lầu 5, 367-369 Hai Bà Trưng, Q.3, TP.HCM</p>
        <p class="text-sm">Công Ty CP Phát Hành Sách TP.HCM - FAHASA</p>
        <p class="text-sm">Fahasa.com nhận đặt hàng trực tuyến và giao hàng tận nơi.</p>
        <img src="./images/login/logo-bo-cong-thuong-da-thong-bao1.webp" alt="Đã thông báo" class="w-28 mt-4">
        <div class="flex gap-3 text-2xl text-gray-500 mt-4">
          <i class='bx bxl-facebook-circle hover:text-blue-600'></i>
          <i class='bx bxl-instagram-alt hover:text-pink-500'></i>
          <i class='bx bxl-youtube hover:text-red-600'></i>
          <i class='bx bxl-twitter hover:text-blue-400'></i>
        </div>
      </div>

      <!-- Dịch vụ -->
      <div>
        <h4 class="font-bold text-lg mb-4">DỊCH VỤ</h4>
        <ul class="space-y-2">
          <li class="footer-item">Điều khoản sử dụng</li>
          <li class="footer-item">Chính sách bảo mật thông tin</li>
          <li class="footer-item">Chính sách bảo mật thanh toán</li>
          <li class="footer-item">Giới thiệu Fahasa</li>
        </ul>
      </div>

      <!-- Hỗ trợ -->
      <div>
        <h4 class="font-bold text-lg mb-4">HỖ TRỢ</h4>
        <ul class="space-y-2">
          <li class="footer-item">Chính sách đổi - trả</li>
          <li class="footer-item">Chính sách vận chuyển</li>
          <li class="footer-item">Chính sách bảo hành</li>
          <li class="footer-item">Khách sĩ</li>
        </ul>
      </div>

      <!-- Liên hệ -->
      <div>
        <h4 class="font-bold text-lg mb-4">LIÊN HỆ</h4>
        <ul class="space-y-2 text-sm">
          <li class="flex items-center gap-2"><i class='bx bxs-map'></i> 60-62 Lê Lợi, Q1, TP.HCM</li>
          <li class="flex items-center gap-2"><i class='bx bxs-envelope'></i> cskh@fahasa.com.vn</li>
          <li class="flex items-center gap-2"><i class='bx bxs-phone'></i> 1900 636 467</li>
        </ul>
        <div class="flex gap-3 mt-4">
          <img src="./images/login/android1.webp" class="w-24">
          <img src="./images/login/appstore1.webp" class="w-24">
        </div>
      </div>
    </div>

    <!-- Payments -->
    <div class="mt-12 border-t pt-6 flex flex-wrap justify-center items-center gap-6">
      <img src="./images/login/logo_lex.webp" class="h-10">
      <img src="./images/login/Logo_ninjavan.webp" class="h-10">
      <img src="./images/login/vnpost1.webp" class="h-10">
      <img src="./images/login/vnpay_logo.webp" class="h-10">
      <img src="./images/login/shopeepay_logo.webp" class="h-10">
      <img src="./images/login/momopay.webp" class="h-10 w-auto">
    </div>

    <p class="text-center text-sm text-gray-400 mt-6 pb-6">© 2025 Fahasa. All rights reserved.</p>
  </div>

  <style>
    .footer-item {
      position: relative;
      padding-left: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    .footer-item::before {
      content: "—";
      position: absolute;
      left: -20px;
      color: #ec4899;
      opacity: 0;
      transition: all 0.3s ease-in-out;
    }

    .footer-item:hover {
      transform: translateX(6px);
      color: #ec4899;
    }

    .footer-item:hover::before {
      left: -10px;
      opacity: 1;
    }
  </style>
</footer>
