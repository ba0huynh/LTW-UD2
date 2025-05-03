<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../");
    exit();
}
$servername="localhost";
$username="root";
$password="";
$dbname="ltw_ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body>
    <?php include_once "../components/header2.php";
    if(isset($_SESSION["user_id"])){
  echo $_SESSION["user_id"]."day laaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
}else{
  echo "khogn co";
}
    ?>
<?php
if(isset($_SESSION["user_id"])){
  $sql = "SELECT * FROM cart WHERE idUser = " . $_SESSION["user_id"];
  $result = mysqli_query($conn, $sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {


?>
<form action="payment.php" method="post" id="cartForm">
  <div class="max-w-6xl mx-auto mt-10 flex gap-6">
    <div class="w-full max-w-sm bg-white p-6 rounded-2xl shadow-xl border border-gray-200">

      <div class="flex justify-between text-gray-500 mb-2">
        <span>Thành tiền</span>
        <span class="total-amount">
          <?php echo number_format($row["totalPrice"], 0, ',', '.'); ?> đ
        </span>

      </div>

      <hr class="my-2 border-gray-200" />

      <div class="flex justify-between font-semibold text-base text-gray-800 mb-4">
        <span>Tổng Số Tiền (gồm VAT)</span>
        <input type="hidden" name="tongTien" id="tongTienInput" value="0" />
        <span class="total-amount text-red-600">
          <?php echo number_format($row["totalPrice"], 0, ',', '.'); ?> đ
        </span>
      </div>

      <div class="flex justify-end mt-8 w-full">
        <button
          type="submit"
          class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition-all duration-300 ease-in-out"
        >
          💳 Thanh Toán
        </button>
      </div>
    </div>


    <div class="bg-white p-6 rounded-2xl shadow-xl w-full border border-gray-200">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">Giỏ Sách Của Bạn</h1>

      <?php

          $sql2 = "SELECT * FROM cartitems, books WHERE books.id = cartitems.bookId AND cartitems.cartId = " . $row["idCart"];
          $result2 = mysqli_query($conn, $sql2);
          if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
      ?>

      <!-- Sản phẩm -->
      <div class="flex items-start gap-4 border-b border-gray-200 pb-6 mb-6 relative group" data-book-id="<?= $row2['bookId'] ?>" data-cart-id="<?= $row2['cartId'] ?>">
        <img
          src="<?php echo $row2['imageURL']; ?>"
          class="w-20 h-28 object-cover rounded-lg"
          alt="Ảnh sách"
        />
        <div class="flex-1">
          <h2 class="text-base font-semibold text-gray-700 mb-1">
            <?php echo htmlspecialchars($row2['bookName']); ?>
          </h2>
          <p class="text-red-600 font-semibold text-sm item-price" data-price="<?php echo $row2['currentPrice']; ?>">
          <?php echo number_format($row2['currentPrice'], 0, ',', '.'); ?> đ

          <?php if ($row2['oldPrice'] > $row2['currentPrice']) { ?>
            <span class="text-xs text-gray-400 line-through ml-2">
            <?php echo number_format($row2['oldPrice'], 0, ',', '.'); ?> đ
            </span>
          <?php } ?>
          </p>
        </div>

        <div class="flex flex-col items-center gap-1" data-book-id="<?php echo $row2['bookId']; ?>" data-cart-id="<?php echo $row2['cartId']; ?>">
          <div class="flex items-center gap-2">
            <button type="button" class="px-2 py-1 text-lg font-bold border border-gray-300 rounded decrease">−</button>
            <span class="quantity text-sm text-gray-800"><?php echo $row2['amount']; ?></span>
            <button type="button" class="px-2 py-1 text-lg font-bold border border-gray-300 rounded increase">+</button>
          </div>

          <div class=" mt-4 text-red-600 font-semibold text-sm item-total"
              data-price="<?= $row2['currentPrice'] * $row2['amount']; ?>"
              data-price-per-item="<?= $row2['currentPrice']; ?>">
            <?= number_format($row2['currentPrice'] * $row2['amount'], 0, ',', '.'); ?> đ
          </div>
        </div>



        <div>
          <button type="button"
                  class=" text-gray-400 hover:text-red-600 transition"
                  onclick="xoaSanPham(this)">
            🗑️
          </button>

        </div>


      </div>

      <?php
            }
          }
        }
      }
    }else{
      //
    }
      ?>
    </div>
  </div>
</form>

<?php include_once "../components/footer.php";?>
<script>
function formatCurrency(value) {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(value);
}



// const price = parseFloat(parent.querySelector('.item-price').dataset.price);
// const itemTotalEl = parent.querySelector('.item-total');
// const itemTotal = price * amount;
// itemTotalEl.textContent = formatCurrency(itemTotal);





document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.increase, .decrease').forEach((button) => {
    button.addEventListener('click', function () {
      const parent = this.closest('[data-book-id][data-cart-id]');
      if (!parent) return;

      const bookId = parent.dataset.bookId;
      const cartId = parent.dataset.cartId;
      const action = this.classList.contains('increase') ? 'increase' : 'decrease';

      const quantitySpan = parent.querySelector('.quantity');
      let currentQty = parseInt(quantitySpan.textContent);

      if (action === 'increase') {
        currentQty++;
      } else if (currentQty > 1) {
        currentQty--;
      }

      quantitySpan.textContent = currentQty;
      const amount = currentQty;

      fetch('../controllers/update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `book_id=${bookId}&cartId=${cartId}&action=${action}&amount=${amount}`
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // ✅ Cập nhật tổng tiền giỏ hàng
            document.querySelectorAll('.total-amount').forEach(el => {
              el.textContent = formatCurrency(data.totalPrice);
            });

            const itemTotalEl = parent.closest('.flex.items-start').querySelector('.item-total');

            const unitPrice = parseFloat(itemTotalEl.dataset.pricePerItem);
            const itemTotal = unitPrice * amount;

            itemTotalEl.textContent = formatCurrency(itemTotal);
            itemTotalEl.dataset.price = itemTotal;

            
          } else {
            alert(data.message || "Có lỗi xảy ra");
          }
        });
    });
  });
});

function xoaSanPham(button) {
  const productDiv = button.closest('[data-book-id][data-cart-id]');
  const bookId = productDiv.dataset.bookId;
  const cartId = productDiv.dataset.cartId;

  if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) return;

  fetch('../controllers/delete_cart_item.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `book_id=${bookId}&cartId=${cartId}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Xóa phần tử khỏi DOM
      productDiv.remove();

      // Cập nhật lại tổng tiền hiển thị
      document.querySelectorAll('.total-amount').forEach(el => {
        el.textContent = formatCurrency(data.totalPrice);
      });
    } else {
      alert(data.message || 'Xóa sản phẩm thất bại!');
    }
  })
  .catch(err => {
    console.error("Lỗi xoá:", err);
    alert("Có lỗi xảy ra khi xoá sản phẩm.");
  });
}
</script>

<!-- <script>
  function formatCurrency(value) { return new Intl.NumberFormat('vi-VN', {
  style: 'currency', currency: 'VND' }).format(value); } function updateTotal()
  { const items = document.querySelectorAll('.quantity'); let total = 0;
  items.forEach((qtyEl, index) => { const priceEl =
  document.querySelectorAll('.item-price')[index]; const quantityInput =
  document.querySelectorAll('.quantity-input')[index]; const itemTotalEl =
  document.querySelectorAll('.item-total')[index]; const price =
  parseFloat(priceEl.dataset.price); const qty = parseInt(qtyEl.textContent);
  const itemTotal = price * qty; itemTotalEl.textContent =
  formatCurrency(itemTotal); quantityInput.value = qty; total += itemTotal; });
  document.getElementById('tongTienInput').value = total;
  document.querySelectorAll('.total-amount').forEach(el => { el.textContent =
  formatCurrency(total); }); }
  document.querySelectorAll('.increase').forEach((btn, index) => {
  btn.addEventListener('click', () => { const qtyEls =
  document.querySelectorAll('.quantity'); const qtyEl = qtyEls[index]; let qty =
  parseInt(qtyEl.textContent); qty++; qtyEl.textContent = qty; updateTotal();
  }); }); document.querySelectorAll('.decrease').forEach((btn, index) => {
  btn.addEventListener('click', () => { const qtyEls =
  document.querySelectorAll('.quantity'); const qtyEl = qtyEls[index]; let qty =
  parseInt(qtyEl.textContent); if (qty > 1) { qty--; qtyEl.textContent = qty;
  updateTotal(); } }); }); // Gọi khi load trang để hiển thị đúng tổng ban đầu
  updateTotal();
</script> -->
</body>
</html>