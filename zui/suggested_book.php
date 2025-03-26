<?php
// require_once "../database/database.php";
// require_once "../database/subject.php";
// require_once "../database/book.php";
// $booksTable = new BooksTable();
// $books = $booksTable->getRandomBookByAmount(5);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="../css/suggested_book.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>


    <div class="wrapped">

        <div class="container">
            <div class="Suggesting">
                <h1 id="section">
                    <div class="icon-overlay"></div>
                    <i class='bx bxs-book-open' style='color:#f9f6f6'></i>
                    Gợi ý cho bạn
                </h1>
            </div>


            <?php
            $books = $booksTable->getRandomBookByAmount(5);
            foreach ($books as $book) {
                $bookName = $book["bookName"];
                $bookId = $book["id"];
                $currentPrice = number_format($book["currentPrice"]);
                $oldPrice = number_format($book["oldPrice"]);
                $imageURL = $book["imageURL"];
                $quantitySold = $book["quantitySold"];
                $percent = round((($book["oldPrice"] - $book["currentPrice"]) / $book["oldPrice"]) * 100);
                echo "
<a href='http://localhost/LTW-UD2/book/?bookId=$bookId'>
    
<div class='item'>
<img src=$imageURL
                                   alt='Book'>
                               <h3 class='book-name'>$bookName</h3>
                               <div class='price-container'>
                                   <div class='discount-price'>$currentPrice đ</div>
                                   <span class='giam-gia'>$percent%</span>
                                   </div>
                                   <div class='original-price'>$oldPrice đ</div>
                                   <p class='sold'>Đã bán $quantitySold</p>
                                   </div>
                                   </a>
               ";
            }


            ?>

        </div>

    </div>
</body>

</html>