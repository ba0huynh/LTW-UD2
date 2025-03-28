<?php 

require_once("./database/database.php");
<<<<<<< Updated upstream
require_once("./database/book.php");
require_once("./database/subject.php");
$booksTable = new BooksTable();
=======
$servername="localhost";
$username="root";
$password="";
$dbname="ltw&ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream

    <!-- Tailwindcss -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
=======
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href=".css/login.css">
    <style>
        .tablinks{
            padding:10px;
            color:#1e1e1e;
            font-weight: bold;
            /* color:aqua; */
        }
        .inputHeader>input{
            outline:none;
        }
        #menuLogo:hover{
            cursor:pointer;
        }
        .menuContent{
            display:none;
        }
    </style>
>>>>>>> Stashed changes
</head>

<body>

    <?php include_once "./zui/login.php" ?>
    <?php include_once "./zui/header.php" ?>
    <?php include_once "./zui/suggested_book.php" ?>
    <?php include_once "./zui/footer.php" ?>
    <?php include_once "./components/Navbar.php" ?>


</body>
<script type="module" src="index.js"></script>
</html>