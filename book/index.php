<?php
require_once "../database/database.php";
session_start();
require_once "../database/subject.php";
require_once "../database/book.php";
$bookId = $_GET["bookId"];
if ($bookId == null) {
  header("Location: http://localhost/LTW-UD2/");
} else {
  $bookTable = new BooksTable();
  $book = $bookTable->getBookById($bookId);
  if ($book == null) {
    header("Location: http://localhost/LTW-UD2/");
  }
  $subjectTable = new SubjectsTable();
  $subject = $subjectTable->getSubjectById($book["subjectId"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script defer src="../javascript/counter.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../global.css">
  <link
    href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"
    rel="stylesheet" type='text/css'>


  <!-- Tailwindcss -->
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  
</head>

<body>
<?php include_once "../components/header2.php";?>

  <div class="bg-[#fff1f2] gap-6 flex flex-col p-[7%] items-center">
    <div class="flex flex-col sm:flex-row justify-center w-full gap-6">
      <section class="bg-white rounded-lg p-6 flex-1">
        <img src=<?php echo $book["imageURL"] ?> class="max-h-[600px] w-full object-contain" alt="" />
        <div class="mt-6 flex gap-2">
          <button class="flex-1 border border-red-500 text-red-500 py-2 rounded-lg flex items-center justify-center gap-2">
            🛒 Thêm vào giỏ hàng
          </button>
          <button class="flex-1 bg-red-500 text-white py-2 rounded-lg">
            Mua ngay
          </button>
        </div>


      </section>
      <div class="gap-4 flex flex-col flex-1">
        <section class="bg-white rounded-lg p-6">
          <h1 class="text-2xl font-semibold"><?php echo $book['bookName'] ?></h1>
          <div class="mt-2 text-sm text-gray-700">
            <div class="flex -flex-row justify-between mr-10">
              <div class="flex flex-col gap-2.5">
                <p>
                  <span class="font-medium">Đã bán:</span>
                  <span class="font-bold">
                    <?php echo $book['quantitySold'] ?>
                  </span>
                </p>
                <p>
                  <span class="font-medium">Môn:</span>
                  <span class="font-bold"><?php
                                          echo $subject["subjectName"]
                                          ?></span>
                </p>
              </div>
              <div class="flex flex-col gap-2.5">
                <p>
                  <span class="font-medium">Đánh giá:</span>
                  <span class="font-bold"><?php  ?></span>
                </p>
                <p>
                  <span class="font-medium">Lớp:</span>
                  <span class="font-bold"><?php echo $book["class"] ?></span>
                </p>
              </div>
            </div>
          </div>
          <div class="flex flex-row gap-2.5 items-center">
            <p class="text-[#c92127] font-bold text-[32px]"><?php echo number_format($book["currentPrice"]) ?> đ</p>
            <p class="old-price line-through"><?php echo number_format($book["oldPrice"]) ?> đ</p>
            <div class="discount-percent"><?php $percent = 100 - ($book["currentPrice"] / $book["oldPrice"] * 100);
                                          echo -floor($percent)   ?>%</div>
          </div>
        </section>
        <section class="bg-white rounded-lg p-6">
          <h2>Thông tin chi tiết</h2>
          <div class="flex flex-row gap-4 items-center ">
            <button class="mt-[-5px] rounded-lg bg-gray-200 p-2 text-[24px] h-[30px] flex items-center justify-center cursor-pointer decrement">
              <span class="mt-[-22px]">

                _
              </span>
            </button>
            <p class="counter -mx-[10px]">0</p>
            <button class="increment mt-[-5px] rounded-lg bg-gray-200 p-2 text-[24px] h-[30px] flex items-center justify-center cursor-pointer ">+</button>

          </div>
          <div class="mt-6 flex gap-2">
            <button class="flex-1 cursor-pointer border border-red-500 text-red-500 py-2 rounded-lg flex items-center justify-center gap-2">
              🛒 Thêm vào giỏ hàng
            </button>
            <button class="flex-1 bg-red-500 cursor-pointer text-white py-2 rounded-lg">
              Mua ngay
            </button>
          </div>
          <div class="mt-2 text-sm text-gray-700 max-w-[500px]">
            <?php
            $a = 0;
            while ($a <= 10) {
              echo "<div>hi</div>";
              $a++;
            };
            ?>
          </div>
        </section>

      </div>
    </div>
    <?php
    include_once "../zui/BookReviewsSection.php"
    ?>

  </div>
<?php include_once "../components/footer.php";?>

</body>

</html>