<!DOCTYPE html>
<html lang="pt">
   <head>
      <meta charset="utf-8">
      <title> Poorgram </title>
      <link rel="stylesheet" type="text/css" href="style/style.css">
   </head>
   <body>
      <?php
         session_start();

         if (!isset($_SESSION["User_Id"])) {
            header("Location: registar.php");
         }
         elseif(isset($_SESSION["User_Id"])) {
            header("Location: main.php");
         }
       ?>
   </body>
</html>
