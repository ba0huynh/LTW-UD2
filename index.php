<?php 

require_once("./database/database.php");

$servername="localhost";
$username="root";
$password="";
//$dbname="ltw&ud2";
$dbname="ltd2&ud2";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- custom css -->
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/suggested_book.css">

    <!-- Tailwindcss -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body>

    <?php include_once "./zui/login.php" ?>

    <?php include_once "./zui/header2.php" ?>
   <div class="flex flex-col items-center justify-center w-[80%]>

       <?php
       include_once'./zui/banner.php'
       ?>
       <div class="flex-col flex">
           
           <?php include_once "./zui/suggested_book.php" ?>
           <?php include_once "./zui/footer.php" ?>
        </div>
    </div>


</body>
<script type="module" src="index.js"></script>
</html>