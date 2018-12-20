<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
</head>

<?php
   session_start();

   if (!isset($_SESSION["User_Id"])) {
      header("Location: index.php");
   }
   elseif(isset($_SESSION["User_Id"])) {

   include("includes/header.php");
?>

<body>
   <main>
      <?php
         include("search_post.php");
      ?>
   </main>
</body>

<?php
   }
?>
