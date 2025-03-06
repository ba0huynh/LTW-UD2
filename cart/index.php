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
  <div class="min-h-[100vh]">
    <div class="container mx-auto gap-4 p-4 flex flex-row">
      <section class="min-w-[70%]">

        <div class="flex items-center mb-4">
          <div class=" w-[50%] checkbox-wrapper-13">
            <input
              type="checkbox"


              class="mr-2"
              id="select-all" />
            <label htmlFor="select-all">Chọn tất cả (1 sản phẩm)</label>
          </div>
          <div class="w-[25%]">Số lượng</div>
          <div class="w-[25%]">Thành tiền</div>
        </div>
        <CartItemDisplay
          image="https://skyryedesign.com/wp-content/uploads/2016/04/56c6f9b7efad5-cover-books-design-illustrations.jpg" />
      </section>
      <section class="min-w-[30%]">
       
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