<?php
   session_start();
   include("connectDB.php");

   $chave = $_POST["chave"];

   $queryPostAutority = $connection->prepare("SELECT * FROM publicacao WHERE Key_Publicacao=:Chave AND Key_Utilizador=:Utilizador");
   $queryPostAutority->bindParam(":Chave", $chave, PDO::PARAM_STR);
   $queryPostAutority->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
   $queryPostAutority->execute();

   if ($queryPostAutority->rowCount() == 0) {
      $queryPostAutority->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   } elseif ($queryPostAutority->rowCount() == 1) {
      $queryPostAutority->closeCursor();

      $queryDeleteLike = $connection->prepare("DELETE FROM gosto WHERE Key_Publicacao=:Chave");
      $queryDeleteLike->bindParam(":Chave", $chave, PDO::PARAM_STR);

      if ($queryDeleteLike->execute()) {
         $queryDeleteLike->closeCursor();

         $queryDeleteComments = $connection->prepare("DELETE FROM comentario WHERE Key_Publicacao=:Chave");
         $queryDeleteComments->bindParam(":Chave", $chave, PDO::PARAM_STR);

         if ($queryDeleteComments->execute()) {
            $queryDeleteComments->closeCursor();

            $queryDeletePost = $connection->prepare("DELETE FROM publicacao WHERE Key_Publicacao=:Chave AND Key_Utilizador=:Utilizador");
            $queryDeletePost->bindParam(":Chave", $chave, PDO::PARAM_STR);
            $queryDeletePost->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);

            if ($queryDeletePost->execute()) {
               $queryDeletePost->closeCursor();
               $connection = null;

               echo "Del";
               exit();
            } else {
               $queryDeletePost->closeCursor();
               $connection = null;

               echo "Error";
               exit();
            }
         } else {
            $queryDeleteComments->closeCursor();
            $connection = null;

            echo "Error";
            exit();
         }
      } else {
         $queryDeleteLike->closeCursor();
         $connection = null;

         echo "Error";
         exit();
      }
   } else {
      $queryPostAutority->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   }

   $connection = null;

   echo "Error";
   exit();
?>
