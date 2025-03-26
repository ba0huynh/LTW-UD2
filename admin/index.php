<?php
session_start();
require_once("../database/database.php");
require_once("../database/user.php");
$userTable = new UsersTable();
$user = null;
if (isset($_SESSION["user"]) && $_SESSION["user"] != null) {
  $user = $userTable->getUserDetailsById($_SESSION["user"]);
  if ($user == null) {
    unset($_SESSION["user"]);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/layout.css">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
    </style>
</head>

<body>

  <?php
  if ($user == null) {
    include_once "../zui/adminLoginPopup.php";
  }
  ?>
  <?php include_once "gui/layout.php" ?>
  <script type="module" src="../javascript/admin/index.js"></script>
</body>

</html>