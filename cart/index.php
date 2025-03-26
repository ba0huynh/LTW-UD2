<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../TailWind.css">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
    </style>
</head>

<body>
  <div class="bg-[#fff1f2] gap-6 flex flex-col p-[7%] items-center">
    <section class="bg-white w-full flex flex-col items-center rounded-lg gap-3 p-10">
      <img src="../images/empty-cart.png" class="w-[20%]" alt="">
      <p>Chưa có sản phẩm trong giỏ hàng của bạn.</p>
      <a href="../index.php">

        <button class="flex-1 bg-red-500 text-white py-2 px-4 font-semibold rounded-lg">
          MUA SẮM NGAY
        </button>
      </a>
    </section>
    <div class="w-full gap-4 flex flex-row">
      <section class="flex-5 bg-white rounded-lg p-4">

        <div class="flex items-center mb-4">
          <div class="flex-10 checkbox-wrapper-13">
            <input
              type="checkbox"


              class="mr-2"
              id="select-all" />
            <label htmlFor="select-all">Chọn tất cả (1 sản phẩm)</label>
          </div>
          <div class="flex-3">Số lượng</div>
          <div class="flex-3">Thành tiền</div>
          <div class="flex-1"></div>
        </div>
        <div class="flex flex-row gap-3">
          <div class="flex-10 flex flex-row gap-3">

            <input
              type="checkbox"
              class="mr-2"
              id="select-all" />
            
            <img src="https://phuongnam.edu.vn/storage/media/bia-sach/202306/1f14b7c9-5e35-4c50-bc96-5aa3cf29feab.jpg" class="w-[100px] h-[150px]" alt="">
            <div class="flex flex-col items-start justify-center gap-8">
              <p>sách tiếng anh lớp 4 tập 1</p>
              <div class="flex flex-row gap-2 items-center">
                <p class="font-semibold text-lg">224.000 đ</p>
                <p class=" text-md text-gray-400 line-through">250.000 đ</p>
              </div>
            </div>
          </div>
          <div class="flex flex-3 flex-row items-center gap-2">
            <button class="cursor-pointer">-</button>
            <p>1</p>
            <button class="cursor-pointer">+</button>
          </div>
          <div class="flex-3 text-xl font-bold text-[#FB2C36] items-center flex">
            224.000 đ
          </div>
          <div class="flex-1 flex items-center justify-center cursor-pointer">
            <img src="https://www.iconpacks.net/icons/1/free-trash-icon-347-thumb.png" class="w-[30px]" alt="">
          </div>
        </div>
      </section>
      <section class="flex-2 bg-white rounded-lg p-4">

        <div class="p-4 mb-4">
          <div class="flex justify-between mb-2">
            <div>Thành tiền</div>
            <div>0₫</div>
          </div>
          <div class="flex justify-between font-bold">
            <div>Tổng Số Tiền (gồm VAT)</div>
            <div class="text-[red] font-bold text-2xl">0₫</div>

          </div>
        </div>


        <button class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-4 rounded">
          THANH TOÁN
        </button>
      </section>
    </div>
  </div>
</body>

</html>