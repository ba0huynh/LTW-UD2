<div class="bg-white rounded-2xl shadow-lg p-6 max-w-7xl mx-auto mt-4">


  <?php
  $sql = "SELECT * FROM subjects";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $sql2 = "SELECT * FROM books WHERE subjectId = " . intval($row["id"]);
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



      <!-- Danh sách sách -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 px-4 pb-8">
  <?php while ($row2 = $result2->fetch_assoc()) { ?>
    <div class="bg-gray-50 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative group">
      <img src="<?php echo htmlspecialchars($row2["imageURL"]); ?>" alt="Book" class="w-full h-80 object-cover transition duration-300 group-hover:brightness-75">
      
      <!-- Overlay Icons -->
      <div class="absolute inset-0 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition duration-300">
        
        <a href="book?bookId=<?php echo $row2["id"]?>" class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
          <span class="icon text-xl">🔍</span>
        </a>

        <button onclick="themVaoGio(<?= $row2['id'] ?>)" 
        type="" 
        class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
            <span class="icon text-xl">🛒</span>
        </button>
      </div>


      <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($row2["bookName"]); ?></h3>
        <div class="flex items-center space-x-2 mt-2">
          <span class="text-lg font-bold text-red-500"><?php echo htmlspecialchars($row2["currentPrice"]); ?>₫</span>
          <span class="text-sm text-gray-400 line-through"><?php echo htmlspecialchars($row2["oldPrice"]); ?>₫</span>
          <!-- cái này là gì:')) -->
          <span class="text-sm text-white bg-red-400 px-2 py-0.5 rounded">-25%</span>
        </div>
        <!-- sửa lại cái này nha Phước Hìn -->
        <p class="text-sm text-gray-500 mt-1">Đã bán 102</p>
      </div>
    </div>
  <?php } ?>
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




