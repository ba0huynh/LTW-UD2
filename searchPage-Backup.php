<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LTW_UD2</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./css/login.css">
<link rel="stylesheet" href="./css/header.css">
</head>
<?php
require_once("./database/database.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ltw_ud2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

// Get filter values
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

$query = "SELECT books.* FROM books ";

if (!empty($subject)) {
    $query .= "LEFT JOIN subjects ON books.idSubject = subjects.idSubject WHERE 1=1 ";
} else {
    $query .= "WHERE 1=1 ";
}


if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND bookName LIKE '%$search%' ";
}

if (!empty($type)) {
    $query .= " AND books.type = " . (int)$type;
}
if (!empty($min_cost) && !empty($max_cost)) {
    $query .= " AND books.currentPrice BETWEEN $min_cost AND $max_cost ";
}
if (!empty($class)) {
    $query .= " AND books.classNumber = " . (int)$class;
}
if (!empty($min_class) && !empty($max_class)) {
    $query .= " AND books.classNumber BETWEEN $min_class AND $max_class ";
}

$sort = $_GET["sort"] ?? null;
if (!empty($sort)) {
    if ($sort === "asc") {
        $query .= " ORDER BY books.currentPrice ASC";
    } elseif ($sort === "desc") {
        $query .= " ORDER BY books.currentPrice DESC";
    }
}

$result = $conn->query($query);
?>

<body class="bg-gray-100 text-gray-800">
  <?php
  include './components/header2.php'
  ?>

  <div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-12 gap-6">
      <!-- Sidebar -->
      <form action="searchPage.php" method="GET" class="col-span-3 bg-white rounded-2xl shadow p-4">
        <aside class="col-span-3 bg-white rounded-2xl shadow p-4">
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
                Từ khóa tìm kiếm : 
                <?php if (!empty($_GET["search"])) echo htmlspecialchars($_GET["search"]); ?> <br>
                <input type="hidden" name="search" value="<?php if (!empty($_GET["search"])) echo htmlspecialchars($_GET["search"]); ?>">
                Kết quả tìm kiếm : (<?php echo $result->num_rows ?? 0; ?>)
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
              <div class="mt-4">
                <input name="min_cost" type="number" placeholder="0" class="w-1/4 border rounded p-1 text-sm"
                    value="<?php echo $_GET['min_cost'] ?? ''; ?>"> - 
                <input name="max_cost" type="number" placeholder="0" class="w-1/4 border rounded p-1 text-sm"
                    value="<?php echo $_GET['max_cost'] ?? ''; ?>">
              </div>
            </div>

            <!-- Lứa tuổi -->
            <div class="mb-6">
              <h3 class="font-semibold mb-2">Nhập lớp</h3>
              <label class="flex items-center gap-2">
                
                <input type="number" name="min_class" placeholder="Từ" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php echo $_GET['min_class'] ?? ''; ?>"> -
                <input type="number" name="max_class" placeholder="Đến" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php echo $_GET['max_class'] ?? ''; ?>">
              </label>
              <label class="flex items-center gap-2 mt-2">
                Nhập lớp : 
                <input type="text" name="class" value="<?php echo $_GET['class'] ?? ''; ?>" class="w-1/6 border rounded p-1 text-sm">
              </label>
            </div>

            <button type="submit" class="bg-[#D10024] px-4 text-white m-2 rounded">Tìm kiếm</button>
        </aside>
      </form>


      <!-- Main Content -->
      <main class="col-span-9">


        <!-- Products Grid -->
        <div class="bg-white rounded-2xl shadow p-4 min-h-full">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">KẾT QUẢ TÌM KIẾM: <span class="text-blue-500"> <?php if(!empty($search)) echo $search ;?> (<?php echo $result->num_rows;?> kết quả)</span></h2>
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
            echo "so luong ".$result->num_rows;
            if($result->num_rows>0){
              while($row=$result->fetch_assoc()){
            ?>
            <div class="bg-white rounded-2xl shadow p-2">
              <img src="<?php echo $row['imageURL'];?>" alt="Book" class="rounded-xl mx-auto mb-2">
              <h3 class="text-sm font-semibold mb-1"><?php echo $row['bookName'];?></h3>
              <div class="text-red-600 font-semibold"><?php echo $row['currentPrice'];?>đ <span class="text-xs text-gray-500 line-through"><?php echo $row['oldPrice'];?> đ</span></div>
            </div>
            <?php
              }
            }
            ?>
          </div>
        </div>

      </main>
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

</body>
</html>
