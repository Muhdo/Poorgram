<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/pesquisa.css">
</head>

<?php
   session_start();

   if (!isset($_SESSION["User_Id"])) {
      header("Location: index.php");
   } elseif(isset($_SESSION["User_Id"]) && !isset($_GET['pesquisa'])) {
      header("Location: index.php");

   } elseif (isset($_SESSION["User_Id"]) && isset($_GET['pesquisa'])) {
      include("includes/header.php");
?>

<body>
   <main>
      <?php
         include("includes/search_users.php");
      ?>
   </main>
</body>

<?php
   }
?>
