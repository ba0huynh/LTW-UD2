<?php
session_start();
require_once("../database/database.php");
require_once("../database/user.php");
require_once("../database/book.php");
require_once("../database/hoadon.php");
require_once("../database/chitiethoadon.php");
$userTable = new UsersTable();
$bookTable = new BooksTable();
$hoadonTable = new HoadonTable();
$chiTietHoadonTable = new ChiTietHoadonTable();
$user = null;
if (isset($_SESSION["user"]) && $_SESSION["user"] != null) {
  $user = $userTable->getUserDetailsById($_SESSION["user"]);
  if ($user == null) {
    unset($_SESSION["user"]);
  }
}
$top5User = $userTable->getTop5UsersByBooksOrdered();
$allHoaDon = $hoadonTable->getAllHoaDon();
$allUsers = $userTable->getAllUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/layout.css">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <script type="module" src="../javascript/admin/index.js">  </script>


</head>

<body>


  <?php include_once "gui/layout.php" ?>
</body>
</html>