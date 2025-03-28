<?php 

require_once("./database/database.php");
$servername="localhost";
$username="root";
$password="";
$dbname="ltw&ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
?>    
    <?php
    $Class=$_GET['Class'];
    $sql="select * from books,subjects
    where books.subjectId=subjects.id
    and class=$Class";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
    ?>
    <div>
        <div><?php echo $row["subjectName"];?></div>
            <?php
            $subject_id=$row['subjectId'];
            $sql="select type
            from books,subjects
            where books.subjectId=subjects.id and class=$Class
            and subjects.id=$subject_id
            group by subjects.id";
            $result1=$conn->query($sql);
            if($result1->num_rows>0){
                while($row1=$result1->fetch_assoc()){
                    #echo $row1['type'];
            ?>
        <div><?php echo $row1["type"];?></div>
            <?php
                }
            }
            ?> 
    </div>
    <?php
        }
    }
    ?>

    <!-- <div>
        <div>VĂN HỌC</div>
        <div>Tiểu thuyết</div>
        <div>Truyện ngắn</div>
        <div>Light novel</div>
        <div>Ngôn tình</div>
        <div>Xem chi tiết</div>
    </div> *9 -->