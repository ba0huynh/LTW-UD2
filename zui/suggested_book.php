<div class="bg-white rounded-2xl shadow-lg p-6 max-w-7xl mx-auto mt-4">
  <?php
  $sql = "SELECT * FROM subjects";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $sql2 = "SELECT * FROM books WHERE subjectId = " . intval($row["id"]) . " LIMIT 4";
      $result2 = $conn->query($sql2);

      if ($result2->num_rows === 0) {
        continue;
      }
  ?>
  <div class="w-full px-6 py-4 bg-gradient-to-r from-pink-100 to-yellow-100 rounded-xl shadow flex items-center gap-3 mb-4">
    <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-yellow-500 text-transparent bg-clip-text">
      Môn học: <?php echo htmlspecialchars($row["subjectName"]); ?>
    </h2>
  </div>

  <div class="grid [grid-template-columns:repeat(4,minmax(0,1fr))_32px] gap-6 px-4 pb-8">
    
    <?php 
    $count_books = $result2->num_rows;
    if ($count_books > 0) {
    while ($row2 = $result2->fetch_assoc()) { ?>

      <div class="bg-gray-50 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative group">
        <img src="<?php echo htmlspecialchars($row2["imageURL"]); ?>" alt="Book" class="w-full h-80 object-cover transition duration-300 group-hover:brightness-75">
        
        <!-- Overlay Icons -->
        <div class="absolute inset-0 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition duration-300">
          <a href="book?bookId=<?php echo $row2["id"]?>" class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="icon text-xl">🔍</span>
          </a>
          <button onclick="themVaoGio(<?= $row2['id'] ?>)" type="button" class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="icon text-xl">🛒</span>
          </button>
        </div>

        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($row2["bookName"]); ?></h3>
          <div class="flex items-center space-x-2 mt-2">
            <span class="text-lg font-bold text-red-500"><?php echo number_format($row2["currentPrice"], 0, ',', '.'); ?> đ</span>
            <span class="text-sm text-gray-400 line-through"><?php echo number_format($row2["oldPrice"], 0, ',', '.'); ?> đ</span>
            <span class="text-sm text-white bg-red-400 px-2 py-0.5 rounded">-25%</span>
          </div>
          <p class="text-sm text-gray-500 mt-1">Đã bán 102</p>
        </div>
      </div>
    <?php }} ?>
    <?php if ($result2->num_rows>=4){?>
    <!-- Nút "Xem thêm" trong cùng hàng -->
    <a href="searchPage.php?subject=<?= $row['subjectName'] ?>"
       class="bg-white  transition duration-300 rounded-xl flex flex-col justify-center items-center text-[#0081c2] hover:text-blue-700 p-6 text-sm font-medium group">
      <div class="flex flex-col items-center gap-2 transform group-hover:scale-105 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform duration-200 group-hover:scale-125" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </div>
    </a>
    <?php }?>

  </div>
  <?php
    }
  }
  ?>
</div>


<script>
  function themVaoGio(bookId) {
  fetch('controllers/add_to_cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'book_id=' + bookId
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      // 👉 Update số lượng
      const cartCountSpan = document.getElementById('cart-count');
      if (cartCountSpan) {
        cartCountSpan.innerText = data.count;
        cartCountSpan.style.display = data.count > 0 ? 'inline-block' : 'none';
      }
    } else {
      alert("❌ " + data.message);
    }
  })
  .catch(err => {
    console.error("Lỗi khi gửi request:", err);
    alert("❌ Có lỗi khi thêm vào giỏ hàng.");
  });
}

</script>




