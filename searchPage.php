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

$servername="localhost";
$username="root";
$password="";
//$dbname="ltw&ud2";
$dbname="ltw_ud2";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
if(!empty($_GET["class"]))
  $class=$_GET["class"];
if(!empty($_GET["subject"]))
  $subject=$_GET["subject"];
if(!empty($_GET["type"]))
  $type=$_GET["type"];


if(!empty($_GET["Optioncost"])){
    $option=$_GET["Optioncost"];
  if($option==1){
    $min_cost=0;
    $max_cost=50000;
  }else if($option==2){
    $min_cost=50000;
    $max_cost=100000;
  }else if($option==3){
    $min_cost=100000;
    $max_cost=200000;
  }
}


if(!empty($_GET["age"]))
  $age=$_GET["age"];
if(!empty($_GET["min_age"]))
  $min_age=$_GET["min_age"];
if(!empty($_GET["max_age"]))
  $max_age=$_GET["max_age"];

if(!empty($_GET["min_cost"]))
  $min_cost=$_GET["min_cost"];
if(!empty($_GET["max_cost"]))
  $max_cost=$_GET["max_cost"];

if(!empty($_GET["search"]))
  $search=$_GET["search"];
$query="select * from books
        ";

if(!empty($subject)){
  $query.="join subjects on books.idSubject=subjects.idSubject where subjects.id=books.subjectId";
}else{
  $query.=" where 1=1";
}
if(!empty($search)){
  $query.=" and books.bookName like '%$search%' ";
}
if(!empty($type)){
  $query.=" and books.type=$type";
}
if(!empty($min_cost) && !empty($max_cost)){
  $query.=" and books.currentPrice>= $min_cost and books.currentPrice<= $max_cost";
}
if(!empty($age)){
  $query.=" and books.classNumber=$age";
}
if(!empty($min_age) && !empty($max_age)){
  $query.=" and books.classNumber>=$min_age and books.classNumber<=$max_age";
}
if(!empty($class)){
    $query.=" and books.classNumber=$class";
}


$sort = $_GET["sort"] ?? null;

if (!empty($sort)) {
    if ($sort === "asc") {
        $query .= " ORDER BY books.currentPrice ASC";
    } elseif ($sort === "desc") {
        $query .= " ORDER BY books.currentPrice DESC";
    }
}

$result=$conn->query($query);
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
                <input name="type" type="text" value="<?php echo htmlspecialchars($_GET["type"]); ?>">
                </h3>
            <?php } ?>

            <div class="accent-blue-500">
                Từ khóa tìm kiếm : 
                <?php if (!empty($_GET["search"])) echo htmlspecialchars($_GET["search"]); ?> <br>
                Kết quả tìm kiếm : (<?php echo $result->num_rows ?? 0; ?>)
            </div>
            </div>

            <!-- Giá -->
            <div class="mb-6">
            <h3 class="font-semibold mb-2">GIÁ</h3>
            <div class="space-y-1">
                <label class="flex items-center gap-2">
                <input type="checkbox" name="Optioncost" value="1" class="accent-blue-500" >
                0đ - 50,000đ
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" name="Optioncost" value="2" class="accent-blue-500">
                50,000đ - 100,000đ
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" name="Optioncost" value="3" class="accent-blue-500">
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
            <h3 class="font-semibold mb-2">LỨA TUỔI</h3>
            <label class="flex items-center gap-2">
                <input name="age_range_check" type="checkbox" class="accent-blue-500">
                <input type="number" name="min_age" placeholder="Từ" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php echo $_GET['min_age'] ?? ''; ?>"> -
                <input type="number" name="max_age" placeholder="Đến" class="w-1/6 border rounded p-1 text-sm"
                    value="<?php echo $_GET['max_age'] ?? ''; ?>">
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
            <!-- Repeat Product Cards as needed -->
          </div>
        </div>

      </main>
    </div>
  </div>
  <?php include_once "./components/footer.php";?>
</body>
</html>
