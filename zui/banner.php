<!-- Banner Slider Section Centered -->
<div class="w-screen h-screen bg-white px-4 py-6">
  <div class="max-w-full h-full mx-auto flex flex-col items-center">
    <div class="grid grid-cols-3 gap-4 w-full h-full">
      <!-- Main Banner -->
      <div class="col-span-2 relative rounded overflow-hidden h-full">
        <img id="mainBanner" src="https://cdn1.fahasa.com/media/wysiwyg/Thang-01-2024/Hotwheels_LDP_Mainbanner_web_1920x700.jpg" alt="Main Banner" class="w-full h-full object-cover rounded transition-all duration-300">
        <!-- Slide Indicators -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
          <div onclick="changeSlide(0)" class="w-3 h-3 bg-white rounded-full cursor-pointer border border-gray-400" id="indicator-0"></div>
          <div onclick="changeSlide(1)" class="w-3 h-3 bg-white rounded-full cursor-pointer border border-gray-400" id="indicator-1"></div>
          <div onclick="changeSlide(2)" class="w-3 h-3 bg-white rounded-full cursor-pointer border border-gray-400" id="indicator-2"></div>
          <div onclick="changeSlide(3)" class="w-3 h-3 bg-white rounded-full cursor-pointer border border-gray-400" id="indicator-3"></div>
          <div onclick="changeSlide(4)" class="w-3 h-3 bg-white rounded-full cursor-pointer border border-gray-400" id="indicator-4"></div>
        </div>
      </div>

      <!-- Side Banners -->
      <div class="flex flex-col gap-4 h-full">
        <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/ShopeeT4_392x156.png" alt="Voucher Banner" class="w-full h-1/2 rounded object-cover">
        <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/homecreditT4_392x156.png" alt="Home Credit Banner" class="w-full h-1/2 rounded object-cover">
      </div>
    </div>

    <!-- Promotions Row -->
    <div class="grid grid-cols-4 gap-4 mt-6 w-full">
      <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/ctt3_t4_ngap_vang_310x210_3.jpg" class="w-full rounded object-cover" />
      <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/hotwheel0424_smallbanner_310x210_04.jpg" class="w-full rounded object-cover" />
      <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/MinhLong_KC_310x210.png" class="w-full rounded object-cover" />
      <img src="https://cdn1.fahasa.com/media/wysiwyg/Thang-04-2025/NgoaiVanT4_Resize_310x210.png" class="w-full rounded object-cover" />
    </div>
  </div>
</div>
<script>
  const banners = [
    "https://cdn1.fahasa.com/media/wysiwyg/Thang-01-2024/Hotwheels_LDP_Mainbanner_web_1920x700.jpg",
    "https://cdn1.fahasa.com/media/magentothem/banner7/LichSuVanHoa_Resize_840x320.png",
    "https://cdn1.fahasa.com/media/magentothem/banner7/Trangdenban_0424_840x320.jpg",
    "https://cdn1.fahasa.com/media/magentothem/banner7/TrangDiaCau_Resize_840x320_1.png",
    "https://cdn1.fahasa.com/media/magentothem/banner7/muasamkhongtienmatT4_840x320.png"
  ];

  function changeSlide(index) {
    document.getElementById('mainBanner').src = banners[index];
    for (let i = 0; i < banners.length; i++) {
      const indicator = document.getElementById(`indicator-${i}`);
      if (i === index) {
        indicator.classList.add("bg-red-600");
        indicator.classList.remove("bg-white");
      } else {
        indicator.classList.remove("bg-red-600");
        indicator.classList.add("bg-white");
      }
    }
  }

  // Khởi tạo slide đầu tiên
  changeSlide(0);
</script>
