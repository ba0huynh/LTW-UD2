<?php
require_once("../database/database.php");

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

<?php include_once "../zui/adminLoginPopup.php" ?>
<?php include_once "gui/layout.php" ?>

</body>

</html>