<?php
require_once "../database/database.php";
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
    </style>
</head>

<body>

  <div class="bg-[#fff1f2]">
    <div class="flex flex-row justify-center gap-6 p-6">
      <section class="bg-white rounded-lg p-6">
        <img src="" alt="" />
        <div class="mt-6 flex gap-2">
          <button class="flex-1 border border-red-500 text-red-500 py-2 rounded-lg flex items-center justify-center gap-2">
            🛒 Thêm vào giỏ hàng
          </button>
          <button class="flex-1 bg-red-500 text-white py-2 rounded-lg">
            Mua ngay
          </button>
        </div>

        <div class="mt-6">
          <h3 class="font-bold text-gray-900">
            Chính sách ưu đãi của Fahasa
          </h3>
          <ul class="mt-2 space-y-2 text-sm text-gray-700">
            <li class="flex items-center gap-2">
              🚚 <strong>Thời gian giao hàng:</strong> Giao nhanh và uy tín
            </li>
            <li class="flex items-center gap-2">
              🔄 <strong>Chính sách đổi trả:</strong> Đổi trả miễn phí toàn
              quốc
            </li>
            <li class="flex items-center gap-2">
              🏬 <strong>Chính sách khách sỉ:</strong> Ưu đãi khi mua số lượng
              lớn
            </li>
          </ul>
        </div>
      </section>
      <div class="gap-4 flex flex-col max-w-[60%]">
        <section class="bg-white rounded-lg p-6">
          <h1 class="text-2xl font-semibold"><?php echo $book['bookName'] ?></h1>
          <div class="mt-2 text-sm text-gray-700">
            <div class="flex -flex-row justify-between mr-10">
              <div class="flex flex-col gap-2.5">
                <p>
                  <span class="font-medium">Nhà cung cấp:</span>
                  <span class="text-blue-600">NXB Trẻ</span>
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
                  <span class="font-medium">Tác giả:</span>
                  <span class="font-bold">Hajime Isayama</span>
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
  </div>

</body>

</html>