<?php
// require_once "../database/database.php";
// require_once "../database/subject.php";
// require_once "../database/book.php";
// $booksTable = new BooksTable();
// $books = $booksTable->getRandomBookByAmount(5);

?>



    <div class="flex justify-center items-center flex-col">

        <div class="bg-gradient-to-b from-[#41cf6f] to-[#f7fdf8] rounded-lg border-2 border-white">
            <div class="Suggesting">
                <h1 id="section">
                    <div class="icon-overlay"></div>
                    <i class='bx bxs-book-open' style='color:#f9f6f6'></i>
                    Gợi ý cho bạn
                </h1>
            </div>
            <?php
            $page=isset($_GET["page"])?(int)$_GET["page"]:1;
            $limit=6;
            $start=($page-1)*$limit;
            if(!empty($_GET["subjectId"])){
                $subjectId=$_GET["subjectId"];
            }
            if(!empty($_GET["Class"])){
                $Class=$_GET["Class"];
            }
            if(!empty($_GET["type"])){
                $type=$_GET["type"];
            }
            $sql="SELECT * FROM books  join subjects on books.subjectId=subjects.id 
            where 1=1 ";
            if(!empty($subjectId)){
                $sql=$sql." and books.subjectId=$subjectId";
            }
            if(!empty($Class)){
                $sql=$sql." and books.class=$Class";
            }
            if(!empty($type)){
                $sql=$sql." and books.type=$type";
            }
            $sql=$sql." limit $start,$limit";

//

            $result=$conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
            ?>
            
            <div class="item">
                <img src="<?php echo $row["imageURL"]?>"
                    alt="Book">
                <h3 class="book-name"><?php echo $row["bookName"];?></h3>
                <div class="price-container">
                    <div class="discount-price"><?php echo $row["currentPrice"]?></div>
                    <span class="giam-gia">-25%</span>
                </div>
                <div class="original-price"><?php echo $row["oldPrice"]?></div>
                <p class="sold">Đã bán 102</p>
            </div>
            <?php
                }
            }
            $total_result=$conn->query("select count(*) as total from books");
            $total_result=$total_result->fetch_assoc();
            $total_pages=ceil($total_result["total"]/$limit);
            for($i=1;$i<$total_pages;$i++){


            ?>
            <div style="display:flex;">
                <div><a href="?page=<?php echo $i;?>"><?php echo $i ;?></a></div>
            </div>
            <?php
            }
            ?>


        </div>

    </div>

                 <?php
                 /*
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

*/
            ?>
