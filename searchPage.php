<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./css/login.css">
<link rel="stylesheet" href="./css/header.css">
</head>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();



$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 10;
$offset = ($currentPage - 1) * $itemsPerPage;


$class = $_GET["class"] ?? null;
$subject = $_GET["subject"] ?? null;
$type = $_GET["type"] ?? null;
$search = $_GET["search"] ?? null;
$option = $_GET["Optioncost"] ?? null;
$min_class = $_GET["min_class"] ?? null;
$max_class = $_GET["max_class"] ?? null;
$min_cost = $_GET["min_cost"] ?? null;
$max_cost = $_GET["max_cost"] ?? null;

if ($option == 1) {
  $min_cost = 0;
  $max_cost = 50000;
} elseif ($option == 2) {
  $min_cost = 50000;
  $max_cost = 100000;
} elseif ($option == 3) {
  $min_cost = 100000;
  $max_cost = 200000;
}

$countQuery = "SELECT COUNT(*) AS total FROM books ";
$query_result_books = "SELECT books.* FROM books ";

if (!empty($subject)) {
    $query_result_books .= " WHERE books.subjectId = " . (int)$subject;
    $countQuery .= " WHERE books.subjectId = " . (int)$subject;
} else {
    $query_result_books .= "WHERE books.isActive=1 and books.status = 1 and books.quantitySold > 0  ";  
    $countQuery .= "WHERE  books.isActive=1 and books.status = 1 and books.quantitySold > 0 ";
}


if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query_result_books .= " AND bookName LIKE '%$search%' ";
    $countQuery .= " AND bookName LIKE '%$search%' ";
}

if (!empty($type)) {
    $query_result_books .= " AND books.type = '" . $type."' ";
    $countQuery .= " AND books.type = '" . $type. "' ";
}
if (!empty($min_cost) && !empty($max_cost)) {
    $query_result_books .= " AND books.currentPrice BETWEEN $min_cost AND $max_cost ";
    $countQuery .= " AND books.currentPrice BETWEEN $min_cost AND $max_cost ";
}
if (!empty($class)) {
    $query_result_books .= " AND books.classNumber = " . (int)$class;
    $countQuery .= " AND books.classNumber = " . (int)$class;
}
if (!empty($min_class) && !empty($max_class)) {
    $query_result_books .= " AND books.classNumber BETWEEN $min_class AND $max_class ";
    $countQuery .= " AND books.classNumber BETWEEN $min_class AND $max_class ";
}

$sort = $_GET["sort"] ?? null;
if (!empty($sort)) {
    if ($sort === "asc") {
        $query_result_books .= " ORDER BY books.currentPrice ASC";
        $countQuery .= " ORDER BY books.currentPrice ASC";
    } elseif ($sort === "desc") {
        $query_result_books .= " ORDER BY books.currentPrice DESC";
        $countQuery .= " ORDER BY books.currentPrice DESC";
    }
}

$countResult = $conn->query($countQuery);
$totalRows = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalRows / $itemsPerPage);
$query_result_books .= " LIMIT $offset, $itemsPerPage";

$result = $conn->query($query_result_books);
$num_rows = $result->num_rows;
?>

<body class="bg-gray-100 text-gray-800">
  <?php
  include './components/header2.php'
  ?>

  <div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-12 gap-6">
      <!-- Sidebar -->
      <form action="searchPage.php" method="GET" class="col-span-3 bg-white rounded-2xl shadow p-4">
        <aside class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold mb-4">LỌC THEO</h2>

            <!-- Danh mục chính -->
            <div class="mb-6">
              <?php if (!empty($_GET["subject"])) { ?>
              <h3 class="font-semibold mb-2">MÔN HỌC : 
              <input name="subject" type="text" value="<?php echo htmlspecialchars($_GET["subject"]); ?>">
              </h3>
              <?php } ?>
              <?php if (!empty($_GET["type"])) { ?>
              <h3 class="font-semibold mb-2">THỂ LOẠI : 
              <input  name="type" type="text" value="<?php echo htmlspecialchars($_GET["type"]); ?>">
              </h3>
              <?php } ?>

              <div class="accent-blue-500">
                <?php if (!empty($search)): ?>
                  Từ khóa tìm kiếm : <?= htmlspecialchars($search); ?><br>
                <?php endif; ?>
                <input type="hidden" name="search" value="<?php if (!empty($_GET["search"])) echo htmlspecialchars($_GET["search"]); ?>">
                Kết quả tìm kiếm : (<?php echo $num_rows ?? 0; ?>) <br>
                <?php if (!empty($subject)): ?>
                  Môn: <?= htmlspecialchars($subject); ?><br>
                <?php endif; ?>

                <?php if (!empty($type)): ?>
                  Thể loại: <?= htmlspecialchars($type); ?><br>
                <?php endif; ?>

              </div>
            </div>

            <!-- Giá -->
            <div class="mb-6">
              <h3 class="font-semibold mb-2">GIÁ</h3>
              <div class="space-y-1">
                <label class="flex items-center gap-2">
                <input type="checkbox" <?php if(isset($_GET["Optioncost"])){if($_GET["Optioncost"]==1) echo "checked";}?> name="Optioncost" value="1" class="accent-blue-500" >
                0đ - 50,000đ
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" <?php if(isset($_GET["Optioncost"])){if($_GET["Optioncost"]==2) echo "checked";}?> name="Optioncost" value="2" class="accent-blue-500">
                50,000đ - 100,000đ
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" <?php if(isset($_GET["Optioncost"])){if($_GET["Optioncost"]==3) echo "checked";}?> name="Optioncost" value="3" class="accent-blue-500">
                100,000đ - 200,000đ
                </label>
              </div>
              <!-- <div class="mt-4">
                <input name="min_cost" type="number" placeholder="0" class="w-1/4 border rounded p-1 text-sm"
                    value="<?php //echo $_GET['min_cost'] ?? ''; ?>"> - 
                <input name="max_cost" type="number" placeholder="0" class="w-1/4 border rounded p-1 text-sm"
                    value="<?php //echo $_GET['max_cost'] ?? ''; ?>">
              </div> -->
            </div>

            <!-- Lứa tuổi -->
            <!-- <div class="mb-6">
              <h3 class="font-semibold mb-2">Nhập lớp</h3>
              <label class="flex items-center gap-2">
                
                <input type="number" name="min_class" placeholder="Từ" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php //echo $_GET['min_class'] ?? ''; ?>"> -
                <input type="number" name="max_class" placeholder="Đến" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php //echo $_GET['max_class'] ?? ''; ?>">
              </label>
              <label class="flex items-center gap-2 mt-2">
                Nhập lớp : 
                <input type="text" name="class" value="<?php //echo $_GET['class'] ?? ''; ?>" class="w-1/6 border rounded p-1 text-sm">
              </label>
            </div> -->

            <button type="submit" class="bg-[#D10024] px-4 text-white m-2 rounded">Tìm kiếm</button>
        </aside>
      </form>


      <!-- Main Content -->
      <main class="col-span-9">
        <!-- Products Grid -->
        <div class="bg-white rounded-2xl shadow p-4 min-h-full">
          <div class="flex justify-between items-center mb-4">

            <h2 class="text-lg font-semibold">KẾT QUẢ TÌM KIẾM: <span class="text-blue-500"> <?php if(!empty($search)) echo $search ;?> (<?php echo $num_rows;?> kết quả)</span></h2>
            <form action="searchPage.php" method="GET" id="filterForm" class="flex items-center gap-2">
              <div class="flex gap-2">

                <select name="sort" class="border rounded p-1 text-sm " onchange="document.getElementById('filterForm').submit();">
                  <option>Sắp xếp theo</option>
                  <option value="asc">Giá tăng dần</option>
                  <option value="desc">Giá giảm dần</option>
                </select>
              </div>
            </form>

          </div>
          <div class="grid grid-cols-4 gap-4">
            <!-- Product Card -->
            <?php
            $result_books = $conn->query($query_result_books);
            if($result_books->num_rows>0){
              while($row=$result_books->fetch_assoc()){
            ?>
            <!-- <div class="bg-white rounded-2xl shadow p-2"> -->
            <div class=" bg-gray-50 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative group">
              <img src="<?php echo $row['imageURL'];?>" alt="Book" class="w-full h-80 object-cover transition duration-300 group-hover:brightness-75">

              <!-- Overlay Icons -->
              <div class="absolute inset-0 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition duration-300">
                
                <a href="book?bookId=<?php echo $row["id"]?>" class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
                  <span class="icon text-xl">🔍</span>
                </a>

                <button onclick="themVaoGio(<?= $row['id'] ?>)" 
                type="" 
                class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
                  <span class="icon text-xl">🛒</span>
                </button>
              </div>

              <h3 class="text-sm font-semibold m-4"><?php echo $row['bookName'];?></h3>
              <div class="text-red-600 font-semibold m-4"><?php echo number_format($row['currentPrice'], 0, ',', '.'); ?> đ <span class="text-xs text-gray-500 line-through"><?php echo number_format($row['oldPrice'], 0, ',', '.'); ?> đ</span></div>
              
            </div>
            <?php
              }
            }
            ?>
          </div>
        </div>

      </main>
      
    </div>

    <div class="flex justify-center mt-8">
      <?php
      if($totalPages > 1) {

      ?>
      <nav class="inline-flex items-center space-x-1 rounded-xl bg-white px-4 py-2 shadow-md border border-gray-200">

        <!-- Previous -->
        <?php if ($currentPage > 1): ?>
          <?php
            $params = $_GET;
            $params['page'] = $currentPage - 1;
          ?>
          <a href="?<?= http_build_query($params) ?>" class="px-3 py-1 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
            «
          </a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <?php
            $params = $_GET;
            $params['page'] = $i;
          ?>
          <a href="?<?= http_build_query($params) ?>"
            class="px-3 py-1 rounded-lg <?= $i == $currentPage ? 'bg-blue-500 text-white font-semibold shadow' : 'text-gray-600 hover:bg-gray-100' ?> transition">
            <?= $i ?>
          </a>
        <?php endfor; ?>

        <!-- Next -->
        <?php if ($currentPage < $totalPages): ?>
          <?php
            $params = $_GET;
            $params['page'] = $currentPage + 1;
          ?>
          <a href="?<?= http_build_query($params) ?>" class="px-3 py-1 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
            »
          </a>
        <?php endif; ?>

      </nav>
      <?php }?>
    </div>

    
  </div>


  <?php include_once "./components/footer.php";?>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
  const classInput = document.querySelector('input[name="class"]');
  const minClassInput = document.querySelector('input[name="min_class"]');
  const maxClassInput = document.querySelector('input[name="max_class"]');

  classInput.addEventListener('input', function () {
    if (this.value !== '') {
      minClassInput.disabled = true;
      maxClassInput.disabled = true;
      minClassInput.value = '';
      maxClassInput.value = '';
    } else {
      minClassInput.disabled = false;
      maxClassInput.disabled = false;
    }
  });

  minClassInput.addEventListener('input', maxClassInput.addEventListener('input', function () {
    if (minClassInput.value !== '' || maxClassInput.value !== '') {
      classInput.disabled = true;
      classInput.value = '';
    } else {
      classInput.disabled = false;
    }
  }));
});
</script>
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

</body>
</html>
