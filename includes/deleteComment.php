<?php
   session_start();
   include("connectDB.php");

   $chave = $_POST["chave"];

   $queryCommentAutority = $connection->prepare("SELECT * FROM comentario WHERE Key_Comentario=:Chave AND Key_Utilizador=:Utilizador");
   $queryCommentAutority->bindParam(":Chave", $chave, PDO::PARAM_STR);
   $queryCommentAutority->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
   $queryCommentAutority->execute();

   if ($queryCommentAutority->rowCount() == 0) {
      $queryCommentAutority->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   } elseif ($queryCommentAutority->rowCount() == 1) {
      $queryCommentAutority->closeCursor();

      $queryDeleteComment = $connection->prepare("DELETE FROM comentario WHERE Key_Comentario=:Chave AND Key_Utilizador=:Utilizador");
      $queryDeleteComment->bindParam(":Chave", $chave, PDO::PARAM_STR);
      $queryDeleteComment->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryDeleteComment->execute();

      $queryDeleteComment->closeCursor();
      $connection = null;

      echo "Del";
      exit();
   } else {
      $queryCommentAutority->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   }
?>
