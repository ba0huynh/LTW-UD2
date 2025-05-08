
<?php 
session_start();
require_once("./database/database.php");

$servername="localhost";
$username="root";
$password="";
$dbname="ltw_ud2";
$conn=new mysqli($servername,$username,$password,$dbname,3306);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['login'])) {
    $phone = $_POST['user_telephone'];
    $password = $_POST['user_password'];

    $query = "SELECT * FROM users WHERE phoneNumber = '$phone'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($result && mysqli_num_rows($result) > 0) {
        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Sai mật khẩu!');</script>";
        }
    } else {
        echo "<script>alert('Sai số điện thoại!');</script>";
    }
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

    <link rel="stylesheet" href="./css/suggested_book.css">

    <!-- Tailwindcss -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body>
<?php include_once "./components/header2.php";?>
<div class="min-h-screen flex items-center justify-center">
  <div class="w-[80%] flex flex-col items-center">
    <div class="flex flex-col">
      <?php include_once "./zui/suggested_book.php" ?>
      
    </div>
  </div>
</div>
<?php include_once "./components/footer.php";?>



</body>
<script type="module" src="index.js"></script>
</html>